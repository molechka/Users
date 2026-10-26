<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use MongoDate;
use noicms\core\StrInput; 
use MongoId;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
 class AdminsController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="admins";
     if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }

     function actionIndex(){
     if(isset($_GET['delete']) and StrInput::is_Id($_GET['delete'])){
         MGQuery::delete('admins_users', array('_id'=>new MongoId($_GET['delete'])));
          Yii::$app->controller->redirect(AdminsController::getAdminLink('admins'));
     }
   $admins=  MGQuery::execute2(array(), 'admins_users');
 return  $this->render("index",array('admins'=>$admins));
     }
     public function actionAdd(){

       if(isset($_POST['btn_add'])){
     if(isset($_POST['admin_login']) and strlen($_POST['admin_login'])>3){
    $admins=array();
 
    $admins['admin_login']=$_POST['admin_login'];
    if(isset($_POST['admin_password']) and strlen($_POST['admin_password'])>2){
          
    $admins['admin_password']=hash("sha512",$_POST['admin_password']);
    if(isset($_POST['admin_date'])){
   $time=  strtotime($_POST['admin_date']);
   $admins['end_date']=new MongoDate($time);
   $access=array();
   if(isset($_POST['admin_access_all']) and $_POST['admin_access_all']==1){
   $access[]="all";
   }
      if(isset($_POST['admin_access_widget']) and $_POST['admin_access_widget']==1){
   $access[]="widget";
   }
   if(isset($_POST['admin_access_plugins']) and $_POST['admin_access_plugins']==1){
   $access[]="plugins";
   }
$admins['access']=$access;
$condition2=array();
$condition2["admin_login"]=array('$options'=>'i','$regex' => $admins['admin_login']);
$count_exists=  MGQuery::count("admins_users", $condition2);

if(isset($count_exists) and $count_exists==0){
    NoiCore::app()->db()->insert($admins, "admins_users");
}
    }
    }
     }

       }
 Yii::$app->controller->redirect(AdminsController::getAdminLink('admins'));
     }

 }
