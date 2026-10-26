<?php

use noicms\mongogrid\OneField;
use noicms\mongogrid\system_core\MGQuery;

class Plugins{
  public function getInstalledPlugins(){
    $site_data=NoiCore::app()->site_data;
    $result_array=array();
    if(isset($site_data['theme_components']['plugins']['available'])){
     $result_array=$site_data['theme_components']['plugins']['available'];
    }
    return $result_array;
  }
  public function getLinks($plugin){
   $site=NoiCore::app()->site_data;
      if(isset($site['theme_components']['plugins'])){
    $default_op=0;
    if(isset($_GET['default_op'])){
    $default_op=$_GET['default_op'];
    }
    

require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreAdminControllerPlugin.php";
     $data['result']=array();
     if(file_exists(YII_PLUGIN_PATH."".$plugin."/controllers/admin/".ucfirst($plugin)."ACP.php")){
          require_once YII_PLUGIN_PATH."".$plugin."/controllers/admin/".  ucfirst($plugin)."ACP.php";
      $name_class=ucfirst($plugin)."ACP";
      $admin_class=new $name_class($site);
      if(method_exists($admin_class, "menu_get_links")){
      $data['result']=$admin_class->menu_get_links($default_op);
      if(!is_array($data['result'])){
       $data['result']=array();
      }
      }
     }
    else   if(file_exists(YII_PLUGIN_PATH."".$plugin."/controllers/admin/".  ucfirst($plugin)."AdminControllerPlugin.php")){
      require_once YII_PLUGIN_PATH."".$plugin."/controllers/admin/".  ucfirst($plugin)."AdminControllerPlugin.php";
      $name_class=ucfirst($plugin)."AdminControllerPlugin";
      $admin_class=new $name_class($site);
      if(method_exists($admin_class, "menu_get_links")){
      $data['result']=$admin_class->menu_get_links($default_op);
      if(!is_array($data['result'])){
       $data['result']=array();
      }
      }
      }
 
   echo NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/plugin/plugins_links.php", $data);
     
}
  }
  public function isInstall($plugin){
   if(in_array($plugin,$this->getInstalledPlugins())){
    return true;
   }else {
       return false;
   }
  }
  public function getNewPlugins(){
     $results=array();
     $plugins=  scandir(YII_PLUGIN_PATH);
     $available=NoiCore::c("plugins")->getInstalledPlugins();
     if(count($plugins)>0){
      foreach($plugins as $plugin){
      if(!in_array($plugin,$available) and file_exists(YII_PLUGIN_PATH."".$plugin."/config.php")){
      $results[]=$plugin;
      }
      }
     }
     return $results;
  }
  private function isConfig($route){
$result=false;
 $array_tmp_ex=explode("/",$route);

  if(isset($array_tmp_ex[0]) and $array_tmp_ex[0]=="config"){
   if(isset($array_tmp_ex[1])){
    $result=true;

   }
  }
  return $result;
  }
  private function getFieldConfig($route){
  $field="default";

 $array_tmp_ex=explode("/",$route);

  if(isset($array_tmp_ex[0]) and $array_tmp_ex[0]=="config"){
   if(isset($array_tmp_ex[1])){
   $field=$array_tmp_ex[1];

   }
  }
return $field;
  }
  private function runConfig($name,$route){
$site=NoiCore::app()->site_data;
$name_plugin=$name;
$field=$this->getFieldConfig($route);
$type_run="normal";

Yii::$app->params['type_run']=$type_run;
      if(NoiCore::app()->isEnableComponent("plugins")){


      if(!isset($site['theme_components']['plugins']['mongogrid_values'][$name_plugin])){
      $site['theme_components']['plugins']['mongogrid_values'][$name_plugin]=array();

      }
      if(!isset($site['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field])){
      $site['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field]=array();
      }
      if (defined('YII_PLUGIN_PATH')) {

    if (YII_PLUGIN_PATH and file_exists(YII_PLUGIN_PATH."".$name_plugin."/config.php"))     {
      include_once YII_PLUGIN_PATH."".$name_plugin."/config.php";
      if(isset($plugin_config['mongogrid']) and isset($plugin_config['mongogrid'][$field])){
      if(isset($plugin_config['mongogrid'][$field]['fields'])){
      if(isset($_POST['plugin_add_row'])){
      $array_insert=array();
      foreach($plugin_config['mongogrid'][$field]['fields'] as $field_on=>$data_field){

  if(isset($data_field['type'])){
  if(!isset($data_field['opt'])){
  $data_field['opt']=array();
  }
  $data_field['opt']['id_site']=$site['_id']->__toString();
  $data_field['opt']['site']=$site;
  $tmp_obj=new OneField();
  $tmp_obj->init($field_on,$data_field['type'],$data_field['opt']);
  $array_insert[$field_on]=$tmp_obj->setInput();
  }
      }

      if(count($array_insert)>0){
      $cur_pos="last";
      $max_count=0;
      if(isset($plugin_config['mongogrid'][$field]['count']) and $plugin_config['mongogrid'][$field]['count']>0){
      $max_count=$plugin_config['mongogrid'][$field]['count'];
      }
      if($max_count>0){
      $cur_count=count($site['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field]);
      if($cur_count>0 and $cur_count==$max_count){
      $tmp_count=$cur_count-1;
      $cur_pos=$tmp_count;
      }
      }
      $array_update=array();
      $array_update['theme_components']=$site['theme_components'];

      if(isset($_POST['plugins_pos_update'])){


      if(isset($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']])){
      foreach($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']] as $cur_key=>$cur_val){
      if(!isset($array_insert[$cur_key])){
      $array_insert[$cur_key]=$array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']][$cur_key];
      }

      if(is_string($array_insert[$cur_key]) and strlen($array_insert[$cur_key])==0){
       $array_insert[$cur_key]=$array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']][$cur_key];
      }
      if(is_array($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']] ) and count($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']] )>0){
     if(is_array($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']][$cur_key]) and count($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']][$cur_key])>0) {
      if(!is_array($array_insert[$cur_key])  ){
      $array_insert[$cur_key]=$array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']][$cur_key];
      }
      if(is_array($array_insert[$cur_key]) and count($array_insert[$cur_key])==0 ) {
      $array_insert[$cur_key]=$array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']][$cur_key];
      }
     }
      }
      }
      }

      $array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_POST['plugins_pos_update']]=$array_insert;
if(isset($_GET['plugin_selected'])){
 if(file_exists(YII_PLUGIN_PATH."".$_GET['plugin_selected']."/config.php")){
 require_once(YII_PLUGIN_PATH."".$_GET['plugin_selected']."/config.php");
if(isset($plugin_config) and isset($plugin_config['mongogrid']) and isset($plugin_config['mongogrid'][$field]['links']) and is_array($plugin_config['mongogrid'][$field]['links'])){
 $cur_links=$plugin_config['mongogrid'][$field]['links'];
 if(isset($cur_links['collection']) and isset($cur_links['update_field']) and isset($cur_links['condition_field'])){
     $new_update=array();
     $new_update[$cur_links['update_field']]=$array_insert;;
//     MGQuery::update($new_update, $cur_links['collection'],array($cur_links['condition_field']=>(string)$_POST['plugins_pos_update']),true);
      NoiCore::json()->update($new_update);
 }

}
 }
}
      }
      else if($cur_pos!="last"){
      $array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$cur_pos]=$array_insert;
      }else {
      $array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][]=$array_insert;
      }


//      MGQuery::update($array_update, 'widget_user_sites',array('_id'=>new MongoId($site['_id']->__toString())));
         NoiCore::json()->update($array_update);
      $site['theme_components']=$array_update['theme_components'];
      }
      }
      if(isset($_GET['delete']) and isset($site['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_GET['delete']])){
       $array_update=array();
       $array_update['theme_components']=$site['theme_components'];
       $count_cur=count($site['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field]);
       unset($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field][$_GET['delete']]);
       if($count_cur>1){
       $array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field]=  array_values($array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field]);

       }else {
       $array_update['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field]=array();
       }
//        MGQuery::update($array_update, 'widget_user_sites',array('_id'=>new MongoId($site['_id']->__toString())));
         NoiCore::json()->update($array_update);
      $site['theme_components']=$array_update['theme_components'];

      }
      $data=array();
      $data['site']=$site;
      $data['main_field']=$field;
      $data['name_plugin']=$name_plugin;
      $data['id_site']=$site['_id']->__toString();
      $data['fields']=$plugin_config['mongogrid'][$field]['fields'];
      $data['values']=$site['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field];
      $data['plugin_config']=$plugin_config;
      $data['type_run']=$type_run;


   if($type_run=="normal"){

          $text="";

 
  if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/views/admin/config/".$field.".php")){
 $text.=NoiCore::app()->render(YII_PLUGIN_PATH."".$name_plugin."/views/admin/config/".$field.".php",$data);
 return $text;
  }else if(file_exists(ADMIN_PATH.Yii::$app->params['admin_theme']."/page/plugin/".$name_plugin."/config/".$field.".php")) {

 $text.=NoiCore::app()->render(ADMIN_PATH.Yii::$app->params['admin_theme']."/page/plugin/".$name_plugin."/config/".$field.".php",$data);
 return $text;
  }else {

 $text.= NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/mysites/plugins_component_config_page.php",$data);
 return $text;
  }
   }else {
     echo SiteComponent::render_setup(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/mysites/plugins_component_config_page_ajax.php",$data);
     exit;
   }
      }else {
      
      }
      }else {
          
      $data=array();
      $data['site']=$site;
      $data['main_field']=$field;
      $data['name_plugin']=$name_plugin;
      $data['id_site']=$site['_id']->__toString();
      $data['fields']=array();
      $data['values']=array();
      $data['plugin_config']=$plugin_config;
      $data['type_run']=$type_run;
      $data['controller']=$this->get_admin_controller($name_plugin);
      $data['gridconf']=new noicms\mongogrid\GridConf();

   if($type_run=="normal"){
          $text="";
    if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/views/admin/config/".$field.".php")){
 $text.=NoiCore::app()->render(YII_PLUGIN_PATH."".$name_plugin."/views/admin/config/".$field.".php",$data);
 return $text;
  }else if(file_exists(ADMIN_PATH.Yii::$app->params['admin_theme']."/page/plugin/".$name_plugin."/config/".$field.".php")) {

 $text.=NoiCore::app()->render(ADMIN_PATH.Yii::$app->params['admin_theme']."/page/plugin/".$name_plugin."/config/".$field.".php",$data);
 return $text;
  }else {
  $text.= NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/mysites/plugins_component_config_page.php",$data);
  }
 return $text;
   }else {
     echo SiteComponent::render_setup(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/mysites/plugins_component_config_page_ajax.php",$data);
     exit;
   }

      }
    }
     }
     }
  }
  public function run($name,$route){
 if(!isset($name) and !isset($route)){
  return "";
 }
 if(strlen($route)==0){
 $route="config/default";
 }
 
 if($this->isConfig($route)){
   return $this->runConfig($name,$route);
 }
         if (defined('YII_PLUGIN_PATH')) {

    if (YII_PLUGIN_PATH and file_exists(YII_PLUGIN_PATH."".$name."/config.php")) {

    include_once YII_PLUGIN_PATH."".$name."/config.php";
    if(!isset($plugin_config)){
        require  YII_PLUGIN_PATH."".$name."/config.php";
    }

   if(isset($plugin_config) and is_array($plugin_config)){

//       yii::setPathOfAlias('tmp_render_site_plugin', YII_PLUGIN_PATH);
//     yii::import("tmp_render_site_plugin.".$_GET['plugin_selected'].".controllers.admin.*");


    // $name_controller=ucfirst($_GET['plugin_selected'])."AdminControllerPlugin";
    // $admin_controller=new $name_controller($site);
    // $method="action".ucfirst($_GET['page']);





     $html=$this->find_admin_controller($name,explode("/",$route));


 if(isset(Yii::$app->params['type_run']) and Yii::$app->params['type_run']=="ajax"){
   echo $html;
   exit;
 }else {
 return $html;
 }



   }
    }
     }

  }
   private function get_value($route,$start,$increment=0){
    if(!is_array($route)){
     return 0;
    }
     $new2_key= $start+$increment;
      $val2=0;
      if(isset($route[$new2_key])){
      $val2=$route[$new2_key];
      }
      return $val2;
    }
   private function get_admin_controller($name_plugin){
    if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".ucfirst($name_plugin)."ACP.php")){
        require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreAdminControllerPlugin.php";
         require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".ucfirst($name_plugin)."ACP.php";
         $class_name=ucfirst($name_plugin)."ACP";
      $class=new $class_name(NoiCore::app()->site_data);
      return $class;
    }else if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".ucfirst($name_plugin)."AdminControllerPlugin.php")){
     require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreAdminControllerPlugin.php";
         require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".ucfirst($name_plugin)."AdminControllerPlugin.php";
         $class_name=ucfirst($name_plugin)."AdminControllerPlugin";
      $class=new $class_name(NoiCore::app()->site_data);
      return $class;
    }
   }
   private function find_admin_controller($name_plugin,$route){
 
 
     if(isset($name_plugin) and isset($route) and is_array($route) and count($route)>0)
     {
     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/config.php")){
     $array_classes=array();
     foreach($route as $key=>$r){
     $tmp_array2=array('key'=>$key,'class'=>ucfirst($r)."".ucfirst($name_plugin)."ACP");
      $array_classes[]=$tmp_array2;
     $tmp_array=array('key'=>$key,'class'=>ucfirst($r)."".ucfirst($name_plugin)."AdminControllerPlugin");
     $array_classes[]=$tmp_array;
     }
     $array_classes[]=array('class'=>ucfirst($name_plugin)."ACP");;
     $array_classes[]=array('class'=>ucfirst($name_plugin)."AdminControllerPlugin");;

     if(is_array($array_classes) and count($array_classes)>0){
     foreach($array_classes as $class){
     if(isset($class['class'])){
     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".$class['class'].".php"))
     {

         require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreAdminControllerPlugin.php";
         require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".$class['class'].".php";
      $new_admin_controller=new  $class['class'](NoiCore::app()->site_data);
      if(isset($class['key'])){
      $tmp_key=$class['key']+1;
      if(isset($route[$tmp_key])){
      if(method_exists($new_admin_controller,'action'.$route[$tmp_key])){
      $current_value="";
      $new_tmp_key=$tmp_key+1;
      if(isset($route[$new_tmp_key])){
      $current_value=$route[$new_tmp_key];
      }
    
       $method = new ReflectionMethod($class['class'],'action'.$route[$tmp_key]);

      $num = $method->getNumberOfParameters();

  $method='action'.$route[$tmp_key];
      $result=array();
       if($num==1 or $num==0){
      $result['result']=$new_admin_controller->$method($current_value);
      }else if($num==2) {

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, $new_tmp_key,1));
      }else if($num==3){

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2));
      }else if($num==4){

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2),$this->get_value($route, $new_tmp_key,3));
      }else if($num==5){
        $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2),$this->get_value($route, $new_tmp_key,3),$this->get_value($route, $new_tmp_key,4));
      }
      //return $new_admin_controller->$method($current_value);
      if(isset($result['result'])){
        return $result['result'];
      }else {
         return "";
      }
      }
      }
      }else {
         
      if(isset($route[0])){
        if(method_exists($new_admin_controller,'action'.$route[0])){
      $current_value="";
      $tmp_key=$route[0];
      if(isset($route[1])){
      $current_value=$route[1];
      }

     
    $method = new ReflectionMethod($class['class'],'action'.$route[0]);
      $num = $method->getNumberOfParameters();
          $method='action'.$route[0];
       $result=array();
       if($num==1 or $num==0){
      $result['result']=$new_admin_controller->$method($current_value);
      }else if($num==2) {

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 1,1));
      }else if($num==3){

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 1,1),$this->get_value($route, 1,2));
      }else if($num==4){

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 1,1),$this->get_value($route, 1,2),$this->get_value($route, 1,3));
      }else if($num==5){
        $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 1,1),$this->get_value($route, 1,2),$this->get_value($route,1,3),$this->get_value($route, 1,4));
      }
       if(isset($result['result'])){
        return $result['result'];
      }else {
         return "";
      }
      }
      }
      if(method_exists($new_admin_controller,"actionIndex")){
      $current_value="";
      if(isset($route[0])){
      $current_value=$route[0];
      }
      $method="actionIndex";
       $method2 = new ReflectionMethod($class['class'],'actionIndex');
      $method="actionIndex";
      $num = $method2->getNumberOfParameters();
       $result=array();
       if($num==1 or $num==0){
      $result['result']=$new_admin_controller->$method($current_value);
      }else if($num==2) {

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 0,1));
      }else if($num==3){

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 0,1),$this->get_value($route,0,1));
      }else if($num==4){

      $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 0,1),$this->get_value($route, 0,2),$this->get_value($route, 0,3));
      }else if($num==5){
        $result['result']=$new_admin_controller->$method($current_value,$this->get_value($route, 0,1),$this->get_value($route, 0,2),$this->get_value($route,0,3),$this->get_value($route, 0,4));
      }
       if(isset($result['result'])){
        return $result['result'];
      }else {
         return "";
      }

      }
      }

   //  echo $class['class'];
  //  exit;

     }
     }
     }
     }
     }
     }
     }
  public function installNewPlugin($name_plugin){
  $site=NoiCore::app()->site_data;
  $new=$this->getNewPlugins();
  if(in_array($name_plugin,$new)){
   $array_update['theme_components']=$site['theme_components'];

     if(!isset($array_update['theme_components']['plugins']['available']) or !is_array($array_update['theme_components']['plugins']['available']) ){
       $array_update['theme_components']['plugins']['available']=array();
       }
       $array_update['theme_components']['plugins']['available'][]=$_POST['name_install_plugin'];
       NoiCore::json()->update($array_update);
  }
  }
  public function deletePlugin($name_plugin){
  $site=NoiCore::app()->site_data;
  $availabile=$this->getInstalledPlugins();
 
  if(in_array($name_plugin, $availabile)){
      $array_update=array();
        $array_update['theme_components']=$site['theme_components'];
        if(!isset($array_update['theme_components']['plugins']['available']) or !is_array($array_update['theme_components']['plugins']['available']) ){
         $array_update['theme_components']['plugins']['available']=array();
        }
        $count_plugins=count( $array_update['theme_components']['plugins']['available']);
        if(in_array($name_plugin,$array_update['theme_components']['plugins']['available'])){
        $key = array_search($name_plugin, $array_update['theme_components']['plugins']['available']);
        if($key===FALSE){

        }else {
        unset( $array_update['theme_components']['plugins']['available'][$key]);
        if($count_plugins>1){
       $array_update['theme_components']['plugins']['available']=  array_values($array_update['theme_components']['plugins']['available']);
        }else {
        $array_update['theme_components']['plugins']['available']=array();
        }
 
        NoiCore::json()->update($array_update);
      
        }
        }
  }
      
  }
  public function runController($classname){
       if($this->isControllerName($classname)){
       $new_classname=$this->filterControllerName($classname);
       preg_match_all('((?:^|[A-Z])[^A-Z]*)', $new_classname, $matches);
      if(isset($matches[0]) and count($matches[0])>0){
       $count_ll=count($matches[0]);
       $count_ll--;

       if(in_array(strtolower($matches[0][$count_ll]),$this->getInstalledPlugins())){
       $name_plugin=strtolower($matches[0][$count_ll]);

       if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".$classname.".php"))
     {
      if(!class_exists("CoreAdminControllerPlugin")){
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreAdminControllerPlugin.php";
      }
require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".$classname.".php";
$new_class=new $classname(NoiCore::app()->get());
     if(is_object($new_class)){
       return $new_class;
     }else {
         return false;
     }
     }

       }
      }

       exit;
       }else {
           return false;
       }
    }

       public function filterControllerName($classname){
     $pos      = strripos($classname, "ACP");
     if(!is_bool($pos)){
      $classname=str_replace("ACP","",$classname);
      return $classname;
     }else {
     $pos      = strripos($classname, "AdminControllerPlugin");
     if(!is_bool($pos)){
         $classname=str_replace("AdminControllerPlugin","",$classname);
       return $classname;
     }else {
         return false;
     }
     }
    }
    public function isControllerName($classname){
     $pos      = strripos($classname, "ACP");
     if(!is_bool($pos)){

      return true;
     }else {
     $pos      = strripos($classname, "AdminControllerPlugin");
     if(!is_bool($pos)){
       return true;
     }else {
         return false;
     }
     }
    }

}

