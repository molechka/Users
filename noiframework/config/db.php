<?php  
require_once DOCUMENT_ROOT."/conf/db.php";
if(strlen($mongodb['user'])==0 and strlen($mongodb['password'])==0 ){
  $mongodb_connection_string="mongodb://".$mongodb['host']."/".$mongodb['db']."?journal=true&w=majority&wTimeoutMS=20000";
}else {
  $mongodb_connection_string="mongodb://".$mongodb['user'].":".$mongodb['password']."@".$mongodb['host']."/".$mongodb['db']."?journal=true&w=majority&wTimeoutMS=20000";
}
include(DOCUMENT_ROOT."/conf/config.php");

if(!isset($config_admin['admin_folder'])){
 $config_admin['admin_folder']="admin";
}
if(!isset($config_admin['only_ip'])){
 $config_admin['only_ip']=""; 
}
 
return [
            'class' => '\yii\mongodb\Connection',
            'dsn' => $mongodb_connection_string,
        ];


