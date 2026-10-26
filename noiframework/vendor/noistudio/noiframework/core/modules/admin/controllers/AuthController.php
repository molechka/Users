<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use MongoDate;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminIdentify;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
class AuthController extends AdminController{
  public function init($login=true){
   
     parent::init($login);
  
    
  }
       public function actionLogin(){

if(isset($_POST['username']) and isset($_POST['password'])){

 include DOCUMENT_ROOT."/conf/config.php";
 
 if(isset($config['admin_username']) and $config['admin_username']==$_POST['username'] &&
      isset($config['admin_password']) and $config['admin_password']==$_POST['password'] ){
    
     $identify= new AdminIdentify();
    
     

      NoiCore::app()->setSession("admin_access",array('all'));
      NoiCore::app()->setSession("admin_end_date","unlimit");
      NoiCore::app()->setSession("admin_password",hash("sha512",$_POST['password']));
      NoiCore::app()->setSession("admin_auth",1);
       NoiCore::app()->setSession("admin_isroot",1);
     $identify->result=array('_id'=>$config['user_id'],"username"=>$config['admin_username']);
 ///    Yii::$app->user->login($identify, 3600*24*30);

 
     $this->redirect(AdminController::getAdminLink('index'));
 }else {
  if(isset($_POST['username']) and isset($_POST['password'])){
  NoiCore::notify()->set("Incorrect login or password");    
  
  }   
 }
}
if(isset($_POST['username']) and isset($_POST['password'])){
  
    $condition=array();
    $condition['admin_login']=$_POST['username'];
    $condition['admin_password']=hash("sha512",$_POST['password']);
    $condition['end_date']=array('$gt'=>new MongoDate(time()));

    //$count=  MGQuery::count('admins_users', $condition);
    $result_user=  MGQuery::execute(array(), "admins_users",$condition);
    if(isset($result_user[0]['_id'])){
     NoiCore::app()->setSession("admin_access",$result_user[0]['access']);
     NoiCore::app()->setSession("admin_end_date",$result_user[0]['end_date']->sec);



      NoiCore::app()->setSession("admin_id",$result_user[0]['_id']->__toString());
      NoiCore::app()->setSession("admin_auth",1);
       NoiCore::app()->setSession("admin_isroot",0);
     $this->redirect(AdminController::getAdminLink('index'));
    }
}
 
  return $this->render("login.php",array());

    }
    public function actionLogout(){

          NoiCore::app()->setSession("admin_access",0);
      NoiCore::app()->setSession("admin_end_date",0);
      NoiCore::app()->setSession("admin_auth",0);
       NoiCore::app()->setSession("admin_isroot",0);
      $this->redirect(AdminController::getAdminLink("auth/login"));
    }
}

