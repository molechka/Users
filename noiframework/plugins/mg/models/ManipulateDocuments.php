<?php

namespace mg\models;
use NoiCore;
class ManipulateDocuments{
    private $type="up";
    private $object=array();
    private $collection=array();
    private $left=array();
    private $right=array();
    private $sort=array();
    public function __construct($collection,$last_id,$type) {
    if(is_array($collection) and isset($last_id) and is_numeric($last_id) ){
    $tmp=NoiCore::app()->db()->query(array(),$collection['name'],array('last_id'=>(int)$last_id));
    if(isset($tmp[0])){
    $this->object=$tmp[0];
    if($collection['sort']==="-1"){
      $sort=array($collection['sort_field']=>-1);    
      }else {
      $sort=array($collection['sort_field']=>1);    
      }  
   $this->sort=$sort;
   $this->type=$type;
   if(isset($this->sort['order_last_id'])){
    $this->collection=$collection;   
    $this->findLeft();  
    $this->findRight();
    $this->start();
   }
   
    }
    }    
    }
    private function start(){
    if($this->type=="up" ){  
    if(isset($this->left['order_last_id'])){    
    NoiCore::app()->db()->update(array('order_last_id'=>$this->left['order_last_id']),$this->collection['name'],array('last_id'=>$this->object['last_id']));
    NoiCore::app()->db()->update(array('order_last_id'=>$this->object['order_last_id']),$this->collection['name'],array('last_id'=>$this->left['last_id']));
    }
    }else {
    if(isset($this->right['order_last_id'])){    
        NoiCore::app()->db()->update(array('order_last_id'=>$this->right['order_last_id']),$this->collection['name'],array('last_id'=>$this->object['last_id']));
    NoiCore::app()->db()->update(array('order_last_id'=>$this->object['order_last_id']),$this->collection['name'],array('last_id'=>$this->right['last_id']));     
    }
    }
    }
    private function findLeft(){
     if($this->sort['order_last_id']===1){
         $tmp=NoiCore::app()->db()->query(array(),$this->collection['name'],array('order_last_id'=>array('$lt'=>(int)$this->object['order_last_id'])),array('order_last_id'=>-1));
  
     }else {
     $tmp=NoiCore::app()->db()->query(array(),$this->collection['name'],array('order_last_id'=>array('$gt'=>(int)$this->object['order_last_id'])),array('order_last_id'=>1));
  
     }
    
     if(isset($tmp[0]['_id'])){
      $this->left=$tmp[0];   
     }
    
    }
    private function findRight(){
      if($this->sort['order_last_id']===1){
         $tmp=NoiCore::app()->db()->query(array(),$this->collection['name'],array('order_last_id'=>array('$gt'=>(int)$this->object['order_last_id'])),array('order_last_id'=>1));
  
     }else {
     $tmp=NoiCore::app()->db()->query(array(),$this->collection['name'],array('order_last_id'=>array('$lt'=>(int)$this->object['order_last_id'])),array('order_last_id'=>-1));
   
     }
    
     if(isset($tmp[0]['_id'])){
         
      $this->right=$tmp[0];   
     }   
    }
}

