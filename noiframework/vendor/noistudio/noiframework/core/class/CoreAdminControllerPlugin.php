<?php
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/PluginDB.php";
 
use noicms\core\StrInput; 
use noicms\mongogrid\system_core\MGQuery; 
abstract class CoreAdminControllerPlugin{
     public $name_plugin="";
    public $path_plugin="";
    public $path_theme="";
    public $admin_theme="";
    public $site_data;
    public $collections=array();
    public $plugin_config=array();
    public $iswidget=0;
    public $widget=array();
    public $folder_contain="";
    public $inner_href='';
    public $__db_plugin=null;
    public function lang($key){
      if(isset($key)){
       
       $result=NoiCore::app()->lang($key,$this->name_plugin);
       if($result==$key){
          $result=NoiCore::app()->lang($key,"");
       }
       return $result;
      }else {
         return 0;
      }
    }
    public function __construct($name_plugin,$site=array()) {
       if(isset($_GET['type_run'])){
  Yii::$app->params['type_run']=$_GET['type_run'];
 }
 if(!isset($_GET['page'])){
  $_GET['page']="";
 }
 if(is_array($name_plugin)){
     
  $site=$name_plugin;   
 
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
     $this->inner_href=$_GET['page'];
     $this->name_plugin=$name_plugin;
     $this->path_theme=DOCUMENT_ROOT."themes/admin/".Yii::$app->params['admin_theme']."/page/plugin/".$name_plugin."/";
    

     $this->admin_theme=Yii::$app->params['admin_theme'];
     $name_class=get_class($this);
     $name_class=  str_replace(ucfirst($name_plugin)."AdminControllerPlugin", "", $name_class);
     $name_class=  str_replace(ucfirst($name_plugin)."ACP", "", $name_class);
      if(strlen($name_class)>0){
      $name_class=  mb_strtolower($name_class);
      $this->folder_contain=$name_class;
      }
     $this->site_data=$site;
  //   Yii::$app->params['current_site_id']=$this->site_data['_id']->__toString();

     $this->path_plugin=YII_PLUGIN_PATH."".$name_plugin."/views/admin/";
       if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/config.php")){
         include( YII_PLUGIN_PATH."".$name_plugin."/config.php");


         if(isset($plugin_config)){
         $this->plugin_config=$plugin_config;
         }
     }
    }
    public function redirect($url=""){
  if(strlen($url)>0){
 Yii::$app->getResponse()->redirect($url, 302)->send();($url);
  }
  }
  public function return_back(){
  if(isset($_SERVER['HTTP_REFERER'])){
    $this->redirect($_SERVER['HTTP_REFERER']);
  }
  }
 public function render_array($array,$data,$only_path=0){
    if(is_array($array) and count($array)>0){
    foreach($array as $file){
    if(file_exists($file)){
    
    if($only_path==1){
    return $file;
    }else {
  //  $return=\Yii::$app->controller->renderFile($file,$data,true);
   $return=NoiCore::app()->render($file,$data);

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
    public function render($view,$data=array()){
   $return="";
   $array_views=array();

  if(strlen($this->folder_contain)>0){
 if(file_exists($this->path_theme."".$this->folder_contain."/".$view.".php")){
   $array_views[]=$this->path_theme."".$this->folder_contain."/".$view.".php";
 }
    if(file_exists($this->path_plugin."".$this->folder_contain."/".$view.".php")){
   $array_views[]=$this->path_plugin."".$this->folder_contain."/".$view.".php";
 }
  }
   if(file_exists($this->path_theme."".$view.".php")){
 $array_views[]=$this->path_theme."".$view.".php";
 }
 if(file_exists($this->path_plugin."".$view.".php")){
 $array_views[]=$this->path_plugin."".$view.".php";
 }
 if(count($array_views)>0){
  $data['controller']=&$this;
 if(!isset($data['value'])){
 $data['value']=$this->get_value();
 }
 if(!isset($data['site'])){
 $data['site']=$this->site_data;
 }
 if(isset(Yii::$app->params['current_page'])){
 $data['current_page']=Yii::$app->params['current_page'];

 }else {
 $data['current_page']="";
 }
 $data['widget_page']="";
 if(isset(Yii::$app->params['widget_page'])){
$data['widget_page']=Yii::$app->params['widget_page'];
 }
 $return=$this->render_array($array_views, $data);

 if($view=="toolbar"){

if(isset(Yii::$app->params['type_run']) and Yii::$app->params['type_run']=="ajax"){
 $toolbar_data=SiteComponent::render_setup("plugins_component_all_links_ajax",array('plugin_config'=>$this->plugin_config,'site'=>$this->site_data,'id_site'=>$this->site_data['_id']->__toString(),'name_plugin'=>$this->name_plugin,'controller'=>$this));
}else {
 $toolbar_data=SiteComponent::render_setup("plugins_component_all_links",array('plugin_config'=>$this->plugin_config,'site'=>$this->site_data,'id_site'=>$this->site_data['_id']->__toString(),'name_plugin'=>$this->name_plugin,'controller'=>$this));
}

 $return=$return."".$toolbar_data;
 }
 return $return;
 }
}
    public function render2($view,$data=array()){
   $return="";
    
  if(strlen($this->folder_contain)>0){

    if(file_exists($this->path_plugin."".$this->folder_contain."/".$view.".php")){
 $data['controller']=&$this;
 if(!isset($data['value'])){
 $data['value']=$this->get_value();
 }
 if(!isset($data['site'])){
 $data['site']=$this->site_data;
 }
 $return=NoiCore::app()->render($this->path_plugin."".$this->folder_contain."/".$view.".php",$data);

 if($view=="toolbar"){
     
if(isset(Yii::$app->params['type_run']) and Yii::$app->params['type_run']=="ajax"){
 $toolbar_data=SiteComponent::render_setup("plugins_component_all_links_ajax",array('plugin_config'=>$this->plugin_config,'site'=>$this->site_data,'id_site'=>$this->site_data['_id']->__toString(),'name_plugin'=>$this->name_plugin,'controller'=>$this));
}else {
 $toolbar_data=SiteComponent::render_setup("plugins_component_all_links",array('plugin_config'=>$this->plugin_config,'site'=>$this->site_data,'id_site'=>$this->site_data['_id']->__toString(),'name_plugin'=>$this->name_plugin,'controller'=>$this));
}

 $return=$return."".$toolbar_data;
 }
 return $return;
 }
  }
 if(file_exists($this->path_plugin."".$view.".php")){
 $data['controller']=&$this;
 if(!isset($data['value'])){
 $data['value']=$this->get_value();
 }
 if(!isset($data['site'])){
 $data['site']=$this->site_data;
 }
 
  
 $return=NoiCore::app()->render($this->path_plugin."".$view.".php",$data);
  
 if($view=="toolbar"){
   
// $toolbar_data=SiteComponent::render_setup("plugins_component_all_links",array('plugin_config'=>$this->plugin_config,'site'=>$this->site_data,'id_site'=>$this->site_data['_id']->__toString(),'name_plugin'=>$this->name_plugin,'controller'=>$this));
 if(isset(Yii::$app->params['type_run']) and Yii::$app->params['type_run']=="ajax"){
 $toolbar_data=SiteComponent::render_setup("plugins_component_all_links_ajax",array('plugin_config'=>$this->plugin_config,'site'=>$this->site_data,'id_site'=>$this->site_data['_id']->__toString(),'name_plugin'=>$this->name_plugin,'controller'=>$this));
}else {
 $toolbar_data=SiteComponent::render_setup("plugins_component_all_links",array('plugin_config'=>$this->plugin_config,'site'=>$this->site_data,'id_site'=>$this->site_data['_id']->__toString(),'name_plugin'=>$this->name_plugin,'controller'=>$this));
}
 $return=$return."".$toolbar_data;
 }

// if(isset(Yii::$app->params['type_run']) and Yii::$app->params['type_run']=="ajax"){
//   echo $return;
//   exit;
// }else {
// return $return;
// }
 return $return;
 }
}
 public function get_value($field="default"){
  if(strlen($field)==0){
   $field="default";
  }

   if(isset($this->site_data['theme_components']['plugins']['mongogrid_values'][$this->name_plugin][$field])){
    return $this->site_data['theme_components']['plugins']['mongogrid_values'][$this->name_plugin][$field];
   } else {
      return array();
   }



}
 public function getPathRoute($path){

   
 if(file_exists(DOCUMENT_ROOT.""."themes/admin/".$this->admin_theme."/page/component/mysites/".$path.".php")){
return DOCUMENT_ROOT.""."themes/admin/".$this->admin_theme."/page/component/mysites/".$path.".php";
 }else {
return PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/mysites/".$path.".php";
 }
 
    }
  public function getPluginPath($view){
  $array_files=array();
if(strlen($this->folder_contain)>0){
  $array_files[]=$this->path_theme."".$this->folder_contain."/".$view.".php";
  $array_files[]=YII_PLUGIN_PATH.$this->name_plugin."/views/admin/".$this->folder_contain."/".$view.".php";

}
  $array_files[]=$this->path_theme."".$view.".php";
  $array_files[]=YII_PLUGIN_PATH.$this->name_plugin."/views/admin/".$view.".php";

  if(count($array_files)>0){
  foreach($array_files as $file){

  if(file_exists($file)){
 
      return $file;
  }
  }
  }

  }
     public function getPathRoutePlugin($path){
 
 
 return 'alias_plugin.'.$this->name_plugin.'.views.admin.'.$path."";

     }
     public function getRoute($url){
       return $this->getUrl($url);
     }
      public function setNotify($str=""){
 NoiCore::app()->setNotify($str);
  }
public function getUrl($url){
 if(isset($this->site_data['_id'])){
 if(isset(Yii::$app->params['type_run']) and Yii::$app->params['type_run']=="ajax"){
 $url="javascript:javascript:click_one('".ShoutPlugin::getRoute2()."widget/mysites_components/plugins/".$this->site_data['_id']->__toString()."?plugin_selected=".$this->name_plugin."&page=".$url."&type_run=ajax');";
 }else {
//$url=  ShoutPlugin::getRoute2()."widget/mysites_components/plugins/".$this->site_data['_id']->__toString()."?plugin_selected=".$this->name_plugin."&page=".$url;
$url=  NoiCore::app()->getRoute('p_'.$this->name_plugin."/".$url);
 }
 }
return $url;
}
 public function getPreviewUrl($url){

  if(isset($this->site_data['domain_site']) and $this->site_data['domain_site']!="www"){
 $link="http://".$this->site_data['domain_site'].".".$_SERVER['HTTP_HOST']."/".$this->plugin_config['route']."/".$url.".html";
  }else {
 $link="http://".$_SERVER['HTTP_HOST']."/".$this->plugin_config['route']."/".$url.".html";
  }
   return $link;
 }
 public function getFrontendUrl($url){
   $link="";
    if(isset($this->site_data['domain_site']) and $this->site_data['domain_site']!="www"){
 $link="http://".$this->site_data['domain_site'].".".$_SERVER['HTTP_HOST']."/".$url."";
  }else {
 $link="http://".$_SERVER['HTTP_HOST']."/".$url."";
  }
  return $link;
 }
 public function export_data($site_id,$result){

     if(StrInput::is_Id($site_id)){
     if(isset($this->collections) and is_array($this->collections) and count($this->collections)>0){
      foreach($this->collections as $collection){
       $tmp_result=  MGQuery::execute2(array(), $collection,array('site_id'=>$site_id));
       if(isset($tmp_result[0]['_id'])){
       foreach($tmp_result[0] as $key=>$value){

       $tmp_result[$key]=$value;

       }

        if(isset($tmp_result[0]['_id'])){
       $tmp_result['new_id']=$tmp_result[0]['_id']->__toString();
       }
       $result[$collection]=$tmp_result;

       }
      }
     }
     }
     return $result;
    }
  public function import($folder){
  
  }
  public function db(){
  if($this->__db_plugin==NULL){
   $this->__db_plugin=new PluginDB($this->site_data['_id']->__toString());
  }
  return $this->__db_plugin;
  }
  public function getAllWidgets($op=2){

  return NoiCore::admin()->getAllWidgets($this->name_plugin,$op);
  }
}


