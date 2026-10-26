<?php
 
 
  use noicms\mongogrid\system_core\MGQuery;
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/PluginDB.php";
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/PluginUser.php";


abstract class CoreFrontendControllerPlugin{
    public $name_plugin="";
    public $path_plugin="";
    public $cursor="";
    public $resourses="";
    public $js_assets_url="";
    public $css_assets_url="";
    public $site_data;
    public $route;
    public $url_route="";
    public $iswidget=0;
    public $widget=array();
    public $enable_widget_event=1;
    public $__db_plugin=null;
    public $folder_contain="";
    public $__user_plugin=null;
    public $full_url_site="";
    private $mobile_enable=0;
    private $return_json=0;
   public function lang($key){
      if(isset($key)){

       return NoiCore::app()->lang($key,$this->name_plugin);
      }else {
         return 0;
      }
    }
    public function __construct($name_plugin,&$cur,$route=0,$status_mobile=0) {
      //  echo get_class($this);
       // exit;
        
if(is_array($name_plugin) and is_object($cur)){
 $route=$name_plugin;
 $route=$cur;
  $reflector = new ReflectionClass(get_class($this)); 
 $path_file=$reflector->getFileName();
 $path_file=str_replace("//","/",$path_file);
  $super_path=YII_PLUGIN_PATH;
 $super_path=str_replace("//","/",$super_path);
 
 $tmp_name_plugin=explode($super_path,$path_file);
 if(isset($tmp_name_plugin[1])){
  $tmp_name_plugin2=explode("/",$tmp_name_plugin[1]); 
  if(isset($tmp_name_plugin2[0])){
  $name_plugin=$tmp_name_plugin2[0];   
  }
 }else {
 $name_plugin="undefined";    
 }
 
}
      $this->mobile_enable=(int)$status_mobile;
 
      if($this->mobile_enable==1){

     if(NoiCore::c("mobile")->isMobile()){
      
      $this->return_json=1;
     }
      }
      $name_class=get_class($this);
      $name_class=  str_replace(ucfirst($name_plugin)."FrontendControllerPlugin", "", $name_class);
        $name_class=  str_replace(ucfirst($name_plugin)."FCP", "", $name_class);
      if(strlen($name_class)>0){
      $name_class=  mb_strtolower($name_class);
      $this->folder_contain=$name_class;
      }


     $this->cursor=$cur;
     $this->name_plugin=$name_plugin;
     $this->route=$route;
     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/config.php")){
         include( YII_PLUGIN_PATH."".$name_plugin."/config.php");

        
         if(isset($plugin_config['route'])){
         $this->url_route=$plugin_config['route'];
         }
     }
     $this->path_plugin=YII_PLUGIN_PATH."".$name_plugin."/views/frontend/";
     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/assets/js/") and is_dir(YII_PLUGIN_PATH."".$name_plugin."/assets/js/")){
     $js_files=$this->get_array_js_files();
     }else {
     $js_files=array();
     }
     $this->site_data=NoiCore::app()->get();
       if(NOIPRODUCT_FOLDER=="protected"){
     $main_url=\Yii::$app->params['main_url'];
     if(isset($this->site_data['domain_site'])){
     $this->full_url_site="http://".$this->site_data['domain_site'].".".$main_url;
     }
     }else {
     $this->full_url_site="http://".$_SERVER['HTTP_HOST']."";
     }
   
     \Yii::$app->params['current_site_id']=$this->site_data['_id']->__toString();
     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/assets/css/") and is_dir(YII_PLUGIN_PATH."".$name_plugin."/assets/css/")){
     $css_files=$this->get_array_css_files();
     }else {
     $css_files=array();
     }
    //Yii::setPathOfAlias('plugin_tmp_assets', YII_PLUGIN_PATH."".$name_plugin."/assets/js/");
   // Yii::setPathOfAlias('plugin_tmp_assets_css', YII_PLUGIN_PATH."".$name_plugin."/assets/css/");
     if(count($js_files)>0){

     foreach($js_files as $js){
     $tmp_name=str_replace(".js","",$js);
     if($tmp_name!=$js){

 $js_assets_url=\Yii::$app->getAssetManager()->publish(Yii::getPathOfAlias('plugin_tmp_assets') );
$this->js_assets_url=$js_assets_url;

  $this->resourses=$this->resourses."<script type='text/javascript' src='".$js_assets_url."/".$js."'></script>";
  
     }
     }
     }
     if(count($css_files)>0){
     foreach($css_files as $css){
     $tmp_css_name=str_replace(".css","",$css);
//     if($tmp_css_name!=$css){
// $css_assets_url=\Yii::$app->getAssetManager()->publish(Yii::getPathOfAlias('plugin_tmp_assets_css') );
//  $this->css_assets_url=$css_assets_url;
//  $this->resourses=$this->resourses.""."<link rel='stylesheet' href='".$css_assets_url."/".$css."'>";
//     }
     }
     }
