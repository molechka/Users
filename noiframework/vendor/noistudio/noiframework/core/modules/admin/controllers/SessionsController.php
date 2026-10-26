<?php

namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use MongoDate;
use noicms\core\StrInput; 
use MongoId;
use app\models\Session;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
 class SessionsController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="sessions";
     if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }
     public function actionDelete($rowid){
      if(isset($rowid) and StrInput::is_Id($rowid)){
 $collection = Yii::$app->mongodb->getCollection("session");
        $options=array();


       $collection->remove(array('_id'=>new MongoId($rowid)));
      
          
      }
      $this->redirect(NoiCore::app()->getRoute('sessions/index'));
     }
     function actionIndex(){
      $site=NoiCore::app()->site_data;
     $sessions=  MGQuery::execute2(array(),"session",array('id'=>array('$ne'=>NoiCore::app()->getSessionId())));
     if(is_array($sessions) and count($sessions)>0){
     $count=count($sessions);
     $newcount=count($sessions);
     foreach($sessions as $key=>$value){
     $sessions[$key]['data']= Session::unserialize($value['data']);
     if(isset($sessions[$key]['data'][$site['_id']->__toString()."_noicore__admin_access"])) {

     }else {
     $newcount--;
     unset($sessions[$key]);
     }
     }
     if($newcount>0){
     $sessions=  array_values($sessions);

     }else {
     $sessions=array();
     }
     return $this->render("list",array('sessions'=>$sessions));
     }
     }
 }
