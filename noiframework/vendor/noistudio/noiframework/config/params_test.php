<?php

include(DOCUMENT_ROOT."/conf/config.php");
$http_host="";

if(!isset($config_admin['admin_folder'])){
 $config_admin['admin_folder']="admin";
}
if(!isset($config_admin['only_ip'])){
 $config_admin['only_ip']="";
}
if(!isset($config['default_language'])){
$config['default_language']="ru";
}
if(isset($_SERVER['HTTP_HOST'])){
 $http_host=$_SERVER['HTTP_HOST'];      
}
if(!isset($_SERVER['HTTP_HOST']) and isset($config_admin['http_host'])){
$http_host=$config_admin['http_host'];
}
 
//require_once PATH_TO_ENGINE . '/tests/codeception/config/db.php';
 
  
 
return [
    'adminEmail' => 'admin@example.com',
   'admin_folder'=>$config_admin['admin_folder'],
   'admin_theme'=>'noishop',
   'main_url'=>$http_host,
    "mongodb_database"=>database_name,
    'default_language'=>$config['default_language'],
];
