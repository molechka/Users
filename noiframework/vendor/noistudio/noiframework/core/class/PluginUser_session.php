<?php
use noicms\mongogrid\system_core\MGQuery;
class PluginUser{
   public $name_plugin="";
   public $id=0;
   public function __construct($name_plugin) {
   $this->name_plugin=$name_plugin;
   if(isset(yii::app()->session[$this->name_plugin."_user_data"])){
    if(isset(yii::app()->session[$this->name_plugin."_user_data"]['user_id'])){
    $this->id=yii::app()->session[$this->name_plugin."_user_data"]['user_id'];
    }
   }
   }
   public function login($array){
   return false;
   if(is_array($array) and count($array)>0){
   if(!isset(yii::app()->session[$this->name_plugin."_user_data"]) and !isset(yii::app()->session[$this->name_plugin."_user_login"])){
   yii::app()->session->add($this->name_plugin."_user_data",$array);
   yii::app()->session->add($this->name_plugin."_user_login",true);
   return true;
   }else {
     return false;
   }
   }else {
       return false;
   }
   }
   public function load($id_user=0,$field="_id"){
    if($id_user==0){
   $id_user=$this->id;
   }
  if($field=="_id"){
  $search_value=new MongoId($id_user);
  }else {
  $search_value=$id_user;
  }
  $result=MGQuery::execute(array(), 'user_sites_users',array($field=>$search_value,"site_id"=>$this->name_plugin));
  if(isset($result[0])){
    return $result[0];
  }else {
      return false;
  }
   }
   public function update($array,$id_user=0){
     if($id_user==0){
     if($this->isLogin()==true){
     $id_user=$this->id;
     }else {
      return false;
     }
     }
    if(isset($array) and is_array($array)){
      return MGQuery::update($array, 'user_sites_users',array('_id'=>new MongoId($id_user),"site_id"=>$this->name_plugin));
      if($id_user==yii::app()->session[$this->name_plugin."_user_data"]['user_id']){
      yii::app()->params[$this->name_plugin.'_user_'.yii::app()->session[$this->name_plugin."_user_data"]['user_id']]=$this->load($id_user);
      }
    }


   }
   public function isLogin(){
   if(isset(yii::app()->session[$this->name_plugin."_user_data"]) and is_array(yii::app()->session[$this->name_plugin."_user_data"]) and count(yii::app()->session[$this->name_plugin."_user_data"])>0 and isset(yii::app()->session[$this->name_plugin."_user_login"]) and yii::app()->session[$this->name_plugin."_user_login"]===TRUE){
   return true;
   }else {
     //  var_dump(yii::app()->session[$this->name_plugin."_user_data"]);
      // var_dump(yii::app()->session[$this->name_plugin."_user_login"]);
      // exit;
   return false;
   }
   }
   public function toArray(){
    if(isset(yii::app()->session[$this->name_plugin."_user_data"]) and is_array(yii::app()->session[$this->name_plugin."_user_data"])  and yii::app()->session[$this->name_plugin."_user_login"]===TRUE){
   return  yii::app()->session[$this->name_plugin."_user_data"];

   }else {
    return false;
   }
   }
   public function logout(){
      if(isset(yii::app()->session[$this->name_plugin."_user_data"]) and is_array(yii::app()->session[$this->name_plugin."_user_data"]) and count(yii::app()->session[$this->name_plugin."_user_data"])>0 and isset(yii::app()->session[$this->name_plugin."_user_login"]) and yii::app()->session[$this->name_plugin."_user_login"]===TRUE){
   unset(yii::app()->session[$this->name_plugin."_user_data"]);
   unset(yii::app()->session[$this->name_plugin."_user_login"]);
   return true;
   }else {
   return false;
   }
   }
   public function isRole($role_val){
   $role=$this->getLogged('role');
   if(isset($role) and is_array($role)){
   if(in_array($role_val, $role)){
    return true;
   }
   }
   return false;
   }

   public function getLogged($field){
   if(isset(yii::app()->session[$this->name_plugin."_user_data"]) and is_array(yii::app()->session[$this->name_plugin."_user_data"]) and count(yii::app()->session[$this->name_plugin."_user_data"])>0 and isset(yii::app()->session[$this->name_plugin."_user_login"]) and yii::app()->session[$this->name_plugin."_user_login"]===TRUE){
  if(!isset(yii::app()->params[$this->name_plugin.'_user_'.yii::app()->session[$this->name_plugin."_user_data"]['user_id']])){
  $result=$this->load(yii::app()->session[$this->name_plugin."_user_data"]['user_id']);
  $result['user_id']=yii::app()->session[$this->name_plugin."_user_data"]['user_id'];
  yii::app()->params[$this->name_plugin.'_user_'.yii::app()->session[$this->name_plugin."_user_data"]['user_id']]=$result;
 if(isset($result[$field])){
  return $result[$field];
 }else {
  return false;
 }
  }else   {
    if(isset(yii::app()->params[$this->name_plugin.'_user_'.yii::app()->session[$this->name_plugin."_user_data"]['user_id']][$field])){
     return yii::app()->params[$this->name_plugin.'_user_'.yii::app()->session[$this->name_plugin."_user_data"]['user_id']][$field];
    }else {
     return false;
    }
  }
   }else {
    return false;
   }
   }
}

