<?php
include_once(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/db/mongolite/Client.php");
include_once(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/db/mongolite/Collection.php");
include_once(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/db/mongolite/Cursor.php");
include_once(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/db/mongolite/Database.php");
include_once(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/db/mongolite/MongoId.php");
 class LiteQuery{
     static $path_db="/mydb";
     static $name_db="release_db2";
     static $client=null;
     static public function getPath(){
     return PATH_TO_ENGINE.LiteQuery::$path_db;
     }
     static public function getDB(){
      if(LiteQuery::$client!=null){

       $name_db=LiteQuery::$name_db;

        return LiteQuery::$client->$name_db;
      }else {
     LiteQuery::$client     = new MongoLite\Client(LiteQuery::getPath());
     $name_db=LiteQuery::$name_db;
   return   LiteQuery::$client->$name_db;
      }
     }
     static public function toID($array=array()){

        if(isset($array[0]['_id'])){
     foreach($array as $key=>$row){
     if(isset($array[$key]['_id'])){
     $array[$key]['_id']=new MongoLite\MongoId($array[$key]['_id']);
     }
     }
     }
     
     return $array;
     }
     static public function execute($select,$collection,$condition=array(),$sort=array('_id'=>-1),$limit=25,$offset=0){

     $database   = LiteQuery::getDB();
     $obj_collection=$database->$collection;
     $result=$obj_collection->find($condition,$sort,$limit,$offset);

    $result=  LiteQuery::toID($result);
   if(isset($result[0]['_id']) and $collection=="widget_user_sites"){
   if(file_exists(DOCUMENT_ROOT."/conf/config.php")){
    include_once(DOCUMENT_ROOT."/conf/config.php");
    if(isset($config['api_site_id'])){
    $result[0]['_id']=new MongoLite\MongoId($config['api_site_id']);
    }
   }
   
   }
   if(isset($result[0]['_id'])){
    $result[0]['_count_']=count($result);
   }
     return $result;
     }
     static public function execute_one($select,$collection,$condition){
        $result=  LiteQuery::execute($select, $collection,$condition,array('_id'=>-1),1,0);
        $result_one=array();
        if(isset($result[0])){
        $result_one=$result[0];
        }
        return $result_one;
     }
        static public function execute2($select,$collection,$condition=array(),$sort=array('_id'=>-1)){

     $database   = LiteQuery::getDB();
     $obj_collection=$database->$collection;
     $result=$obj_collection->find($condition,$sort);
     $result=  LiteQuery::toID($result);
      if(isset($result[0]['_id']) and $collection=="widget_user_sites"){
   if(file_exists(DOCUMENT_ROOT."/conf/config.php")){
    include_once(DOCUMENT_ROOT."/conf/config.php");
    if(isset($config['api_site_id'])){
    $result[0]['_id']=new MongoLite\MongoId($config['api_site_id']);

    }
   }
   }
    if(isset($result[0]['_id'])){
    $result[0]['_count_']=count($result);
   }
     return $result;
     }
     static public function count($collection,$condition){

     $database   = LiteQuery::getDB();
     $obj_collection=$database->$collection;
     $result=count($obj_collection->find($condition));
      
     return $result;
     }
     static public function update($array,$collection,$condition,$multiple = false,$modifier = '$set'){
         if($collection=="widget_user_sites" and file_exists(DOCUMENT_ROOT."/config.php")){
         if(isset($condition['_id'])){
         unset($condition['_id']); 
         }
         }
       if(isset($array) and isset($collection) and isset($condition)){

    if(isset($array['_id'])){
     $tmp=$array['_id'];
     if(is_object($array['_id'])){
     $array['_id']=$tmp->__toString();
     $array['row_id']=$tmp->__toString();
     }else {
     $array['row_id']=$array['_id'];
     }
     }
     if(isset($condition['_id'])){
      if(is_object($condition['_id'])){
      $condition['_id']=$condition['_id']->__toString();
      }
     }
//     if($collection=="user_blog"){
//     var_dump($condition);
//     exit;
//     }

     $database   = LiteQuery::getDB();
     $obj_collection=$database->$collection;
   $obj_collection->update($condition, $array);
     return true;
       }
     }
     static public function insert($array,$collection){
    if(is_array($array) and isset($collection)){
     if(isset($array['_id'])){
    
    // $tmp=$array['_id'];
    // $array['_id']=$tmp['$id'];
     if(is_object($array['_id'])){
      $array['_id']=$array['_id']->__toString();;
      $array['row_id']=$array['_id']->__toString();
     }else {
      $array['row_id']=$array['_id'];
     }
     }else {
     $tmp=new MongoLite\MongoId();
     $array['_id']=$tmp->__toString();
     $array['row_id']=$tmp->__toString();
    
     }


    // return EDMSQuery::instance($collection)->insert($array);
     //return true;

     $database   = LiteQuery::getDB();
     $obj_collection=$database->$collection;
   
     $result=$obj_collection->insert($array);
     
     return LiteQuery::toID($array);
    }else{
       return false;
    }
     }
     static public function delete($collection,$criteria){
      if(isset($collection) and is_array($criteria) and !empty($criteria)){
     //  $collection=$query = new EDMSQuery($collection);
     // return  $collection->remove($criteria);

     $database   = LiteQuery::getDB();
     $obj_collection=$database->$collection;
     return $obj_collection->remove($criteria);
      }
     }

      public function getList($fields,$collection,$where=array(),$limit=25,$offset=0){
 
 }
      
 }
?>