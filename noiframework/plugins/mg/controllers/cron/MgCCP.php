<?php
 
class UserCCP extends CoreCronControllerPlugin{

 public function __construct($site) {
     parent::__construct('user',$site);
 }
 public function actionIndex(){
 $results_users=NoiCore::app()->db()->query2(array(),"cms_users",array('user_active'=>0));
 if(count($results_users)>0){
 $time=time();   
  
 foreach($results_users as $us){
 
 
 $end_date= strtotime('+1 month',$us['date_register']->sec);
 
 $time_start=$us['date_register']->sec;
 if($time>$end_date ){
 $array_update=array();
 $array_update['enable_account']=0;
 NoiCore::app()->db()->update($array_update,"cms_users",array('_id'=>$us['_id']));
 }
 
 }    
 }
 
 }

}

?>