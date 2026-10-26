<?php

use noicms\mongogrid\system_core\MGQuery;

require_once PATH_TO_ENGINE . "/vendor/noistudio/noiframework/mongogrid/core/simple_html_dom.php";

class Viewapp {

    public $site_data;
    public $plugins;
    public $themes_path = "";
    public $array_plugins = array();
    public $plugins_run = array();
    public $var_data = array();
    public $view_name = "main.php";
    public $view_name_tpl = "main.tpl";
    public $all_run_plugin = false;
    public $route = "";
    public $path_route = "";
    public $path_view = "";
    public $istpl = false;
    public $pre_data;
    public $result_html = "";
    public $cache_value = false;
    public $cache_id;

    public function str_get_html($str, $lowercase = true, $forceTagsClosed = true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT) {
        $dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
        if (empty($str) || strlen($str) > MAX_FILE_SIZE) {
            $dom->clear();
            return false;
        }
        $dom->load($str, $lowercase, false);
        return $dom;
    }

    public function init($site, $route, $path_route) {
        if (isset($site['disabled']) and $site['disabled'] == 1) {
            echo "please pay";
            exit;
        }
        $get = array();
        if (count($_GET)) {
            foreach ($_GET as $key => $val) {
                if (!is_array($val)) {
                    $get[$key] = $val;
                }
            }
        }


        $this->cache_id = $site['_id']->__toString() . "_" . $path_route . "_" . implode("_", $get);
        $this->cache_value = \Yii::$app->cache->get($this->cache_id);
        if (YII_CACHE_ENABLE == FALSE) {
            $this->cache_value = false;
        }
        $this->themes_path = str_replace("/", ".", THEMES_PATH);



        if (isset($site['_id'])) {


            if (isset($site['route']) and is_array($site['route']) and count($site['route']) > 0) {
                foreach ($site['route'] as $key_route) {
                    if (isset($key_route['seo']) and isset($key_route['normal'])) {
                        if ($path_route == $key_route['seo']) {
                            $path_route = $key_route['normal'];
                        }
                        $path_route = str_replace($key_route['seo'], $key_route['normal'], $path_route);
                    }
                }
            }
            $this->site_data = $site;
            NoiCore::events()->execute('change_theme', array());
            $this->site_data = NoiCore::app()->site_data;

            if (file_exists(DOCUMENT_ROOT . "/conf/config.php")) {
                include(DOCUMENT_ROOT . "/conf/config.php");

                if (isset($config['api_site_id']) and DB_TYPE == "mongolite") {

                    $this->site_data['_id'] = new MongoLite\MongoId($config['api_site_id']);
                }
            }
//    print_r($this->site_data);
//    exit;
            $this->var_data = array('site' => $this->site_data);
            $this->route = $route;
            $this->path_route = $path_route;
            NoiCore::route()->set($path_route);
            if (isset($this->site_data['route_site']) and $this->site_data['route_site'] != "" and $this->site_data['route_site'] != "/") {
                $this->path_route = str_replace($site['route_site'], "/", $this->path_route);
            }


            if ($this->cache_value === false or $this->cache_value == NULL) {
                $this->get_config_var();
            }

            $this->sortPluginsbyRoute();
            $this->get_component();
        }
        return $this;
    }

    public function get_all_tpl_in_folder($folder) {
        $result_files = array();
        $name_folder = $folder;
        $folder = DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/tpl/" . $folder;

        if (is_dir($folder)) {
            $allfiles = scandir($folder);

            if (isset($allfiles) and is_array($allfiles) and count($allfiles) > 0) {
                foreach ($allfiles as $file) {
                    $tmp_replc = str_replace(".tpl", "", $file);
                    $tmp_replc2 = str_replace("_back", "", $file);
                    if ($tmp_replc != $file and $tmp_replc2 == $file) {
                        $result_files[] = $file;
                    }
                }
            }
        } else {

            $folder = DOCUMENT_ROOT . THEMES_PATH . "" . $this->site_data['type_site'] . "/" . $this->site_data['theme_site'] . "/tpl/" . $name_folder;
            if (is_dir($folder)) {
                $allfiles = scandir($folder);

                if (isset($allfiles) and is_array($allfiles) and count($allfiles) > 0) {
                    foreach ($allfiles as $file) {
                        $tmp_replc = str_replace(".tpl", "", $file);
                        $tmp_replc2 = str_replace("_back", "", $file);
                        if ($tmp_replc != $file and $tmp_replc2 == $file) {
                            $result_files[] = $file;
                        }
                    }
                }
            }
        }
        return $result_files;
    }

