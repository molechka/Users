<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use MongoClient;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
use noicms\core\StrInput; 
use MongoId;
use MongoDate;
use  yii\web\Response;
 class DbController extends AdminController{
  public $connection_string="";
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="db";
       if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
     require DOCUMENT_ROOT."/conf/db.php";
if(!isset($mongodb['params'])){
$mongodb['params']=array();    
}
 
$string=  http_build_query($mongodb['params']);
  
if(strlen($mongodb['user'])==0 and strlen($mongodb['password'])==0 ){
  $mongodb_connection_string="mongodb://".$mongodb['host']."/".$mongodb['db']."?".$string;
}else {
  $mongodb_connection_string="mongodb://".$mongodb['user'].":".$mongodb['password']."@".$mongodb['host']."/".$mongodb['db']."?".$string;
}
 
$this->connection_string=$mongodb_connection_string;

 


  }
  function array2json($arr) {
    if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
    $parts = array();
    $is_list = false;

    //Find out if the given array is a numerical array
    $keys = array_keys($arr);
    $max_length = count($arr)-1;
    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
        $is_list = true;
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
            if($i != $keys[$i]) { //A key fails at position check.
                $is_list = false; //It is an associative array.
                break;
            }
        }
    }

    foreach($arr as $key=>$value) {
        if(is_array($value)) { //Custom handling for arrays
            if($is_list) $parts[] = array2json($value); /* :RECURSION: */
            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
        } else {
            $str = '';
            if(!$is_list) $str = '"' . $key . '":';

            //Custom handling for multiple data types
            if(is_numeric($value)) $str .= $value; //Numbers
            elseif($value === false) $str .= 'false'; //The booleans
            elseif($value === true) $str .= 'true';
            else $str .= '"' . addslashes($value) . '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Object?)

            $parts[] = $str;
        }
    }
    $json = implode(',',$parts);

    if($is_list) return '[' . $json . ']';//Return numerical JSON
    return '{' . $json . '}';//Return associative JSON
}

     function actionIndex(){

 return  $this->render("index",array());
     }
       function actionImport(){
if(isset($_POST['act_import'])){
if(isset($_FILES['importfile']['tmp_name'])){
    $target_file = PATH_TO_ENGINE."/tmp/export.json";
    if(file_exists($target_file)){
     unlink($target_file);
    }
 
 
   if (move_uploaded_file($_FILES["importfile"]["tmp_name"], $target_file)) {
    $result=  file_get_contents($target_file);

//$result=str_replace('},]',"} ]",$result);
 //$result=preg_replace('/.+?({.+}).+/','$1',$result);;
 
  $json_result=  json_decode($result,true);

 
  if(is_array($json_result)){

 $dbname= Yii::$app->params['mongodb_database'];
 $m = new MongoClient($this->connection_string);
$db = $m->selectDB($dbname);


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
   } 



}
 
}
 return  $this->render("import",array());

     }
     public function afterJson($array){
      if(isset($array) and is_array($array)){
       foreach($array as $key_field=>$field){
      if(is_array($field)){
      if(isset($field['$id'])){
      $array[$key_field]=new MongoId($field['$id']);

      }else  if(isset($field['sec'])){
      $array[$key_field]=new MongoDate($field['sec']);
      }else {
      $array[$key_field]=$this->afterJson($array[$key_field]);
      }

      }
    }
      }
      return $array;
     }
     public function actionDelete($select,$rowid){
   NoiCore::admin()->setDisableConditionDb();
       $dbname= Yii::$app->params['mongodb_database'];
 $m = new MongoClient();
$db = $m->selectDB($dbname);
$list=$db->listCollections();
$array_collections=array();
foreach ($list as $collection) {
    $name_collection=$collection->getName();
    if($name_collection!="noicms_log" and $name_collection!="edms_cache" and $name_collection!="emds_httpsession" and $name_collection!="edms_log"  and $name_collection!="cache" and $name_collection!="session" and $name_collection!="widget_user_sites"){
    $array_collections[]=$name_collection;
    }

}
if(in_array($select,$array_collections) and StrInput::is_Id($rowid) ){
   NoiCore::app()->db()->delete($select,array('_id'=>new MongoId($rowid)));
    $this->redirect(NoiCore::app()->getRoute('db/m/'.$select));
}else {
    $this->redirect(NoiCore::app()->getRoute('db/m/'.$select));
}

     }
     public function actionUpdate($select,$rowid){
       NoiCore::admin()->setDisableConditionDb();
       $dbname= Yii::$app->params['mongodb_database'];
 $m = new MongoClient();
$db = $m->selectDB($dbname);
$list=$db->listCollections();
$array_collections=array();
foreach ($list as $collection) {
    $name_collection=$collection->getName();
    if($name_collection!="noicms_log" and $name_collection!="edms_cache" and $name_collection!="emds_httpsession" and $name_collection!="edms_log"  and $name_collection!="cache" and $name_collection!="session"){
    $array_collections[]=$name_collection;
    }

}
if(in_array($select,$array_collections) and StrInput::is_Id($rowid) ){
    if(isset($_POST['data'])){
    $toarray=  json_decode($_POST['data'], true);
    if(is_array($toarray)){
    if(count($toarray)>0){
    foreach($toarray as $key_field=>$field){
      if(is_array($field)){
      if(isset($field['$id'])){
      $toarray[$key_field]=new MongoId($field['$id']);

      }else  if(isset($field['sec'])){
      $toarray[$key_field]=new MongoDate($field['sec']);
      }else {
      $toarray[$key_field]=$this->afterJson($toarray[$key_field]);
      }

      }
    }
    }
    }
    NoiCore::app()->db()->update($toarray,$select,array('_id'=>new MongoId($rowid)));
    }

    $result_row=NoiCore::app()->db()->query(array(),$select,array('_id'=>new MongoId($rowid)));
    if(isset($result_row[0]['_id'])){
    unset($result_row[0]['_id']);
    
    $json=json_encode($result_row[0],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return $this->render("update_row",array('json'=>$json,'collection'=>$select,"rowid"=>$rowid,));
    }else {
        $this->redirect(NoiCore::app()->getRoute('db/m/'.$select));
    }
}else {
    $this->redirect(NoiCore::app()->getRoute('db/m/'.$select));
}
     }
     public function actionM($select=""){
 NoiCore::admin()->setDisableConditionDb();
      $dbname= Yii::$app->params['mongodb_database'];
 $m = new MongoClient();
$db = $m->selectDB($dbname);
$list=$db->listCollections();
$array_collections=array();
foreach ($list as $collection) {
    $name_collection=$collection->getName();
    if($name_collection!="noicms_log" and $name_collection!="edms_cache" and $name_collection!="emds_httpsession" and $name_collection!="edms_log"  and $name_collection!="cache" and $name_collection!="session"){
    $array_collections[]=$name_collection;
    }

}
 
if(in_array($select,$array_collections)){
 $condition=array();
 if(isset($_GET['condition'])){
 $condition_test=  json_decode($_GET['condition'],true);
 if(isset($condition_test) and is_array($condition_test) and count($condition_test)>0){
 $condition=$condition_test;
 }
 }
  $offset=NoiCore::c("ppaginator")->getOffset(10);
 
 $result_rows=NoiCore::app()->db()->query(array(),$select,$condition,array('_id'=>-1),10,$offset);
 
 $counts=NoiCore::app()->db()->count($select,$condition);
return $this->render("show_collection",array('condition'=>$condition,'collection'=>$select,'rows'=>$result_rows,'counts'=>$counts));

}

     }
     public function actionManage(){
         if(NoiCore::admin()->isRoot()){
          NoiCore::app()->setParam("connection_string",$this->connection_string);
          
         include_once(PATH_TO_ENGINE."/extensions/moadmin.php");
         }
         
         exit;
//     NoiCore::admin()->setDisableConditionDb();
//      $dbname= Yii::$app->params['mongodb_database'];
// $m = new MongoClient();
//$db = $m->selectDB($dbname);
//$list=$db->listCollections();
//$array_collections=array();
//foreach ($list as $collection) {
//    $name_collection=$collection->getName();
//    if($name_collection!="noicms_log" and $name_collection!="edms_cache" and $name_collection!="emds_httpsession" and $name_collection!="edms_log"  and $name_collection!="cache" and $name_collection!="session"){
//    $array_collections[]=$name_collection;
//    }
//
//}
//
//     return $this->render("manage",array('collections'=>$array_collections));
     }
      function actionExport(){
 $site=\NoiCore::app()->get();

if(isset($_GET['download'])){
  $dbname= Yii::$app->params['mongodb_database'];
 $m = new MongoClient($this->connection_string);
$db = $m->selectDB($dbname);
$list=$db->listCollections();
$array_collections=array();
foreach ($list as $collection) {
    $name_collection=$collection->getName();
    if($name_collection!="noicms_log" and $name_collection!="edms_cache" and $name_collection!="emds_httpsession" and $name_collection!="edms_log"  and $name_collection!="cache" and $name_collection!="session" and $name_collection!="stats_load"){
    $array_collections[]=$name_collection;
    }

}
$array_results=array();
foreach($array_collections as $collection){
if($collection=="widget_user_sites"){
 $tmp_result=  MGQuery::execute2(array(), $collection,array('_id'=>$site['_id']));
}else {
   $tmp_result=  MGQuery::execute2(array(), $collection,array('site_id'=>$site['_id']->__toString()));
}
 if(isset($tmp_result[0]['_id'])){
 $array_results[$collection]=$tmp_result;
 }

}
if(isset($array_results['widget_user_sites'][0]['_id'])){
    $array_results['widget_user_sites'][0]['subroute']="*";
}
 
//$json = json_encode($array_results);
 $target_file = PATH_TO_ENGINE."/tmp/exportdb.json"; 
 $newfile=PATH_TO_ENGINE."/vendor/noicms/core/dump/mongo/export.js";
 //file_put_contents($target_file, json_encode($array_results));
 $fh = fopen($target_file, 'w')      or die("Error opening output file");
 
fwrite($fh, json_encode($array_results));
fclose($fh);
 
header('Content-disposition: attachment; filename=export.js');
header('Content-type: application/js');

readfile($target_file);
exit;;

}else {
 return   $this->render("export",array());
}
     }
 }