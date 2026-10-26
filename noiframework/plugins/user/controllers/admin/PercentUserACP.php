<?php

class PercentUserACP  extends CoreAdminControllerPlugin{
 public $name_collection="user_sites_users";
 public function __construct($site) {
     parent::__construct('user',$site);
 }
 public function actionIndex(){
       $date=date('Y-m-d');
      $prev_day=date('Y-m-d 23:59', strtotime('-1 day', strtotime($date)));
      $next_day=date('Y-m-d', strtotime('+1 day', strtotime($date)));
      $data=array();
      $data['percent_new_users']=0;
      $data['percent_blocked']=0;
      $count_all_users=NoiCore::app()->db()->count("cms_users",array('blocked'=>array('$ne'=>1),'date_register'=>array('$lte'=>new MongoDate(strtotime($prev_day)))));
     $count_new_users=NoiCore::app()->db()->count("cms_users",array('blocked'=>array('$ne'=>1),'date_register'=>array('$gt'=>new MongoDate(strtotime($prev_day)))));
    if($count_new_users>0 and $count_all_users>0){
    $data['percent_new_users']=$count_new_users*100/$count_all_users;
    $data['percent_new_users']=(int)$data['percent_new_users'];
    }
    return $this->render("index",$data);
 }

}
