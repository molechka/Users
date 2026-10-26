<?php

namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
 class MobileController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="mobile";
    if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }

     function actionIndex(){
         
     $site_data=NoiCore::app()->get();
     $array_update_mobile=array();
     if(isset($_POST['status']) and ($_POST['status']==1 or $_POST['status']==0)){
     $array_update_mobile=array('status'=>(int)$_POST['status']);
     }
     if(isset($_POST['secret_phras'])){
     $array_update_mobile['secret_phras']=$_POST['secret_phras'];
     }
    
     if(count($array_update_mobile)>0){
     $array_update=array('mobile'=>$array_update_mobile);
     NoiCore::app()->db()->update($array_update,"widget_user_sites",array('_id'=>$site_data['_id']));
     }

     $site=  MGQuery::execute(array(),'widget_user_sites',array('_id'=>$site_data['_id']));

     if(isset($site[0]['_id'])){
     $site_data=$site[0];
     }
     $mobile=array();
     if(isset($site_data['mobile'])){
     $mobile=$site_data['mobile'];
     }
     return $this->render("index",array('mobile'=>$mobile));
     }
     public function actionLogs(){
        $logs=  NoiCore::app()->db()->query(array(), 'used_openkey',array(),array('_id'=>-1),10,NoiCore::c("ppaginator")->getOffset(10,"page"));
    $count=  NoiCore::app()->db()->count('used_openkey',array());
  return  $this->render("list",array('pages'=>NoiCore::c("ppaginator")->show($count,10,NoiCore::app()->getRoute('mobile/logs'),"page"),'count'=>$count,'logs'=>$logs));
     }

 }
