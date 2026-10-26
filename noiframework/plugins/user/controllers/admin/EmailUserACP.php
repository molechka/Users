<?php

class EmailUserACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('user',$site);

 }
 public function actionIndex(){
    

   $roles=NoiCore::app()->getListRoles();
   $fields=$this->getFields();
   if(isset($_POST['email_subject']) and isset($_POST['email_text']) and isset($_POST['field']) and in_array($_POST['field'],$fields)){
   $condition=array();
   $condition['blocked']=array('$ne'=>1);
   if(isset($_POST['who']) and in_array($_POST['who'],$roles)){
   $condition['role']=$_POST['who'];
   }
   $query2=$this->db()->query2(array(),"cms_users",$condition);
   if(isset($query2) and count($query2)>0){
   foreach($query2 as $user){
   if(isset($user[$_POST['field']])){
   NoiCore::app()->email($user[$_POST['field']],$_POST['email_subject'],$_POST['email_text']);
   }
   }
   }
   }
   return $this->render("index",array('roles'=>$roles,'fields'=>$fields));
 }
 public function getFields(){
 $result_array=array();
 $conf_fields=$this->get_value("fields");
 if(isset($conf_fields) and count($conf_fields)>0){
 foreach($conf_fields as $field){
 if($field['type']=="email"){
 $result_array[]=$field['name'];
 }
 }
 }
 return $result_array;
 }
}

