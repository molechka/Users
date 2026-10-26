<?php

namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use MongoId;
use noicms\core\StrInput; 
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
 class TrashController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="trash";
    if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }
  public function actionIndex(){
      NoiCore::admin()->setDisableConditionDb();
      $offset=NoiCore::c("ppaginator")->getOffset(10);
      $trash=  MGQuery::execute(array(), 'trash_collection',array(),array('_id'=>-1),10,$offset);
     $count=  MGQuery::count('trash_collection',array());
 
  return  $this->render("list",array('count'=>$count,'trash'=>$trash,'paginator'=>NoiCore::c("ppaginator")->show($count,10,NoiCore::app()->getRoute('trash/index'))));

  }
  public function actionDelete($rowid){
     NoiCore::admin()->setDisableConditionDb();
  if(isset($rowid)){
  if(StrInput::is_Id($rowid)){
   MGQuery::delete('trash_collection', array('_id'=>new MongoId($rowid)));
  }else if($rowid=="all"){

      MGQuery::delete('trash_collection', array());
  }
  }
  return $this->redirect(NoiCore::app()->getRoute('trash/index'));

  }
  public function actionRestore($rowid){
        NoiCore::admin()->setDisableConditionDb();
  if(isset($rowid) and StrInput::is_Id($rowid)){
   $result=  MGQuery::execute(array(), 'trash_collection',array('_id'=>new MongoId($rowid)));
  if(isset($result[0]['_id'])){
    $new_array=$result[0]['row'];
    $_GET['install']="install";
    MGQuery::insert($new_array,$result[0]['collection']);
    unset($_GET['install']);
    MGQuery::delete('trash_collection',array('_id'=>new MongoId($rowid)) );

  }

  }
   return $this->redirect(NoiCore::app()->getRoute('trash/index'));
  }



 }