if(strlen($this->resourses)>0){
 
 //$this->set_html($this->resourses);
  $this->append_html($this->resourses);
}
    }
    public function getRoute($route="",$enable=1){
if($this->enable_widget_event==1  and $this->iswidget==1 and isset($this->widget['position']) and isset($this->widget['number'])){
   return $this->site_data['route_site']."widgets/".$this->widget['position']."/".$this->widget['number']."/".$this->name_plugin."/".$route;
}else {
    if($enable==1){
    return $this->site_data['route_site']."".$this->url_route."/".$route.".html";
    }else {
    return $this->site_data['route_site']."".$this->url_route."/".$route;
    }
}
    }
      public function getRoute2($route="",$enable=1){
 if($enable==1){
    return $this->site_data['route_site']."".$this->url_route."/".$route.".html";
    }else {
    return $this->site_data['route_site']."".$this->url_route."/".$route;
    }
    }
    public function getFullRoute($route=""){
    $enable=1;
   if($this->enable_widget_event==1  and $this->iswidget==1 and isset($this->widget['position']) and isset($this->widget['number'])){
   return $this->full_url_site."".$this->site_data['route_site']."widgets/".$this->widget['position']."/".$this->widget['number']."/".$this->name_plugin."/".$route;
}else {
    if($enable==1){
    return $this->full_url_site."".$this->site_data['route_site']."".$this->url_route."/".$route.".html";
    }else {
    return $this->full_url_site."".$this->site_data['route_site']."".$this->url_route."/".$route;
    }
}
    }
    
    public function getResource(){
     return $this->resourses;
    }
     public function system_render($file,$data){
     $title=NoiCore::app()->getParam("title");

    // $old_session=\Yii::$app->session->keys;

     if(isset(\Yii::$app->params['breadcrumbs_path']) and is_array(\Yii::$app->params['breadcrumbs_path'])){
     $breadcrumbs_old=\Yii::$app->params['breadcrumbs_path'];

     }
if(isset(NoiCore::app()->site_data['load_from_db']) and NoiCore::app()->site_data['load_from_db']==0){
    $file=str_replace("//","/",$file);
     $result2=  MGQuery::execute(array(), 'template_page',array('path'=>$file));
   
     if(isset($result2[0]['_id'])){
  $tmpfname = tempnam("/tmp", "render_main");

$handle = fopen($tmpfname, "w");
fwrite($handle, $result2[0]['content']);

 extract($data, EXTR_PREFIX_SAME, "wddx");
        ob_start();
        include($tmpfname);
       $result=ob_get_clean();

       NoiCore::app()->setParam("title",$title);
if(isset($breadcrumbs_old)){

 \Yii::$app->params['breadcrumbs_path']=$breadcrumbs_old;
}
       return $result;
 }else {
  if(file_exists($file)){

        extract($data, EXTR_PREFIX_SAME, "wddx");
        ob_start();
        include($file);
       $result=ob_get_clean();

       NoiCore::app()->setParam("title",$title);
if(isset($breadcrumbs_old)){

 \Yii::$app->params['breadcrumbs_path']=$breadcrumbs_old;
}
       return $result;
     }
 }

}else {
     if(file_exists($file)){

        extract($data, EXTR_PREFIX_SAME, "wddx");
        ob_start();
        include($file);
       $result=ob_get_clean();

       NoiCore::app()->setParam("title",$title);
if(isset($breadcrumbs_old)){

 \Yii::$app->params['breadcrumbs_path']=$breadcrumbs_old;
}
       return $result;
     }
}

    }
     public function render_array($array,$data,$only_path=0){
    if(is_array($array) and count($array)>0){
    foreach($array as $file){
    if(file_exists($file)){
     $new_path=str_replace("/page/","/page_".NoiCore::app()->getLang()."/",$file);
   
 if(file_exists($new_path)){
 $file=$new_path;
 }
    if($only_path==1){
    return $file;
    }else {
  //  $return=\Yii::$app->controller->renderFile($file,$data,true);
   $return=$this->system_render($file,$data);

    $pos = strpos($file, "themes/widget/");
    if($pos===false){

    }else {

    }
    return $return;
    break;
    }
    }
    }
    }
    }
    public function render($view,$data=array(),$only_path=0){
 if($this->return_json==1){
if(isset(NoiCore::c("mobile")->system_params['api_user'])){
 $data['current_user']=NoiCore::user()->load();
 $data['current_sessionid']=NoiCore::app()->getSessionId();
}
   return json_encode($data);
}
$this->site_data=NoiCore::app()->site_data;
 $data['site']=$this->site_data;
// if(!isset($data['value'])){
// $data['value']=$this->get_value();
// }
 if(!isset($data['this'])){
 $data['this']=&$this;
 $data['cur']=&$this;
 }
 if(!isset($data['route'])){
  $data['route']=$this->route;
 }

$data['cur']=&$this;
 $data['controller']=$this;

  $array_files=array();
 
 if($this->iswidget==1 and isset($this->widget['position'])){
 if(strlen($this->folder_contain)>0){
 $array_files[]=DOCUMENT_ROOT.THEMES_PATH."userthemes/".$this->site_data['_id']->__toString()."/page/plugin/".$this->name_plugin."/".$this->folder_contain."/".$this->widget['position']."_".$view.".php";
 if(strlen($this->site_data['type_site'])>0){
   $array_files[]=DOCUMENT_ROOT.THEMES_PATH."".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/plugin/".$this->name_plugin."/".$this->folder_contain."/".$this->widget['position']."_".$view.".php";
 }
 $array_files[]=DOCUMENT_ROOT.THEMES_PATH."/".$this->site_data['theme_site']."/page/plugin/".$this->name_plugin."/".$this->folder_contain."/".$this->widget['position']."_".$view.".php";
   $array_files[]=$this->path_plugin."".$this->folder_contain."/".$this->widget['position']."_".$view.".php";
 }
 $array_files[]=$this->path_plugin."".$this->widget['position']."_".$view.".php";
 $array_files[]=DOCUMENT_ROOT.THEMES_PATH."userthemes/".$this->site_data['_id']->__toString()."/page/plugin/".$this->name_plugin."/".$this->widget['position']."_".$view.".php";
  $array_files[]=DOCUMENT_ROOT.THEMES_PATH."".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/plugin/".$this->name_plugin."/".$this->widget['position']."_".$view.".php";



 }
  if(strlen($this->folder_contain)>0){
 $array_files[]=DOCUMENT_ROOT.THEMES_PATH."userthemes/".$this->site_data['_id']->__toString()."/page/plugin/".$this->name_plugin."/".$this->folder_contain."/".$view.".php";
   $array_files[]=DOCUMENT_ROOT.THEMES_PATH."".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/plugin/".$this->name_plugin."/".$this->folder_contain."/".$view.".php";
     $array_files[]=$this->path_plugin."".$this->folder_contain."/".$view.".php";
 }
 $array_files[]=DOCUMENT_ROOT.THEMES_PATH."userthemes/".$this->site_data['_id']->__toString()."/page/plugin/".$this->name_plugin."/".$view.".php";
 $array_files[]=DOCUMENT_ROOT.THEMES_PATH."".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/plugin/".$this->name_plugin."/".$view.".php";
 $array_files[]=$this->path_plugin."".$view.".php";
 return $this->render_array($array_files, $data,$only_path);

} 
public function get_main_value($field="default"){
  if(strlen($field)==0){
   $field="default";
  }
  
  
   if(isset($this->site_data['theme_components']['plugins']['mongogrid_values'][$this->name_plugin][$field])){
    return $this->site_data['theme_components']['plugins']['mongogrid_values'][$this->name_plugin][$field];
   } else {
      return array();
   }
   
 
  
   
  
   
    
}
public function get_value($field="default"){
  if(strlen($field)==0){
   $field="default";
  }
  
   if($this->iswidget==0){
   if(isset($this->site_data['theme_components']['plugins']['mongogrid_values'][$this->name_plugin][$field])){
    return $this->site_data['theme_components']['plugins']['mongogrid_values'][$this->name_plugin][$field];
   } else {
      return array();
   }
   }
 
  
   if($this->iswidget==1 and isset($this->widget['position']) and isset($this->widget['number'])){
   if(isset($this->site_data['theme_components']['widgets']['position'][$this->widget['position']][$this->widget['number']]['value'][$field])){
    return $this->site_data['theme_components']['widgets']['position'][$this->widget['position']][$this->widget['number']]['value'][$field];
   } else {
      return array();
   }
   }
  
   
    
}
public function set_html($html){
   $this->cursor->result_html=$html;

   }
   public function get_array_js_files(){
   if(file_exists(YII_PLUGIN_PATH."".$this->name_plugin."/assets/js/") and is_dir(YII_PLUGIN_PATH."".$this->name_plugin."/assets/js/")){
    return scandir(YII_PLUGIN_PATH."".$this->name_plugin."/assets/js/");
   }else {
    return array();
   }
   }
   public function get_array_css_files(){
    if(file_exists(YII_PLUGIN_PATH."".$this->name_plugin."/assets/css/") and is_dir(YII_PLUGIN_PATH."".$this->name_plugin."/assets/css/")){
    return scandir(YII_PLUGIN_PATH."".$this->name_plugin."/assets/css/");
   }else {
    return array();
   }
   }
  public function get_html(){
   return $this->cursor->result_html; 
   }
   public function getCurrentURL(){
   if(isset($_SERVER['REQUEST_URI'])){
       return $_SERVER['REQUEST_URI'];
   }else {
       return "/";
   }
   }
   public function append_html($html){
    $this->set_html($this->get_html()."".$html);
   }
      public function setView($page_type,$page){

    \Yii::$app->params['uc_page']=  $page;
    \Yii::$app->params['uc_page_type']=  $page_type;
    }
    public function setData($data){
    if(is_array($data))  {
    \Yii::$app->params['uc_var_array']=$data;
    }
    }
    public function setSession($name,$data){
       $result=NoiCore::app()->setSession($name,$data);

//\Yii::$app->session->add($this->site_data['_id']->__toString()."_plugin_".$this->name_plugin."_".$name,$data);
    }
    public function removeSession($name){
     if(isset(\Yii::$app->session[$this->site_data['_id']->__toString()."_plugin_".$this->name_plugin."_".$name])){
       unset(\Yii::$app->session[$this->site_data['_id']->__toString()."_plugin_".$this->name_plugin."_".$name]);
     }
    }
    public function getSession($name){
     $result=NoiCore::app()->getSession($name);
     if(isset($result)){
         return $result;
     }
//     if(isset(\Yii::$app->session[$this->site_data['_id']->__toString()."_plugin_".$this->name_plugin."_".$name])){
//  return \Yii::$app->session[$this->site_data['_id']->__toString()."_plugin_".$this->name_plugin."_".$name];
//    }else {
//      return false;
//    }
    }
       public function get_paginator($url,$count,$limit,$current_page=0,$type="offset"){
   // Array to store page link list



  $noipage=new NoiPage();
  $noi_array_page=$noipage->calculate_pages($count, $limit, $current_page);

   return $noi_array_page;
  }
  public function setTitle($title){
 \Yii::$app->params['user_title']=$title;
 NoiCore::app()->setParam("title",$title);
  }
  public function setBreadcrumbs($array){
  \Yii::$app->params['breadcrumbs_path']=$array;
  }
   public function import($folder){
   yii::import("alias_plugin.".$this->name_plugin.".".$folder.".*");
  }
  public function isExistPlugin($plugin_name=""){
   if(in_array($plugin_name,NoiCore::c("plugins")->getInstalledPlugins())){
     return true;
   }else {
       return false;
   }
 
  }
  public function runPlugin($plugin_name,$param=array()){
 
    return NoiCore::app()->get_plugin($plugin_name,$param);
  }
  public function setNotify($str=""){
  NoiCore::app()->setNotify($str);    
 
  }
  public function redirect($url=""){
  if(strlen($url)>0){
 Yii::$app->getResponse()->redirect($url, 302)->send();($url);
  }
  }
   public function db(){
  if($this->__db_plugin==NULL){
   $this->__db_plugin=new PluginDB($this->site_data['_id']->__toString());
  }
  return $this->__db_plugin;
  }
  public function user(){
  if($this->__user_plugin==NULL){
  $this->__user_plugin=new PluginUser($this->site_data['_id']->__toString());
  }
  return $this->__user_plugin;
  }

}
?>