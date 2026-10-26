<?php
use noicms\mongogrid\system_core\MGQuery;
class PluginDB{
    public $site_id=false;
   public function __construct($site_id) {
      $this->site_id=$site_id;
   }
   public function query($select,$collection,$condition=array(),$sort=array('_id'=>-1),$limit=25,$offset=0){
    if(NoiCore::app()->db()->canAdd()){
    if($collection!="widget_user_sites"){
    $condition['site_id']=$this->site_id;
    }else {
    $condition['_id']=new MongoId($this->site_id);
    }
    }
   return MGQuery::execute($select, $collection, $condition, $sort, $limit, $offset);
   }
   public function query2($select,$collection,$condition=array(),$sort=array('_id'=>-1)){
   if(NoiCore::app()->db()->canAdd()){
   if($collection!="widget_user_sites"){
    $condition['site_id']=$this->site_id;
    }else {
    $condition['_id']=new MongoId($this->site_id);
    }
   }
   return MGQuery::execute2($select, $collection, $condition, $sort);
   }
   public function insert(&$array,$collection){
    if(NoiCore::app()->db()->canAdd()){
     if($collection!="widget_user_sites"){
    $array['site_id']=$this->site_id;
    $array['_id']=new MongoId();
    }else {
    $array['_id']=new MongoId($this->site_id);
    }
    }


   $result=MGQuery::insert($array, $collection);
 
  return $array;
   }
   public function count($collection,$condition=array()){
    if(NoiCore::app()->db()->canAdd()){
    if($collection!="widget_user_sites"){
    $condition['site_id']=$this->site_id;
    }else {
    $condition['_id']=new MongoId($this->site_id);
    }
    }
 
   return MGQuery::count($collection, $condition);
   }
   public function update($array,$collection,$condition,$multiple = false,$modifier = '$set'){
   if(NoiCore::app()->db()->canAdd()){
        if($collection!="widget_user_sites"){

  $array['site_id']=$this->site_id;
  $condition['site_id']=$this->site_id;
    }else {
    $condition['_id']=new MongoId($this->site_id);
    }
   }
    
 
  return MGQuery::update($array, $collection, $condition, $multiple, $modifier);

   }
   public function delete($collection,$criteria){
   if(NoiCore::app()->db()->canAdd()){
   if($collection!="widget_user_sites"){
    $criteria['site_id']=$this->site_id;
    }else {
    $criteria['_id']=new MongoId($this->site_id);
    }
   }

   return MGQuery::delete($collection,$criteria);
   }
}