    public function get_render() {

        $result = $this->render();

        $this->result_html = $result;
        $old_result = $result;
        if ($this->all_run_plugin == false) {
            if (isset($this->plugins_run['all']) and count($this->plugins_run['all']) > 0) {
                foreach ($this->plugins_run['all'] as $run_plugin) {

                    $result .= $this->get_plugin($run_plugin);
                    if ($this->result_html != $old_result) {
                        $result = $this->result_html;
                    }
                }
            }
            $this->all_run_plugin = true;
        }

        return $result;
    }

    public function plugins_tags($html) {
        return $html;
        if (strlen($html) > 0) {
            $rend = $this->str_get_html($html);


            foreach ($rend->find('plugin') as $element) { //выборка всех тегов img на странице
                $params = array();
                $name_plugin = $element->innertext;
                $upname = ucfirst($name_plugin);
                $src_plugin = "<plugin";

                foreach ($element->attr as $attr => $value) {
                    $src_plugin = $src_plugin . ' ' . $attr . '="' . $value . '"';
                    $params[$attr] = $value;
                }
                $src_plugin = $src_plugin . ">" . $name_plugin . "</plugin>";

                if (!isset($params['controller']) and ! isset($params['action'])) {
                    $html_plugin = "";
                } else {
                    $html_plugin = $this->get_plugin($name_plugin, array($params['controller'], $params['action']));
                }
                $element->innertext = $html_plugin;
                $element->tag = "div";
                //$html=  str_replace($src_plugin, $html_plugin, $html);
            }
        }
        return $rend;
    }

    public function short_tags($html) {
        if (isset($this->site_data['tag_short_disable']) and $this->site_data['tag_short_disable'] == 1) {
            return $html;
        }
        if (strlen($html) > 0) {
            $html = (string) $html;
            $html = str_replace("[short", "<short", $html);
            $html = str_replace("][/short]", "></short>", $html);
            $rend = $this->str_get_html($html);


            foreach ($rend->find('short') as $element) { //выборка всех тегов img на странице
                $params = array();
                $format_result = $element->innertext;

                $src_plugin = "<widget";
                $html_plugin = "";

                foreach ($element->attr as $attr => $value) {
                    $src_plugin = $src_plugin . ' ' . $attr . '="' . $value . '"';
                    $params[$attr] = $value;
                }
                $src_plugin = $src_plugin . ">" . $format_result . "</widget>";

                if (isset($params['position'])) {
                    $name_plugin = $params['position'];
                }

                $result = $this->get_plugin($params['name'], explode("/", $params['link']), 0);


                $html_plugin = $result;

//           if($name_plugin=="main_page"){
//echo $element;
//exit;
// }
                $element->outertext = $html_plugin;
                $element->attr = array();
                //$element->tag="div";
                //    $element=null;
                //   $element=$html_plugin;
                // $html=  str_replace($element, $html_plugin, $html);
            }
        }
        if (!isset($rend)) {
            $rend = "";
        }
        return $rend;
    }

