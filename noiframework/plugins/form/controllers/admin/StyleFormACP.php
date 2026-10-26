<?php

class StyleFormACP  extends CoreAdminControllerPlugin{
 
 public function __construct($site) {
     parent::__construct('form',$site);
 }
 public function actionMessages(){
       $date=date('Y-m-d');
      $prev_day=date('Y-m-d 23:59', strtotime('-1 day', strtotime($date)));
     $messages=$this->db()->query(array(),"plugin_form_messages",array('date'=>array('$gt'=>new MongoDate(strtotime($prev_day)))));
     if(isset($messages) and isset($messages[0]['_id'])){
     echo $this->render('messages',array('messages'=>$messages));
     }
     exit;
 }
}
