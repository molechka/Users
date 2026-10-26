<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterUserFCP
 *
 * @author backdoor
 */
use noicms\mongogrid\OneField;
use user\models\UserAccount;
 
class RegisterUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
     
        parent::__construct("user",$cur,$route);
        $this->iswidget=0;
        
 
    }
  
    
    public function actionIndex(){
    if($this->user()->isLogin()){
    $html=$this->runPlugin("user",array('lk',"index"));
    return $this->render("auth_user",array('html'=>$html));
    }
  $this->iswidget=0;
    $main_conf=$this->get_value();
   $status_activate=$this->get_value("status_activate");
   $isactivate=0;
   if(isset($status_activate[0]['status']) and $status_activate[0]['status']==1){
   $isactivate=1;
   }

    if(isset($main_conf[0]['status_register']) and $main_conf[0]['status_register']==1){
    $fields=  UserAccount::getFields();
    $iserror=0;

            $_POST['ct_captcha']="sadasdsd";
            if(isset($_POST['ct_captcha'])){
         
         $result_super_check=true;
            if ($result_super_check == false) {
                
            }else {
    if(isset($_POST['act_register_now'])){
    $result=  UserAccount::checkFields($fields);
  
    if(is_array($result) and count($result)>0){
      $iscaptcha=0;
       $result_captcha=true;
      if(isset($main_conf[0]['status_captcha']) and $main_conf[0]['status_captcha']==1){
      $iscaptcha=1;
       $result_captcha=false;
      }
    
     if($iscaptcha==1){
       if(isset($_POST['noicms_captcha'])){

 $result_captcha=NoiCore::c("captcha")->check("noicms_captcha",$_POST['noicms_captcha']);
 }else {
 $result_captcha=false;
 }
     

     }



      if(isset($main_conf[0]['collection']) and $result_captcha==true){
          UserAccount::insert($isactivate,$result);
    }else {
      $iserror=1;
    }
    }else {
    if($result===FALSE){
    $iserror=1;
    }
    }
    }
    }
            }
 
 $data=array();
 $data['iserror']=$iserror;
 $data['fields']=$fields;
 $data['iscaptcha']=0;
 if(isset($main_conf[0]['status_captcha']) and $main_conf[0]['status_captcha']==1){
 
$data['captcha']=NoiCore::c("captcha")->get("noicms_captcha");
$data['iscaptcha']=1;
 }
 return  $this->render("register",$data);

    }

    }
    public function actionAjax($name_field,$value,$value2=0){
     if(isset($name_field) and isset($value)){
     if(UserAccount::checkField($name_field,$value,$value2)){
      echo '1';   
     }else {
     if(isset($_POST['error_message']) and isset($_POST['error_key'])){
      echo $_POST['error_key']." ".$_POST['error_message'];    
     }else {    
      echo '0';   
     }
     }    
     }  
     exit;
    }
     

}