    public function widget_tags($html) {
        if (isset($this->site_data['tag_widget_disable']) and $this->site_data['tag_widget_disable'] == 1) {
            return $html;
        }
        if (strlen($html) > 0) {
            $rend = $this->str_get_html($html);



            foreach ($rend->find('widget') as $element) { //выборка всех тегов img на странице
                $params = array();
                $format_result = $element->innertext;

                $src_plugin = "<widget";
                $html_plugin = "";

                foreach ($element->attr as $attr => $value) {
                    $src_plugin = $src_plugin . ' ' . $attr . '="' . $value . '"';
                    $params[$attr] = $value;
                }
                $src_plugin = $src_plugin . ">" . $format_result . "</widget>";

                if (isset($params['position'])) {
                    $name_plugin = $params['position'];
                }


                if (isset($name_plugin) and strlen($name_plugin) > 0) {
                    if (isset($this->site_data['theme_components']['widgets']['position'][$name_plugin]) and is_array($this->site_data['theme_components']['widgets']['position'][$name_plugin]) and count($this->site_data['theme_components']['widgets']['position'][$name_plugin]) > 0) {
                        $current_pos = $this->site_data['theme_components']['widgets']['position'][$name_plugin];


                        foreach ($current_pos as $key => $plugin) {
                            if ($plugin['show'] == "1" and isset($plugin['params']) and isset($plugin['name'])) {
                                if ($this->checkAccessWidget($plugin)) {

                                    $result = $this->get_plugin($plugin['name'], $plugin['params'], 1, array('position' => $name_plugin, 'number' => $key));
                                    $class = "";
                                    $title = "";
                                    $current_id = $plugin['name'] . "_" . $key;
                                    if (isset($plugin['options']['id'])) {
                                        $current_id = $plugin['options']['id'];
                                    }
                                    if (isset($plugin['options']['title'])) {
                                        $title = $plugin['options']['title'];
                                    }
                                    if (isset($plugin['options']['class'])) {
                                        $class = $plugin['options']['class'];
                                    }

                                    $img_test = str_replace("%%img_widget%%", "", $format_result);

                                    $current_result = str_replace("%%widget%%", $result, $format_result);

                                    $current_result = str_replace("%%name_widget%%", $title, $current_result);
                                    $current_result = str_replace("%%class_widget%%", $class, $current_result);
                                    $current_result = str_replace("%%idwidget%%", $current_id, $current_result);
                                    if ($img_test != $format_result) {
                                        preg_match('/src="([^"]*)"/i', $result, $array_match);
                                        if (isset($array_match[1])) {
                                            $current_result = str_replace("%%img_widget%%", $array_match[1], $current_result);
                                        }
                                    }
                                    $html_plugin .= $current_result;
                                }
                            }
                        }
                    }
                }

                $html_plugin = str_replace("%%widget%%", "", $html_plugin);
                $html_plugin = str_replace("%%idwidget%%", "", $html_plugin);
//           if($name_plugin=="main_page"){
//echo $element;
//exit;
// }
                $element->outertext = $html_plugin;
                $element->attr = array();
                //$element->tag="div";
                //    $element=null;
                //   $element=$html_plugin;
                // $html=  str_replace($element, $html_plugin, $html);
            }
        }
        if (!isset($rend)) {
            $rend = "";
        }
        return $rend;
    }

    public function checkAccessWidget($plugin) {

        if (isset($plugin['options'])) {
            $available_access = array('all', 'auth', 'noauth');
            $list_all_role = NoiCore::app()->getListRoles();

            if (isset($list_all_role) and is_array($list_all_role) and count($list_all_role) > 0) {
                foreach ($list_all_role as $s_role) {
                    $available_access[] = $s_role;
                }
            }

            if (isset($plugin['options']['language'])) {
                $cur_lang = NoiCore::app()->getLang();
                if ($plugin['options']['language'] != $cur_lang) {
                    return false;
                }
            }
            if (isset($plugin['options']['access'])) {
                if (in_array($plugin['options']['access'], $available_access)) {
                    $islogin = NoiCore::user()->isLogin();
                    $getrole = NoiCore::user()->getLogged("role");
//    $getrole=  UsersUserComponent::getLogged("role",$this->site_data['_id']->__toString());

                    if ($plugin['options']['access'] == "auth" and $islogin == false) {
                        return false;
                    } else if ($plugin['options']['access'] == "noauth" and $islogin == true) {
                        return false;
                    } else if ($plugin['options']['access'] != "all") {

                        if ($plugin['options']['access'] == "noauth" and $islogin == false) {
                            return true;
                        }
                        if ($plugin['options']['access'] == "auth" and $islogin == true) {
                            return true;
                        }
                        if (is_array($getrole) and in_array($plugin['options']['access'], $getrole)) {
                            
                        } else {
                            return false;
                        }
                    }
                }
            }
            if (isset($plugin['options']['visible_all']) and $plugin['options']['visible_all'] == "1") {
                return true;
            }
            $result_visible = false;
            if (isset($plugin['options']['visible']) and is_array($plugin['options']['visible']) and count($plugin['options']['visible']) > 0) {
                $path_route = $this->path_route;
                ;

                if ($path_route == "") {
                    $path_route = "/";
                }

                foreach ($plugin['options']['visible'] as $vis) {
                    if (isset($vis['link'])) {
                        $tmp_link = str_replace($vis['link'], "", $path_route);
                        if (strripos($path_route, $vis['link']) === false and $tmp_link == $path_route) {
                            
                        } else {
                            $result_visible = true;
                        }
                    }
                }
            }

            if (isset($plugin['options']['invisible']) and is_array($plugin['options']['invisible'])) {

                foreach ($plugin['options']['invisible'] as $visd) {
                    if (isset($visd['link'])) {
                        $path_route = $this->path_route;
                        ;

                        if (strripos($path_route, $visd['link']) === false) {
                            
                        } else {
                            $result_visible = false;
                        }
                    }
                }
            }
        }


        return $result_visible;
    }

