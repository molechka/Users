<?php
namespace noicms\core;
use noicms\mongogrid\system_core\MGQuery;
use Yii;
use MongoClient;
use MongoId;
use MongoDate;
use NoiCore;
class ManualInstall{
  function __construct($type_op="install") {
  if(file_exists(DOCUMENT_ROOT."/conf/theme_config.php")){
    
    require_once DOCUMENT_ROOT."/conf/theme_config.php";
   if(isset($config_array['type_category']) and isset($config_array['type_theme'])){

  $new_config=$config_array;
 
  if(strlen($new_config['type_category'])==0){
      if(true){
 
   $this->install(DOCUMENT_ROOT."".THEMES_PATH.""."/".$new_config['type_theme']."/config.php", $new_config);
  


    }
  }else {
    if(file_exists(DOCUMENT_ROOT."".THEMES_PATH."".$new_config['type_category']."/".$new_config['type_theme']."/config.php")){
  $this->install(DOCUMENT_ROOT."".THEMES_PATH."".$new_config['type_category']."/".$new_config['type_theme']."/config.php", $new_config);
   
  


    }
  }
   }
  }
  }
    public function sendPost($url,$data){
    if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $out = curl_exec($curl);

    curl_close($curl);
    return $out;
  }
    }
  public function check_licence(){
 $result_return=false;
 return true;
 $files=scandir($_SERVER['DOCUMENT_ROOT']."/".NOIPRODUCT_FOLDER."/licence");
 if(isset($files) and is_array($files) and count($files)>0){
 foreach($files as $file){
 $tmp_id=str_replace(".lic","",$file);
 if($tmp_id!=$file){
 $contains=  trim(file_get_contents($_SERVER['DOCUMENT_ROOT']."/".NOIPRODUCT_FOLDER."/licence/".$file));
  $result=$this->sendPost("http://noicms.com/nmarket/check/licence", "id_licence=".$tmp_id."&secret=".$contains);
if($result=="1"){
 $result_return=true;
}
 }
 }
 }
 $result_return=true;
 return $result_return;
  }
  public function install($path,$new_config){
   $result=$this->check_licence();
    
   if($result==true){
        $count_install=MGQuery::count("install_success", array());
         
   if( $count_install==0){
        $result_array=array();
     if(file_exists(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/dump/mongo") and is_dir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/dump/mongo")){
       $dumps=scandir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/dump/mongo");
     
       if($dumps>0){
       foreach($dumps as $dump){
       $tmp_name=str_replace(".js","",$dump);
       if($dump!=$tmp_name){
       $tmp_json=  json_decode(file_get_contents(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/dump/mongo/".$dump),true);
       if(count($tmp_json)>0){
       $result_array[]=$tmp_json;
       }
       }
       }
       }
       if(count($result_array)>0){
       $dbname= Yii::$app->params['mongodb_database'];
       $connection_string=$this->getConnectionString();
       $m = new MongoClient($connection_string);
       $db = $m->selectDB($dbname);
       foreach($result_array as $json_result){
        foreach($json_result as $key=>$result){
  $tmp_collection=$db->$key;
  $tmp_collection->drop();
  if(isset($result) and count($result)>0){
  foreach($result as $row){

    if(isset($row['_id']['$id'])){
      $row['_id']=new MongoId($row['_id']['$id']);
    }
     foreach($row as $field_key=>$field_value){
      if(is_array($field_value)){
     if(isset($field_value['sec'])){
     $row[$field_key]=new MongoDate($field_value['sec']);
     }
     if(isset($field_value['_id']['$id'])){

      $row[$field_key]['_id']=new MongoId($field_value['_id']['$id']);
    }
    if(count($field_value)>0){
     foreach($field_value as $f_key=>$f_value){
    if(is_array($f_value)){
     if(isset($f_value['_id']['$id'])){

      $row[$field_key][$f_key]['_id']=new MongoId($f_value['_id']['$id']);
    }
    }
     }
    }
      }
     }
      MGQuery::insert($row, $key);
  }
  }

  }
       }
          $array_insert_install=array();
     $array_insert_install['date']=new MongoDate();
     MGQuery::insert($array_insert_install,'install_success');
       }
     }


 
    // echo "user_id:".$user_id->__toString();
     //echo "<br> site_id:".$site_id->__toString();
     
    $result=\Yii::$app->getResponse()->redirect("/", 302)->send();
return $result;
     }
   }
   }
   function getConnectionString(){
     require  DOCUMENT_ROOT."/conf/db.php";
 $mongodb_connection_string="";
 if(is_array($mongodb) and count($mongodb)>0){
if(!isset($mongodb['params'])){
$mongodb['params']=array();    
}
 
$string=  http_build_query($mongodb['params']);
  
if(strlen($mongodb['user'])==0 and strlen($mongodb['password'])==0 ){
  $mongodb_connection_string="mongodb://".$mongodb['host']."/".$mongodb['db']."?".$string;
}else {
  $mongodb_connection_string="mongodb://".$mongodb['user'].":".$mongodb['password']."@".$mongodb['host']."/".$mongodb['db']."?".$string;
}  
 }
 return $mongodb_connection_string;
   }
  }


