<?php

class ActivateUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("user",$cur,$route);
if($this->user()->isLogin()){
  $this->redirect("/");
}
 
    }
    public function actionIndex($hash){
 $status_activate=$this->get_value("status_activate");
 $main_conf=$this->get_value();
 if(isset($status_activate[0]['status']) and $status_activate[0]['status']==1){
  $collection="";
  if($this->site_data['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection']){
      $collection=$this->site_data['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'];
     $result=$this->db()->query(array(),$collection,array('enable_account'=>0,'activate_email'=>$hash));
    
       
    if(isset($result[0]['_id'])){
        
    $this->db()->update(array('enable_account'=>1),$collection,array('_id'=>new MongoId($result[0]['_id']->__toString())));
      
     if(isset($main_conf[0]['auto_login']) and $main_conf[0]['auto_login']==1){
      
      $result[0]['user_id']=$result[0]['_id']->__toString();
     // $user_identify->result=$result[0];

      NoiCore::app()->setSession("user_auth",1);
      NoiCore::app()->setSession("user_id",$result[0]['_id']->__toString());
      NoiCore::app()->setSession("user_result",$result[0]);
      $this->redirect($main_conf[0]['after_login']);
       }else {
      $this->redirect("/");
       }
    }
  }
    
 }
    }
     public function getLogin(){
    $all_fields=$this->get_value('fields');
    $result=array();
    if(isset($all_fields) and count($all_fields)>0){
    foreach($all_fields as $field){

   if(isset($field['is_login']) and $field['is_login']==1){
    return $field['name'];
   }
    }
    }

    }
}