    public function position_tags($html) {
        return $html;
        if (strlen($html) > 0) {
            $rend = $this->str_get_html($html);


            foreach ($rend->find('position') as $element) { //выборка всех тегов img на странице
                $params = array();
                $name_plugin = $element->innertext;
                $upname = ucfirst($name_plugin);
                $src_plugin = "<position";
                $html_plugin = "";

                $src_plugin = $src_plugin . ">" . $name_plugin . "</position>";
                if (isset($name_plugin) and strlen($name_plugin) > 0) {
                    if (isset($this->site_data['theme_components']['widgets']['position'][$name_plugin]) and is_array($this->site_data['theme_components']['widgets']['position'][$name_plugin]) and count($this->site_data['theme_components']['widgets']['position'][$name_plugin]) > 0) {
                        $current_pos = $this->site_data['theme_components']['widgets']['position'][$name_plugin];


                        foreach ($current_pos as $key => $plugin) {
                            if ($plugin['show'] == "1" and isset($plugin['params']) and isset($plugin['name'])) {
                                $result = $this->get_plugin($plugin['name'], $plugin['params'], 1, array('position' => $name_plugin, 'number' => $key));

                                $html_plugin .= "<div>" . $result . "</div>";
                            }
                        }
                    }
                }

                //$html=  str_replace($src_plugin, $html_plugin, $html);
                $element->innertext = $html_plugin;
                $element->tag = "div";
            }
        }
        return $rend;
    }

    public function link_tags($html) {
        $available_sub = array();
        return $html;
        if (NOIPRODUCT_FOLDER != "noiproduct") {
            if (strlen($html) > 0) {
                $rend = $this->str_get_html($html);


                foreach ($rend->find('link') as $key => $element) { //выборка всех тегов img на странице
                    $params = array();
                    $format_result = $element->innertext;

                    $src_plugin = "<link";
                    $html_plugin = "";

                    foreach ($element->attr as $attr => $value) {
                        $src_plugin = $src_plugin . ' ' . $attr . '="' . $value . '"';
                        $params[$attr] = $value;
                    }
                    $src_plugin = "/>";

                    if (isset($params['href']) and strlen($params['href']) > 0) {

                        $pos = strrpos($params['href'], ".css");
                        $pos2 = strrpos($params['href'], "ttp://");
                        if ($pos === false) {
                            // not found...
                        } else {
                            if ($pos2 === false) {
                                // $new_subdomain="http://stat".rand(0,99999).".".\Yii::$app->params['main_url']."/";
                                // $element->attr['href']=$this->str_replace_limit("/", $new_subdomain,$params['href']);
                            }
                        }
                    }
                }



                return $rend;
            }
        } else {
            return $html;
        }
    }

    function str_replace_limit($search, $replace, $string, $limit = 1) {
        if (is_bool($pos = (strpos($string, $search))))
            return $string;

        $search_len = strlen($search);

        for ($i = 0; $i < $limit; $i++) {
            $string = substr_replace($string, $replace, $pos, $search_len);

            if (is_bool($pos = (strpos($string, $search))))
                break;
        }
        return $string;
    }

    public function script_tags($html) {
        $available_sub = array();
        return $html;
        if (NOIPRODUCT_FOLDER != "noiproduct") {
            if (strlen($html) > 0) {
                $rend = $this->str_get_html($html);


                foreach ($rend->find('script') as $element) { //выборка всех тегов img на странице
                    $params = array();
                    $format_result = $element->innertext;

                    $src_plugin = "<script";
                    $html_plugin = "";

                    foreach ($element->attr as $attr => $value) {
                        $src_plugin = $src_plugin . ' ' . $attr . '="' . $value . '"';
                        $params[$attr] = $value;
                    }

                    if (isset($params['src']) and strlen($params['src']) > 0) {

                        $pos = strrpos($params['src'], ".js");
                        $pos2 = strrpos($params['src'], "ttp://");
                        if ($pos === false) {
                            // not found...
                        } else {
                            if ($pos2 === false) {
                                $new_subdomain = "http://stat" . rand(0, 99999) . "." . \Yii::$app->params['main_url'] . "/";
                                $element->attr['src'] = $this->str_replace_limit("/", $new_subdomain, $params['src']);
                            }
                        }
                    }
                }

                // $html=  str_replace($element, $html_plugin, $html);
                return $rend;
            }
        } else {
            return $html;
        }
    }

    public function add_header($html) {
        $tmp = $this->system_render(DOCUMENT_ROOT . "/themes/header/noiproduct/views/layouts/main.php", array('site_data' => $this->site_data));
        $html = str_replace("</head>", "</head>" . $tmp, $html);
        return $html;
    }

