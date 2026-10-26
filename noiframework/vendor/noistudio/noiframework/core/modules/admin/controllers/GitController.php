<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
 
 
 class GitController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="git";
       if(AdminController::isRoot()==false){
     return $this->redirect(AdminController::getAdminLink("index"));
     }
  }
  public function actionIndex(){
   return $this->render("index");   
  }
  public function actionPush(){
       
     require PATH_TO_ENGINE."/extensions/Git.php";
     if(isset($_POST['repo'])){
     $repo = \Git::open($_SERVER['DOCUMENT_ROOT']);
     $repo->seturl($_POST['repo']);
     $repo->who("noreply@noibiz.com", "noibot");
     $repo->add('.');
     $repo->commit('Авто push из админки ');
     $repo->push('origin', 'master');
     NoiCore::app()->setNotify("Git Push успешно выполнен");
     }
     
    
    
    NoiCore::app()->returnback();
     exit;
      
  }
    
 }

