<?php
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/PluginDB.php";
 
require_once PATH_TO_ENGINE."/extensions/Ratchet/autoload.php";
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use noicms\mongogrid\system_core\MGQuery;
use noicms\core\StrInput; 
abstract class CorePusherControllerPlugin implements WampServerInterface{
    protected $subscribedTopics = array();
     public $name_plugin="";
    public $path_plugin="";
    public $site_data;
    public $collections=array();
    public $plugin_config=array();
    public $iswidget=0;
    public $widget=array();
    public $folder_contain="";
    public $inner_href='';
    public $__db_plugin=null;
    public function __construct($name_plugin,$site) {
 
 if(!isset($_GET['page'])){
 if(isset($_GET['config_field'])){
 $_GET['page']="config/".$_GET['config_field'];
 }else {
 $_GET['page']="";
 }
 }
     $this->inner_href=$_GET['page'];
     $this->name_plugin=$name_plugin;
     $name_class=get_class($this);
     $name_class=  str_replace(ucfirst($name_plugin)."AdminControllerPlugin", "", $name_class);
     $name_class=  str_replace(ucfirst($name_plugin)."ACP", "", $name_class);
      if(strlen($name_class)>0){
      $name_class=  mb_strtolower($name_class);
      $this->folder_contain=$name_class;
      }
     $this->site_data=$site;
     \Yii::$app->params['current_site_id']=$this->site_data['_id']->__toString();

     $this->path_plugin=YII_PLUGIN_PATH."".$name_plugin."/views/admin/";
       if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/config.php")){
         include( YII_PLUGIN_PATH."".$name_plugin."/config.php");


         if(isset($plugin_config)){
         $this->plugin_config=$plugin_config;
         }
     }
    }
    public function onSubscribe(ConnectionInterface $conn, $topic) {
        $this->subscribedTopics[$topic->getId()] = $topic;
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

 return 'componentviews.'.$path."";
    }
  public function getPluginPath($view){
  $array_files=array();
if(strlen($this->folder_contain)>0){
  $array_files[]=YII_PLUGIN_PATH.$this->name_plugin."/views/admin/".$this->folder_contain."".$view.".php";

}
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
public function getUrl($url){
 if(isset($this->site_data['_id'])){
 if(isset(\Yii::$app->params['type_run']) and \Yii::$app->params['type_run']=="ajax"){
 $url="javascript:javascript:click_one('".ShoutPlugin::getRoute2()."widget/mysites_components/plugins/".$this->site_data['_id']->__toString()."?plugin_selected=".$this->name_plugin."&page=".$url."&type_run=ajax');";
 }else {
$url=  ShoutPlugin::getRoute2()."widget/mysites_components/plugins/".$this->site_data['_id']->__toString()."?plugin_selected=".$this->name_plugin."&page=".$url;
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
   yii::import("alias_plugin.".$this->name_plugin.".".$folder.".*");
  }
  public function db(){
  if($this->__db_plugin==NULL){
   $this->__db_plugin=new PluginDB($this->site_data['_id']->__toString());
  }
  return $this->__db_plugin;
  }
}