    public function return_render() {

//$render=$this->include_tags($render);

        if (YII_CACHE_ENABLE == TRUE) {
            $this->cache_value = Yii::app()->cache->get($this->cache_id);

            if (($this->cache_value === false or ! isset($this->cache_value)) or YII_CACHE_ENABLE == FALSE) {
                $result = $this->render_page();

                Yii::app()->cache->set($this->cache_id, $result, YII_CACHE_TIME);
            } else {

                $result = $this->cache_value;
            }
            /// $result=str_replace("<script","<script async",$result);
            return $result;
        } else {
            return $this->render_page();
        }
    }

    public function render_page() {
        $isjson = NoiCore::app()->getParam("return_json");
        if (isset($isjson) and $isjson == 1) {

            $this->get_component();
            exit;
        }
        $render = $this->get_render();

        if (isset($this->site_data['theme_components']['plugins'])) {

            $render = $this->plugins_tags($render);
            $render = $this->position_tags($render);
            if (isset($this->site_data['theme_components']['widgets'])) {
                $render = $this->widget_tags($render);
            }
            $render = $this->short_tags($render);
        }
        $render = $this->link_tags($render);
        $render = $this->script_tags($render);
        $render = NoiCore::route()->replace($render);
        $render = NoiCore::custom()->doReplace($render);
//$render=$this->add_header($render);
        return $render;
    }

    public function config($var) {
        if (isset($this->site_data['theme_components']['settings']['mongogrid'][$var]['value'])) {
            return $this->site_data['theme_components']['settings']['mongogrid'][$var]['value'];
        } else if (isset($this->site_data['theme_components']['settings']['options']['fields'][$var]['value'])) {
            return $this->site_data['theme_components']['settings']['options']['fields'][$var]['value'];
        } else {
            return "";
        }
    }

    public function get_config_var() {
        if (isset($this->site_data['theme_config'])) {
            foreach ($this->site_data['theme_config'] as $key => $value) {

                $value_arr = array();
                if ($value['count'] == 1) {
                    if (isset($this->site_data['value'][$key][0])) {
                        $this->var_data['theme_' . $key] = $this->site['value'][$key][0];
                    } else {
                        $this->var_data['theme_' . $key] = "";
                    }
                } else {
                    if (isset($this->site_data['value'][$key])) {
                        $this->var_data['theme_' . $key] = $this->site_data['value'][$key];
                    } else {
                        $this->var_data['theme_' . $key] = array();
                    }
                }
            }
        }
    }

    public function get_component($tmp_name = "") {






        $param = array();
        if (isset($this->path_route) and $this->path_route != "") {
            $tmp_var = explode("/", $this->path_route);

            if (!isset($tmp_var[1]) and isset($tmp_var[0])) {
                $this->route = $tmp_var[0];
            }
            if (isset($tmp_var[1])) {
                $this->route = $tmp_var[1];
            }

            if (isset($tmp_var[2])) {
                $param[count($param)] = $tmp_var[2];
            }
            if (isset($tmp_var[3])) {
                $param[count($param)] = $tmp_var[3];
            }
        }
        $tmp_param = explode("/", $this->path_route);
        $new_tmp_param = array();
        if (is_array($tmp_param) and count($tmp_param) > 0) {
            foreach ($tmp_param as $n_param) {
                if (strlen($n_param) > 0) {
                    $new_tmp_param[] = $n_param;
                }
            }
        }
        if (count($new_tmp_param) > 0) {
            
        }



        if ($this->route == "") {
            $this->route = "default";
        }
        if ($this->route != "") {

            $search_plugin = $this->doSearchPlugin($this->route);

            if (isset($this->plugins[$this->route]) and in_array($this->plugins[$this->route], $this->plugins_run["route"])) {
                $tmp_route = str_replace("/" . $this->plugins[$this->route] . "/", "", $this->path_route);
                $param_new = explode("/", $tmp_route);
                $new_url = $this->plugins[$this->route] . "/" . $tmp_route;
                NoiCore::route()->replace("  ");
                $result_plugin = $this->get_plugin2($this->plugins[$this->route], $new_url);
                ;
                $isjson = NoiCore::app()->getParam("return_json");
                if (isset($isjson) and $isjson == 1) {
                    echo $result_plugin;
                    exit;
                }
//    $this->get_plugin($this->plugins[$this->route],$new_tmp_param);;
                if (isset(\Yii::$app->params['uc_page'])) {
                    $parent_name = $this->route;
                    if (isset(\Yii::$app->params['uc_page_type'])) {
                        $parent_name = \Yii::$app->params['uc_page_type'];
                    }

                    if (strlen(\Yii::$app->params['uc_page']) > 0) {
                        $this->view_name = "component/" . $parent_name . "_" . \Yii::$app->params['uc_page'] . ".php";
                        $this->view_name_tpl = "component/" . $parent_name . "_" . \Yii::$app->params['uc_page'] . ".tpl";
                    } else {
                        $this->view_name = "component/" . $parent_name . ".php";
                        $this->view_name_tpl = "component/" . $parent_name . ".tpl";
                    }
                }
            } else {

                if ($this->route == "widgets") {
                    $this->var_data['component'] = NoiCore::c("widgets")->runAction($this);
                }
            }
        }
    }

