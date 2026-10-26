<?php

class HeadUserACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('user',$site);
 }
 public function actionCount(){
    
    $condition['setac']=array('$ne'=>1);
    $condition['file_1']=array('$options'=>'i','$regex' => "/zip");
    $condition['file_2']=array('$options'=>'i','$regex' => "/zip");
    $data['count']=NoiCore::app()->db()->count("cms_users",$condition);
     return $this->render("count",$data);
 }
 public function actionContain(){
    $condition['setac']=array('$ne'=>1);
    $condition['file_1']=array('$options'=>'i','$regex' => "/zip");
    $condition['file_2']=array('$options'=>'i','$regex' => "/zip");
    
    
    $messages=$this->db()->query2(array(),"cms_users",$condition);
    $html_messages="";
     if(isset($messages) and isset($messages[0]['_id'])){
     $html_messages=$this->render('messages',array('users'=>$messages));
     }
   return $this->render("contain",array('message'=>$html_messages));
 }
}
 

