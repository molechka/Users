<?php
 
require_once DOCUMENT_ROOT."/conf/db.php";
if(!isset($mongodb['params'])){
$mongodb['params']=array();    
}
 if(!defined("database_name") and !defined("mongodb_string")){   

   
$string=  http_build_query($mongodb['params']);
 if(!defined("database_name")){
     define("database_name", $mongodb['db']);
 }
 
if(isset($mongodb['user']) and strlen($mongodb['user'])==0 and strlen($mongodb['password'])==0 ){
 
    $mongodb_connection_string="mongodb://".$mongodb['host']."/".$mongodb['db']."?".$string;
    
}else {
  $mongodb_connection_string="mongodb://".$mongodb['user'].":".$mongodb['password']."@".$mongodb['host']."/".$mongodb['db']."?".$string;
}
 define("mongodb_string",$mongodb_connection_string);
 }else {
     $mongodb_connection_string=mongodb_string;
 }
 
 
return [
            'class' => '\yii\mongodb\Connection',
            'dsn' => $mongodb_connection_string,
            
        ];