    public function get_paginator($url, $count, $limit, $current_page = 0, $type = "offset") {
        // Array to store page link list



        $noipage = new NoiPage();
        $noi_array_page = $noipage->calculate_pages($count, $limit, $current_page);

        return $noi_array_page;
    }

    public function sortPluginsbyRoute() {
        if (isset($this->site_data['theme_components']['plugins']['available'])) {
            $plugins = $this->site_data['theme_components']['plugins']['available'];
            if (is_array($plugins) and count($plugins) > 0) {
                foreach ($plugins as $plugin) {
                    if (file_exists(YII_PLUGIN_PATH . "" . $plugin . "/config.php")) {
                        include_once(YII_PLUGIN_PATH . "" . $plugin . "/config.php");

                        if ($plugin_config['type_run'] != "all") {
                            $this->plugins[$plugin_config['route']] = $plugin;
                        }
                        if (!isset($this->plugins_run[$plugin_config['type_run']])) {
                            $this->plugins_run[$plugin_config['type_run']] = array($plugin);
                        } else {
                            $this->plugins_run[$plugin_config['type_run']][count($this->plugins_run[$plugin_config['type_run']])] = $plugin;
                        }
                        $this->array_plugins[count($this->array_plugins)] = $plugin;
                    }
                }
            }
        }
    }

    public function doSearchPlugin($route) {
        if (isset($this->site_data['theme_components']['plugins']['available'])) {
            $plugins = $this->site_data['theme_components']['plugins']['available'];
            if (is_array($plugins) and count($plugins) > 0) {
                foreach ($plugins as $plugin) {
                    
                }
            }
        }
    }

    public function call_component($route) {


        return $this->get_component($route);
    }

