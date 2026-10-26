<?php

class PercentFormACP  extends CoreAdminControllerPlugin{
 public $name_collection="user_sites_users";
 public function __construct($site) {
     parent::__construct('form',$site);
 }

 public function actionIndex(){
      $date=date('Y-m-d');
      $prev_day=date('Y-m-d 23:59', strtotime('-1 day', strtotime($date)));
      $next_day=date('Y-m-d', strtotime('+1 day', strtotime($date)));
      $data=array();
      $data['percent_messages']=0;
       $count_all_messages=NoiCore::app()->db()->count("plugin_form_messages",array('date'=>array('$lte'=>new MongoDate(strtotime($prev_day)))));
    $count_new_messages=NoiCore::app()->db()->count("plugin_form_messages",array('date'=>array('$gt'=>new MongoDate(strtotime($prev_day)))));

     if($count_new_messages>0 and $count_all_messages>0){
    $data['percent_messages']=$count_new_messages*100/$count_all_messages;
    $data['percent_messages']=(int)$data['percent_messages'];
    }
    return $this->render("index",$data);
 }

}

