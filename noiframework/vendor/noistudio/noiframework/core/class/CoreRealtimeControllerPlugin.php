<?php
require_once PATH_TO_ENGINE."/vendor/noicms/core/class/PluginDB.php";
 
require_once PATH_TO_ENGINE."/extensions/Ratchet/autoload.php";
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use noicms\core\StrInput; 
use noicms\mongogrid\system_core\MGQuery;
abstract class CoreRealtimeControllerPlugin implements MessageComponentInterface{
    protected $clients;
     public $sessions_array=array();
     public $users_array=array();
     public $connections=array();
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
     $this->clients = new \SplObjectStorage;
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
  public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        $this->collections[$conn->resourceId]=$conn;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $result_tmp=  json_decode($msg,true);

      if(isset($result_tmp['session_id'])){
       $result_user=NoiCore::user()->load($result_tmp['session_id'],"session_id");
       if(isset($result_user['_id'])){
      $this->sessions_array["user_".$from->resourceId]=$result_user['_id']->__toString();
       $this->users_array["user_".$result_user['_id']->__toString()]=$from->resourceId;
       }

       return false;
      }
//        foreach ($this->clients as $client) {
//            if ($from !== $client) {
//                // The sender is not the receiver, send to each client connected
//                $client->send($msg);
//            }
//        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
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
 
  return NoiCore::app()->db();
  }
  public function isLogin($conn){
   if(isset($this->sessions_array["user_".$conn->resourceId])){
     $myuser=NoiCore::user()->load($this->sessions_array["user_".$conn->resourceId]);
     if(isset($myuser['_id'])){
      return true;
     }else {
         return false;
     }
   
   }else {
     return false;
   }
      
  }
  public function getUser($conn){
 if(isset($this->sessions_array["user_".$conn->resourceId])){
   $myuser=NoiCore::user()->load($this->sessions_array["user_".$conn->resourceId]);
   return $myuser;
   }else {
     return null;
   }
  }
}