    public function render($file = "", $return = false, $opt = array(), $default_redirect = 1) {
        $cur_lang = NoiCore::app()->getLang();

        if (NoiCore::lang()->is()) {


            if (isset($this->site_data['title_' . $cur_lang])) {
                $this->site_data['title'] = $this->site_data['title_' . $cur_lang];
            }
            if (isset($this->site_data['title_mainpage_' . $cur_lang])) {
                $this->site_data['title_mainpage'] = $this->site_data['title_mainpage_' . $cur_lang];
            }
            if (isset($this->site_data['keywords_' . $cur_lang])) {
                $this->site_data['keywords'] = $this->site_data['keywords_' . $cur_lang];
            }
            if (isset($this->site_data['description_' . $cur_lang])) {
                $this->site_data['description'] = $this->site_data['description_' . $cur_lang];
            }
        }
        NoiCore::app()->site_data = $this->site_data;
        $this->var_data['site'] = $this->site_data;
        \Yii::$app->params['noi_site_data'] = $this->site_data;
        if ($file == "") {
            $file = $this->view_name;
            $file2 = $this->view_name_tpl;
        }


        if (!isset($file2) and isset($this->view_name_tpl)) {
            $file2 = $this->view_name_tpl;
        }
        $tmp_var_1 = str_replace(".tpl", ".php", $file2);
        if ($tmp_var_1 != $file) {
            $file2 = str_replace(".php", ".tpl", $file);
        }




        $this->site_data = NoiCore::app()->get();


        //theme_site
        //$this->layout='webroot.themes.bootstrap.views.layouts.column2';
//$this->layoutPath = Yii::getPathOfAlias('webroot.themes.bootstrap.views.layouts')
        //id в базе 5342a4fa48e6adoc1676739542
//id в папке 531dcc95951d9bc10a000003
        if (strlen($this->site_data['type_site']) > 0) {

            $path1 = DOCUMENT_ROOT . THEMES_PATH . "" . $this->site_data['type_site'] . "/" . $this->site_data['theme_site'] . "/page";
            $path1_tpl = DOCUMENT_ROOT . THEMES_PATH . "" . $this->site_data['type_site'] . "/" . $this->site_data['theme_site'] . "/tpl";
            $path = $path1;
            $path2 = DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/tpl";

            $path3 = DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/page";
            $path_404_main = DOCUMENT_ROOT . THEMES_PATH . "" . $this->site_data['type_site'] . "/" . $this->site_data['theme_site'] . "/page";
            $path_404_user = DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/page";
        } else {

            $path1 = DOCUMENT_ROOT . "" . THEMES_PATH . "" . $this->site_data['theme_site'] . "/page";
            $path1_tpl = DOCUMENT_ROOT . "" . THEMES_PATH . "" . $this->site_data['theme_site'] . "/tpl";
            $path = $path1;
            $path2 = DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/tpl";
            $path3 = DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/page";
            $path_404_main = DOCUMENT_ROOT . "" . THEMES_PATH . "" . $this->site_data['theme_site'] . "/page";
            $path_404_user = DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/page";
        }

        if ($default_redirect == 1) {
            $default_path = $path1 . "/main.php";
            $default_path_tpl = $path1_tpl . "/" . $file2;
            $default_path2 = $path2 . "/main.tpl";
            $default_path3 = $path3 . "/main.php";
        } else {
            $default_path = $path1 . "/" . $file;
            $default_path_tpl = $path1_tpl . "/" . $file2;
            $default_path2 = $path2 . "/" . $file2;

            $default_path3 = $path3 . "/" . $file;
        }
// if($file=="pagination.php"){
//  echo $default_path;
//  echo $default_path2;
//  exit;
// }
        $path1 = $path1 . "/" . $file;
        $path = $path1;

        $path2 = $path2 . "/" . $file2;

        if (file_exists($path2)) {
            $path = $path2;
            $this->istpl = true;
        } else {
            if (file_exists($default_path_tpl)) {
                $path = $path1_tpl . "/" . $file;
            } else if (file_exists($path3 . "/" . $file)) {
                $path = $path3 . "/" . $file;
            } else if (file_exists($path1)) {
                $path = $path1;
            }
            $this->istpl = false;
        }

        if (!file_exists($path2) and file_exists($default_path2) and $return == false) {

            $path = $default_path2;
            $this->istpl = true;
        }
        if (!file_exists($path) and ! file_exists($path2) and ! file_exists($default_path2) and $return == false) {
            if (file_exists($default_path3)) {
                $path = $default_path3;
            } else {
                $path = $default_path;
            }
            $this->istpl = false;
        }
        if ($path1 == $path) {
            $this->istpl = false;
        }


//  if($file=="menu.php"){
//   echo $path;
//   var_dump($this->istpl);
//   exit;
//
//
//  }
//if($file2=="right_blocks/right2.tpl"){
//  var_dump(file_exists($path));
//    exit;
//}
        $data = $this->var_data;
        $data['cur'] = &$this;
        $tmp_path_r = str_replace("main.php", "", $path);

        $count_opt = count($opt);
        if ($opt == array()) {

            $count_opt = 0;
        }

        if ($count_opt > 0 and is_array($opt)) {

            foreach ($opt as $key => $val) {
                $data[$key] = $val;
            }
        }
        $nroute = NoiCore::route()->get();

        if ($nroute != "") {
            $data['site']['description'] = NoiCore::app()->getParam("description");
            $data['site']['keywords'] = NoiCore::app()->getParam("keywords");
        }
        if (isset($data['site']['description'])) {
            $data['site']['description'] = htmlspecialchars($data['site']['description']);
        }
        if (isset($data['site']['keywords'])) {
            $data['site']['keywords'] = htmlspecialchars($data['site']['keywords']);
        }

        if (isset(\Yii::$app->params['uc_var_array']) and is_array(\Yii::$app->params['uc_var_array']) and count(\Yii::$app->params['uc_var_array']) > 0) {
            foreach (\Yii::$app->params['uc_var_array'] as $key1 => $val1) {
                $data[$key1] = $val1;
            }
        }
        if (!isset($data['site']['route_site']) or $data['site']['route_site'] == "") {
            $data['site']['route_site'] = "/";
        }
        $this->pre_data = $data;

        if ($this->route != "default" and $tmp_path_r != $path and ! isset($data['plugin'])) {
            if ($this->route != "404") {
                \Yii::$app->controller->redirect("/404");
            } else {
                header("HTTP/1.1 404 Not Found");
                header("Status: 404 Not Found");
            }
            if (file_exists($path_404_main . "/404.php")) {
                $path = $path_404_main . "/404.php";
            } else if (file_exists($path_404_user . "/404.php")) {
                $path = $path_404_user . "/404.php";
            } else {
                $path = PATH_TO_ENGINE . "/views/404.php";
            }
        }

        $result_html = "";
        if (!isset($data['plugin']) and isset($data['site']['title_mainpage'])) {
            $data['site']['title'] = $data['site']['title'] . " " . $data['site']['title_mainpage'];
        }

        if (file_exists($path)) {
            $new_path = str_replace("/page/", "/page_" . NoiCore::app()->getLang() . "/", $path);
            if (file_exists($new_path)) {
                $path = $new_path;
            }

            if ($this->istpl == false) {






                if ($return == false) {
//  echo "1";
//    exit;

                    $result_html = $this->system_render($path, $data);

//return $result;
                } else {

                    $result_html = $this->system_render($path, $data);
                }
            } else {

                $result_html = $this->system_render($path, $data);
            }
        }
        $tmp_rr = NoiCore::app()->getParam("title");
        if ($tmp_rr != "0") {
            \Yii::$app->params['user_title'] = $tmp_rr;
        }

        if (isset(\Yii::$app->params['user_title'])) {
            $result_html = str_replace(\Yii::$app->params['user_title'] . "</title>", "</title>", $result_html);
            $result_html = str_replace("</title>", "  " . \Yii::$app->params['user_title'] . "</title>", $result_html);
            $result_html = str_replace("%%title_page%%", \Yii::$app->params['user_title'], $result_html);
        } else {
            $result_html = str_replace("%%title_page%%", "", $result_html);
        }
        if ($return == false) {
            return $result_html;
        } else {
            return $result_html;
        }
//$this->setLayout($result[0]['type_site'],$result[0]['theme_site']);
    }

