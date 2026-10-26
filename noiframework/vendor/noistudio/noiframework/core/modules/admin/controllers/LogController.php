<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
 class LogController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="logs";
    if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }

     function actionIndex(){
      $offset=0;
   if(isset($_GET['page_mg'])){
        if($_GET['page_mg']>0){
        $_GET['page_mg']=(int)$_GET['page_mg']+1;

        }

        $_GET['page']=$_GET['page_mg'];

       }
             if(isset($_GET['page'])){
                  $tmp_page=(int)$_GET['page'];
                  if($tmp_page>0){
                  $tmp_page--;
                  $tmp_page=10*$tmp_page;
                   $offset=(int)$tmp_page;
                  }


                 }
    $logs=  MGQuery::execute(array(), 'noicms_log',array(),array('_id'=>-1),10,$offset);
    $count=  MGQuery::count('noicms_log',array());
  return  $this->render("index",array('count'=>$count,'logs'=>$logs));
     }
 }

