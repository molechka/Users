<?php

class HeadFormACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('form',$site);
 }
 public function actionCount(){
    $data=array();
    $date=date('Y-m-d');;
    $data['date']=$date;
    $data['prev_day']=date('Y-m-d 23:59', strtotime('-1 day', strtotime($date)));
     return $this->render("count",$data);
 }
 public function actionContain(){
    $date=date('Y-m-d');
    $prev_day=date('Y-m-d 23:59', strtotime('-1 day', strtotime($date)));
    $messages=$this->db()->query(array(),"plugin_form_messages",array('date'=>array('$gt'=>new MongoDate(strtotime($prev_day)))));
    $html_messages="";
     if(isset($messages) and isset($messages[0]['_id'])){
     $html_messages=$this->render('messages',array('messages'=>$messages));
     }
   return $this->render("contain",array('message'=>$html_messages));
 }
}