    function getSmartyVars($string) {
        // regexp
        $fullPattern = '\{\$(.*?)\}';
        $separateVars = '`[^\\$]*\\$([a-zA-Z0-9]+)`';

        $smartyVars = array();
        // We start by extracting all the {} with var embedded
        if (!preg_match_all($fullPattern, $string, $results)) {
            return $smartyVars;
        }
        // Then we extract all smarty variables
        foreach ($results[0] AS $result) {
            if (preg_match_all($separateVars, $result, $matches)) {
                $smartyVars = array_merge($smartyVars, $matches[1]);
            }
        }
        return array_unique($smartyVars);
    }

    public function system_render($path, $data) {


        if (file_exists($path)) {

            if (isset(NoiCore::app()->site_data['load_from_db']) and NoiCore::app()->site_data['load_from_db'] == 0) {
                $result2 = MGQuery::execute(array(), 'template_page', array('path' => $path));
                if (isset($result2[0]['_id'])) {
                    $tmpfname = tempnam("/tmp", "render_main");

                    $handle = fopen($tmpfname, "w");
                    fwrite($handle, $result2[0]['content']);

                    $result = \Yii::$app->controller->renderFile($tmpfname, $data, true);
                } else {
                    $result = \Yii::$app->controller->renderFile($path, $data, true);
                }
            } else {
                $result = \Yii::$app->controller->renderFile($path, $data, true);
            }


            return $result;
        } else {
            return "";
        }
    }

    public function get_plugin($plugin_name = "", $param = array(), $iswidget = 0, $widget = array()) {

        if (strlen($plugin_name) > 0 and in_array($plugin_name, $this->site_data['theme_components']['plugins']['available'])) {
            // yii::setPathOfAlias('tmp_render_site',YII_COMPONENT_PATH);
            // yii::import('tmp_render_site.*');


            $param = implode("/", $param);

            $result = NoiCore::c("plugins")->run($plugin_name, $param, $iswidget, $widget, $this);

            return $result;
//  $this->result_html=$result;
        }
    }

    public function get_plugin2($plugin_name = "", $param = "", $iswidget = 0, $widget = array()) {

        if (strlen($plugin_name) > 0 and in_array($plugin_name, $this->site_data['theme_components']['plugins']['available'])) {
            // yii::setPathOfAlias('tmp_render_site',YII_COMPONENT_PATH);
            // yii::import('tmp_render_site.*');

            $result = NoiCore::c("plugins")->run($plugin_name, $param, $iswidget, $widget, $this);

            return $result;
//  $this->result_html=$result;
        }
    }

    public function isExistPlugin($plugin_name) {
        if (isset($plugin_name) and in_array($plugin_name, $this->site_data['theme_components']['plugins']['available'])) {
            return true;
        } else {
            return false;
        }
    }

    public function isExistTpl($path) {
        if (file_exists(DOCUMENT_ROOT . THEMES_PATH . "userthemes/" . $this->site_data['_id']->__toString() . "/tpl/" . $path)) {
            return true;
        } else {
            return false;
        }
    }

}
