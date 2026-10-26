<?php
   
namespace noicms;
use yii;
use NoiCore;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
 
//if(!class_exists(Yii,true)){
//require_once PATH_TO_ENGINE . '/vendor/yiisoft' . '/yii2/Yii.php';
//}
 
require_once __DIR__ . '/core/NoiCore.php';
require_once __DIR__. '/core/NoiCoreSet.php';



 
class auto_class{
  
 function __construct() {
      
     $plugins_dirs=array();
$path = realpath(YII_PLUGIN_PATH);

$objects = new RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
 
foreach($objects as $name => $object){
$tmp_explode=explode("/",$name);
$count=count($tmp_explode);
$yes=true;
if($count>0){
$count--;
if($tmp_explode[$count]=="config.php"){
 $yes=false;

}
}
 
   if(strpos($name, "controllers")==false and strpos($name, "language")==false  and strpos($name, "/views")==false and strpos($name, ".php")!=false  and $yes==true){
   $path_plugin=str_replace("//","/",realpath(YII_PLUGIN_PATH));
 
    $path_plugin=str_replace("//","/",$path_plugin);
   if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    
     $path_plugin.="\\";
    $get_name_space=  str_replace($path_plugin, "", $name);

    $get_name_space=str_replace("\\","\\",$get_name_space);
   $get_name_space=str_replace(".php","",$get_name_space);
} else {
  $path_plugin.="/";
   $get_name_space=  str_replace($path_plugin, "", $name);

    $get_name_space=str_replace("/","\\",$get_name_space);
   $get_name_space=str_replace(".php","",$get_name_space);
}
 
   

  



//    Yii::$classMap[$get_name_space] = $name;
 

    NoiCore::load($get_name_space,$name);


//    $explode=  explode("/", $get_name_space);
//    $name_space="";
//    if(count($explode)>0){
//     foreach($explode as $ex){
//      if(strpos($ex, ".php")==false){
//       $name_space='\\'
//      }
//     }
//    }

   }
}
//$this->load_admin();
 }
 public function load_admin(){
   $plugins_dirs=array();
$path = realpath(PATH_TO_ENGINE . '/vendor/noicms' . '/core/modules/admin/');

$objects = new RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
$tmp_explode=explode("/",$name);
$count=count($tmp_explode);
$yes=true;
if($count>0){
$count--;
 
}
   if(!is_dir($name) and     strpos($name, "views")==false and strpos($name, ".php")!=false) {
 
  // noicms\admin
    $get_name_space=  str_replace(PATH_TO_ENGINE . '/vendor/noicms' . '/core/modules/admin/', "", $name);
  
    $get_name_space=str_replace("/","\\",$get_name_space);
   $get_name_space=str_replace(".php","",$get_name_space);
   $get_name_space="noicms\admin\\".$get_name_space;

//    Yii::$classMap[$get_name_space] = $name;

    NoiCore::load($get_name_space,$name);


//    $explode=  explode("/", $get_name_space);
//    $name_space="";
//    if(count($explode)>0){
//     foreach($explode as $ex){
//      if(strpos($ex, ".php")==false){
//       $name_space='\\'
//      }
//     }
//    }

   }
} 	
 }
}
if(defined("YII_TEST_ENTRY_URL")){
 
if(file_exists(__DIR__."/../../../../conf/config.php")){
  
include(__DIR__."/../../../../conf/config.php");
 
}else if(file_exists("../../conf/config.php")){
 require_once("../../conf/config.php");
}

 if(isset($config_admin['document_root'])){
define("NOIPRODUCT_FOLDER","noiframework");
 
 
define("DOCUMENT_ROOT",$config_admin['document_root']); 
 
define('YII_PLUGIN_PATH',DOCUMENT_ROOT."/".NOIPRODUCT_FOLDER."/plugins/");
define('YII_COMPONENT_PATH',DOCUMENT_ROOT."/".NOIPRODUCT_FOLDER."/components/");
define("YII_CACHE_TIME",300);
define("YII_CACHE_ENABLE",FALSE);

define("THEMES_PATH","/templates/");
define("ADMIN_PATH",DOCUMENT_ROOT."/themes/admin/");

define("PATH_TO_ENGINE",DOCUMENT_ROOT."/".NOIPRODUCT_FOLDER);
define("DB_TYPE","mongodb");

 
 }
}

$auto_class=new auto_class();
?>