<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace noicms\commands;

use yii\console\Controller;
use noicms\mongogrid\system_core\MGQuery;
use MongoId;
use NoiCore;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($name_plugin="000")
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
    $result_site=MGQuery::execute(array(),'widget_user_sites',array());

    if(isset($result_site[0]['theme_components']['plugins']['available']) and count($result_site[0]['theme_components']['plugins']['available'])>0){
        \NoiCoreSet::add($result_site[0]);
        \NoiCore::app()->setParam("iscron",true);

  if($name_plugin=="000"){
    
   foreach($result_site[0]['theme_components']['plugins']['available'] as $plugin){

 $this->doFindController($plugin,$result_site[0]);
  }

 
  }else {
  $name_plugin=trim($name_plugin);
 
 
  if(in_array($name_plugin,$result_site[0]['theme_components']['plugins']['available'])){
   return $this->doFindController($name_plugin,$result_site[0]);
  }
  }
    }
   }
    }
     public function doFindController($name_plugin,$site){
    $path_to_plugin=YII_PLUGIN_PATH."".$name_plugin."/controllers/cron/".  ucfirst($name_plugin)."CCP.php";
    $array_path=array();
    $array_path[]=array('path'=>$path_to_plugin,'name_class'=>ucfirst($name_plugin)."CCP");
    $path_to_plugin2=YII_PLUGIN_PATH."".$name_plugin."/controllers/cron/".  ucfirst($name_plugin)."CronControllerPlugin.php";
    $array_path[]=array('path'=>$path_to_plugin2,'name_class'=>ucfirst($name_plugin)."CronControllerPlugin");
  require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreCronControllerPlugin.php";
    if(is_array($array_path) and count($array_path)>0){
     foreach($array_path as $path){
      if(isset($path['path']) and file_exists($path['path'])){
  require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreCronControllerPlugin.php";
      require_once($path['path']);

       $new_object=new $path['name_class']($site);
       if(method_exists($new_object, "actionIndex")){
       $result=$new_object->actionIndex();
       return $result;
       }
      }

     }
    }
    }
}
