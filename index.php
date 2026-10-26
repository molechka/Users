<?php
 
if (php_sapi_name() == 'cli-server') {
    // Replicate the effects of basic "index.php"-hiding mod_rewrite rules
    // Tested working under FatFreeFramework 2.0.6 through 2.0.12.
    $_SERVER['SCRIPT_NAME'] = str_replace(__DIR__, '', __FILE__);
    $_SERVER['SCRIPT_FILENAME'] = __FILE__;
    $_SERVER['QUERY_STRING']=$_SERVER["REQUEST_URI"];
    
    
    $_SERVER['DOCUMENT_ROOT']=__DIR__;
    // Replicate the FatFree/WordPress/etc. .htaccess "serve existing files" bit
    $url_parts = parse_url($_SERVER["REQUEST_URI"]);
    $_req = rtrim($_SERVER['DOCUMENT_ROOT'] . $url_parts['path'], '/' . DIRECTORY_SEPARATOR);
    if (__FILE__ !== $_req && __DIR__ !== $_req && file_exists($_req)) {
        return false;    // serve the requested resource as-is.
    }
} 



 //header('Access-Control-Allow-Origin: *');
// comment out the following two lines when deployed to production
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');
 
 
 



 
include __DIR__."/conf/config.php";
if(isset($config['mustbe'])){
$_SERVER['DOCUMENT_ROOT']=$config['mustbe'];    
}
 
if(isset($config['debug']) and $config['debug']==true){
 ini_set('display_errors',1);
error_reporting(E_ALL);
define('YII_DEBUG', true);   
}else {
ini_set('display_errors',0);
error_reporting(E_NONE);
define('YII_DEBUG', false);   
}
 

ob_start();
$_POST['microtime_start']= microtime(true);
 

//define('YII_ENV', 'dev');
define("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);

define("NOIPRODUCT_FOLDER","noiframework");
define('YII_PLUGIN_PATH',DOCUMENT_ROOT."/".NOIPRODUCT_FOLDER."/plugins/");
define('YII_COMPONENT_PATH',DOCUMENT_ROOT."/".NOIPRODUCT_FOLDER."/components/");
define("YII_CACHE_TIME",300);
define("YII_CACHE_ENABLE",FALSE);

define("THEMES_PATH","/templates/");
define("ADMIN_PATH",DOCUMENT_ROOT."/themes/admin/");

define("PATH_TO_ENGINE",DOCUMENT_ROOT."/".NOIPRODUCT_FOLDER);
define("DB_TYPE","mongodb");

require(__DIR__ . '/'.NOIPRODUCT_FOLDER.'/vendor/autoload.php');
require(__DIR__ . '/'.NOIPRODUCT_FOLDER.'/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/'.NOIPRODUCT_FOLDER.'/config/web.php');

(new yii\web\Application($config))->run();


 
