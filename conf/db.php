<?php
$type_run=php_sapi_name();
 
$name_project="bugusers";
$mongodb=array();
$mongodb['host']="localhost";

$mongodb['db']=$name_project;
$mongodb['user']="";
$mongodb['password']="";
 

 

$mongodb['params']=array(
 'journal'=>true,
 
 'wTimeoutMS'=>20000   
);


