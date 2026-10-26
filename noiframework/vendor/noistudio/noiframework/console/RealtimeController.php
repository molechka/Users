<?php
namespace noicms\commands;
use noicms\core\StrInput; 
use yii\console\Controller;
use noicms\mongogrid\system_core\MGQuery;
use MongoId;
use NoiCore;
require_once PATH_TO_ENGINE."/extensions/Ratchet/autoload.php";
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
class RealtimeController extends Controller
{
     public function actionIndex($name_plugin="000",$port = 8080,$site_id="")
    {
      
          require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreCronControllerPlugin.php";
   $result_dir=  scandir(YII_PLUGIN_PATH);
  if(is_array($result_dir) and count($result_dir)>0){
foreach($result_dir as $dir){
if($dir!="." and $dir!=".."){
 if(is_dir(YII_PLUGIN_PATH."".$dir."/controllers/cron/") and file_exists(YII_PLUGIN_PATH."".$dir."/controllers/cron/")){
 $new_result_dir=scandir(YII_PLUGIN_PATH."".$dir."/controllers/cron/");
 if(is_array($new_result_dir) and count($new_result_dir)>0){
    foreach($new_result_dir as $subdir){
      if($subdir!="." and $subdir!=".."){

       require_once YII_PLUGIN_PATH."".$dir."/controllers/cron/".$subdir;
      }
    }
 }
 }
}
}
}
  include(DOCUMENT_ROOT."/conf/config.php");
   if(isset($config['api_site_id'])){
   if(isset($site_id) and StrInput::is_Id($site_id)){
     $result_site=MGQuery::execute(array(),'widget_user_sites',array('_id'=>new MongoId($site_id)));
   }else {
   $result_site=MGQuery::execute(array(),'widget_user_sites',array());
   }
  

    if(isset($result_site[0]['theme_components']['plugins']['available']) and count($result_site[0]['theme_components']['plugins']['available'])>0){
        \NoiCoreSet::add($result_site[0]);

  if($name_plugin=="000"){
    echo "you not set name plugin";
   return false;

 
  }else {
  $name_plugin=trim($name_plugin);
 
 
  if(in_array($name_plugin,$result_site[0]['theme_components']['plugins']['available'])){
   return $this->doFindController($name_plugin,$result_site[0],$port);
  }
  }
    }
   }
    }
     public function doFindController($name_plugin,$site,$port){
    $path_to_plugin=YII_PLUGIN_PATH."".$name_plugin."/controllers/realtime/".  ucfirst($name_plugin)."RCP.php";
    $array_path=array();
    $array_path[]=array('path'=>$path_to_plugin,'name_class'=>ucfirst($name_plugin)."RCP");
    $path_to_plugin2=YII_PLUGIN_PATH."".$name_plugin."/controllers/realtime/".  ucfirst($name_plugin)."RealtimeControllerPlugin.php";
    $array_path[]=array('path'=>$path_to_plugin2,'name_class'=>ucfirst($name_plugin)."RealtimeControllerPlugin");
  require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreRealtimeControllerPlugin.php";
    if(is_array($array_path) and count($array_path)>0){
     foreach($array_path as $path){
      if(isset($path['path']) and file_exists($path['path'])){
  require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreRealtimeControllerPlugin.php";
      require_once($path['path']);
     
  
      

       $server = IoServer::factory(
        new  HttpServer(
            new  WsServer(
                 new $path['name_class']
            )
        ),
        $port
    );

 
      
    $server->run();  
       
    
 
//       $new_object=new $path['name_class']($site);
//       if(method_exists($new_object, "actionIndex")){
//       $result=$new_object->actionIndex();
//       return $result;
//       }
      }

     }
    }
    }

}

