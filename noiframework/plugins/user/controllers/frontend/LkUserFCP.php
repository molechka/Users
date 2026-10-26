<?php

class LkUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("user",$cur,$route);
if(!NoiCore::user()->isLogin()){
 exit;
}
    }
    public function actionIndex(){
    NoiCore::app()->setParam("curnav","profile");     
    $data=array();    
    $data['user']=NoiCore::user()->load();
    return $this->render("index",$data);    
    }
    
    public function actionStruct(){
    NoiCore::app()->setParam("curnav","struct");    
    $user=NoiCore::user()->load();
    $data=array();
    $data['user']=$user;
    $data['stats']=  \invest\models\StatsModel::getAllStats($user);
    $condition=array('referals_list.0'=>$user['login']);
    if((isset($_GET['skype']) and strlen($_GET['skype'])>0)
       or  (isset($_GET['login']) and strlen($_GET['login'])>0)
      or  (isset($_GET['phone']) and strlen($_GET['phone'])>0)   
     or  (isset($_GET['email']) and strlen($_GET['email'])>0)         
            ){
    $newcond=array('referals_list'=>$user['login']);
    $newcond['$or']=array();
    /*
     
     */
    if((isset($_GET['skype']) and strlen($_GET['skype'])>0)){
    $newcond['$or'][]=array('skype'=>array('$options'=>'i','$regex' => strip_tags($_GET['skype'])));
    
    }
    if(isset($_GET['login']) and strlen($_GET['login'])>0){
   $newcond['$or'][]=array('login'=>array('$options'=>'i','$regex' => strip_tags($_GET['login'])));
    
    }
    if(isset($_GET['phone']) and strlen($_GET['phone'])>0) {
    $newcond['$or'][]=array('phone'=>array('$options'=>'i','$regex' => strip_tags($_GET['phone'])));
    
    }
     if(isset($_GET['email']) and strlen($_GET['email'])>0) {
    $newcond['$or'][]=array('email'=>array('$options'=>'i','$regex' => strip_tags($_GET['email'])));
    
    }
    
    
    $condition=$newcond;
            }
    $data['rows']=NoiCore::app()->db()->query2(array(),"cms_users",$condition,array('_id'=>-1),10,NoiCore::c("ppaginator")->getOffset(10));
    $data['count']=NoiCore::app()->db()->count("cms_users",array('referals_list'=>$user['login']));
    $data['pages']=NoiCore::c("ppaginator")->show($data['count'],10);
    return $this->render("struct",$data);
    }
    public function actionReferals($last_id){
     $user=NoiCore::user()->load();     
    if(isset($last_id) and is_numeric($last_id)){
    $results=NoiCore::app()->db()->query(array(),"cms_users",array('last_id'=>(int)$last_id,'referals_list'=>$user['login']));
    if(isset($results[0]['_id'])){
    $whouser=$results[0];
    $time_start=strtotime(date("Y-m-d")." 00:00:00");     

$time_end=strtotime(date("Y-m-d")." 23:59:59");  
 
 $results_active=NoiCore::app()->db()->query2(array(),"cms_users",array('referal'=>$whouser['login']));
  $data=array();
  $data['user']=$whouser; 
  $data['results']=$results_active;
 echo $this->render("referals_list",$data);  
 
    }
    }
    
    exit;       
    }
    public function actionInfo($last_id){
    $user=NoiCore::user()->load();     
    if(isset($last_id) and is_numeric($last_id)){
    $results=NoiCore::app()->db()->query(array(),"cms_users",array('last_id'=>(int)$last_id,'referals_list'=>$user['login']));
    if(isset($results[0]['_id'])){
    $whouser=$results[0];
    $time_start=strtotime(date("Y-m-d")." 00:00:00");     

$time_end=strtotime(date("Y-m-d")." 23:59:59");  
 
 $results_active=NoiCore::app()->db()->query2(array(),"user_deposits",array('user._id'=>$whouser['_id'],'date_end'=>array('$gt'=>new MongoDate($time_start))),array('deposit.month'=>-1));
  $data=array();
  $data['user']=$whouser; 
  $data['results']=$results_active;
 echo $this->render("info",$data);  
 
    }
    }
    
    exit;         
    }
    public function actionRequests(){
    NoiCore::app()->setParam("curnav","requests");      
    $user=NoiCore::user()->load();
    $data=array();
    $condition=array('user._id'=>$user['_id']);
    if(isset($_GET['inarchive'])){
    $condition['inarchive']=1;    
    }else {
    $condition['inarchive']=array('$ne'=>1);    
    }
    $data['user']=$user;
    $data['rows']=NoiCore::app()->db()->query(array(),"widthdrawals_request",$condition,array('_id'=>-1),10,NoiCore::c("ppaginator")->getOffset(10));
    $data['count']=NoiCore::app()->db()->count("widthdrawals_request",$condition);
    $data['pages']=NoiCore::c("ppaginator")->show($data['count'],10);
    return $this->render("requests",$data);
    }
    public function actionFinance(){
    NoiCore::app()->setParam("curnav","finance");       
    $data=array();
    if(isset($_POST['type']) and isset($_POST['money']) and is_numeric($_POST['money'])){
    NoiCore::app()->redirect("/pay/start/".strtolower($_POST['type'])."?money=".$_POST['money']);
    exit;    
    }
    \user\models\MoneyTransfer::doSend();
    $data['user']=NoiCore::user()->load();
    $data['bank_accounts']=NoiCore::app()->db()->query2(array(),"bank_accounts",array('user._id'=>$data['user']['_id']));
    
    return $this->render("finance",$data);
    
    }
     
    
}