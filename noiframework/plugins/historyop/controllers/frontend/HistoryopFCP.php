<?php

class HistoryopFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("historyop",$cur,$route);
        NoiCore::app()->setParam("current_page","history");
        NoiCore::app()->setSession("type_site","lk");
         NoiCore::app()->setParam("type","history");

    }
function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}
    public function actionIndex(){
     if(isset($_POST['money'])  and is_numeric($_POST['money']) and $_POST['money']>0 and $_POST['money']>0){
   NoiCore::app()->redirect("/pay/start/payeer?money=".$_POST['money'],0);
    }  
     $this->setTitle(NoiCore::lang()->t('user_finance'));     
      $user=NoiCore::user()->load();  
    if($this->user()->isLogin()){
    $value=$this->get_value();
$value[0]['collection']="historyop_collection";
    if(isset($value[0]['collection']) and isset($value[0]['field_id_user'])){
  $condition=array('user._id'=>$user['_id']);
 
//    if(isset($_GET['filter'])){
//    $condition['pop']=(int)$_GET['filter'];
//    }
    
  
    if(isset($_GET['start'])  and isset($_GET['end']) and strlen($_GET['start'])>1 and strlen($_GET['end'])>0){
      
    $start_time=strtotime($_GET['start']);
    $end_time=  strtotime($_GET['end']);
    $condition['date']=array('$gte'=>new MongoDate($start_time),'$lte'=>new MongoDate($end_time));
    }
    if(isset($_GET['type']) and is_string($_GET['type']) and $_GET['type']!="all"){
     if($_GET['type']!="none"){ 
    $condition['data.'.$_GET['type']]=1;    
    }
    }
     
     
 
    $result=$this->db()->query(array(),$value[0]['collection'],$condition,array('_id'=>-1),10,NoiCore::c("ppaginator")->getOffset(10));
    $count_all=$this->db()->count($value[0]['collection'],$condition);
    $total=  historyop\models\Finance::getItogo2($condition);
    
    $pages=NoiCore::c("ppaginator")->show($count_all,10);
      
    return $this->render("show_history",array('itogo'=>$total,'user'=>$user,'count'=>$count_all,'history'=>$result,'pages'=>$pages));
    }

    }
    }

}
