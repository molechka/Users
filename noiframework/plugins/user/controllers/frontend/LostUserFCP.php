<?php
use noicms\mongogrid\OneField;
class LostUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("user",$cur,$route);

    }
    public function actionRestore($hash_new){
    $main_conf=$this->get_value();
    if(!isset($main_conf[0]['collection'])){
        return false;
    }
    $collection=$main_conf[0]['collection'];
    $op=0;
    if(isset($hash_new)){
    $result_user=$this->db()->query(array(),$collection,array('lost_field_hash_enable'=>1,'lost_field_hash'=>$hash_new));
   
    if(isset($result_user[0]['_id'])){
    if(isset($_POST['restore_password']) and isset($_POST['restore_password_2']) and strlen($_POST['restore_password'])>=6){
     $field_password=$this->getPassword();

     if(isset($field_password['name']) and isset($field_password['type'])){
     $tmp_p=new OneField();
     $tmp_p->init($field_password['name'],$field_password['type'],array());
     $_POST[$tmp_p->getName()]=$_POST['restore_password'];
     $_POST[$tmp_p->getName()."_2"]=$_POST['restore_password_2'];
     $tmp_value=$tmp_p->setInput();
     if($tmp_value===FALSE){

     }else {
     $update_array=array();
     $update_array[$field_password['name']]=$tmp_value;
     $update_array['lost_field_hash_enable']=0;
     $this->user()->update($update_array,$result_user[0]['_id']->__toString());
     $this->redirect("/");
     }
     }
    }
     
    return $this->render("restore");
    
   }
    }
    }
    public function actionIndex(){
     $main_conf=$this->get_value();
    if(!isset($main_conf[0]['collection'])){
        return false;
    }
    $op=0;
    $collection=$main_conf[0]['collection'];
   if(isset($_POST['lost_email']) and filter_var($_POST['lost_email'], FILTER_VALIDATE_EMAIL)){
   $field_email=$this->getEmail();
   $result_user=$this->db()->query(array(),$collection,array($field_email=>$_POST['lost_email']));
   if(isset($result_user[0]['_id']) and isset($main_conf[0]['text_lost_mail_from']) and isset($main_conf[0]['text_lost_mail_subject']) and isset($main_conf[0]['text_lost_mail'])){  $site=$this->site_data['_id']->__toString();
  $custom_str=date('YmdHis').$site."".$result_user[0]['_id']->__toString();
  $hash_new=hash("sha512",$custom_str);
  $update_array=array();
  $update_array['lost_field_hash']=$hash_new;
  $update_array['lost_field_hash_enable']=1;
  $this->user()->update($update_array,$result_user[0]['_id']->__toString());
 $text=$main_conf[0]['text_lost_mail'];
 $link="http://".$_SERVER['HTTP_HOST']."/user/lost/restore/".$hash_new;

 $text=str_replace("[link]",$link,$text);
NoiCore::app()->email($result_user[0][$field_email], $main_conf[0]['text_lost_mail_subject'], $text,$main_conf[0]['text_lost_mail_from']);
 $op=1;
   }
 
   }
    return $this->render("index",array('status_op'=>$op));
    }
      public function getEmail(){
    $all_fields=$this->get_value('fields');
    $result=array();
    if(isset($all_fields) and count($all_fields)>0){
    foreach($all_fields as $field){

   if(isset($field['is_email']) and $field['is_email']==1){
    return $field['name'];
   }
    }
    }

    }
     public function getPassword(){
    $all_fields=$this->get_value('fields');
    $result=array();
    if(isset($all_fields) and count($all_fields)>0){
    foreach($all_fields as $field){

   if(isset($field['is_password']) and $field['is_password']==1){
    return $field;
   }
    }
    }

    }

}
