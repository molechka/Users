<?php
 
include(DOCUMENT_ROOT."/conf/config.php");

if(!isset($config_admin['admin_folder'])){
 $config_admin['admin_folder']="admin";
}
if(!isset($config_admin['only_ip'])){
 $config_admin['only_ip']="";
}
 


 
  $route="";
    if(isset($_SERVER['PATH_INFO'])){
     $route=$_SERVER['PATH_INFO'];
     }else if(isset($_SERVER['QUERY_STRING'])){
     $route=$_SERVER['QUERY_STRING'];
     }
    $tmp_admin_found=str_replace($config_admin['admin_folder'],"",$route);
    $default_route="site/index";
    if($tmp_admin_found!=$route){
    $default_route="admin";
    }
 
$params = require(__DIR__ . '/params_test.php');

$config = [
     'defaultRoute' => "site/index",
    'id' => 'basic',
  
    'basePath' => PATH_TO_ENGINE,
    'bootstrap' => [ ],
    'modules' => array(
 
        'admin' => array(
            'class' => 'noicms\admin\AdminModule',
            
        ),

    ),
    'components' => [
       'session' => [
            'class' => 'yii\mongodb\Session',
        ],
       'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
           
            'rules' =>require(__DIR__ . '/routes.php'),  
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5ysdhUgEUf2XZci3aRDty9EOa8mVD8rD',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
         
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
         
       
        'mongodb' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];
 
 
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
