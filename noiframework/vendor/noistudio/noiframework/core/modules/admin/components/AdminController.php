<?php
namespace noicms\admin\components;
use yii\web\Controller;
use NoiCore;
use Yii;
use noicms\core\StrInput; 
use noicms\mongogrid\system_core\MGQuery;
use NoiCoreSet;
use yii\helpers\Url;
use MongoId;
use noicms\admin\components\AdminIdentify;
 class AdminController extends Controller
{
       public $enableCsrfValidation = false;
     public $breadcrumbs=array();

       public $layoutPath;

       public $login=false;
       public $path_theme="";
       public $admin_theme="";
	/**
	 * Declares class-based actions.
	 */
     public function init($login=false){
 
   Yii::setAlias('@webadmin', ADMIN_PATH);
    
   Yii::setAlias('@defaultadmin', PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/");
  $this->path_theme=ADMIN_PATH."".Yii::$app->params['admin_theme']."/page/component/";
  $this->admin_theme=Yii::$app->params['admin_theme'];
 if(AdminController::isLogin()==false and $login==false){
 
 return $this->redirect("/".Yii::$app->params['admin_folder']."/auth/login");
 }
$site=  MGQuery::execute(array(), "widget_user_sites", array());
//echo Yii::$app->session['admin_end_date'];
//exit;
if(AdminController::isLogin()==true){
  $admin_access=NoiCore::app()->getSession("admin_access");
   $admin_end_date=NoiCore::app()->getSession("admin_end_date");
  if(!isset($admin_access) or !isset($admin_end_date)){

 $this->redirect("/".Yii::$app->params['admin_folder']."/auth/login");
  }

  $current_time=time();
  if($admin_end_date!="unlimit"){
        
  if($current_time>$admin_end_date){
       NoiCore::app()->setSession("admin_access",0);
      NoiCore::app()->setSession("admin_end_date",0);
      NoiCore::app()->setSession("admin_auth",0);
       NoiCore::app()->setSession("admin_isroot",0);
       
      $this->redirect(AdminController::getAdminLink("auth/login"));
  }
  }
  if($this->isRoot()==false){
   $admin_id=NoiCore::app()->getSession("admin_id");
   if(StrInput::is_Id($admin_id)){
    $exists_admin=NoiCore::app()->db()->count("admins_users",array('_id'=>new MongoId($admin_id)));
    if($exists_admin==0){
    NoiCore::app()->setSession("admin_access",0);
      NoiCore::app()->setSession("admin_end_date",0);
      NoiCore::app()->setSession("admin_auth",0);
       NoiCore::app()->setSession("admin_isroot",0);
      $this->redirect(AdminController::getAdminLink("auth/login"));
    }
   }
  }else {
   $admin_password=NoiCore::app()->getSession("admin_password");
   if(isset($admin_password) and strlen($admin_password)>0){
      include DOCUMENT_ROOT."/conf/config.php";
      if(isset($config['admin_password'])){
       if($admin_password!=hash("sha512",$config['admin_password'])){
          NoiCore::app()->setSession("admin_access",0);
      NoiCore::app()->setSession("admin_end_date",0);
      NoiCore::app()->setSession("admin_auth",0);
       NoiCore::app()->setSession("admin_isroot",0);
      $this->redirect(AdminController::getAdminLink("auth/login"));   
       }
      }
   }
  }
}
if(isset($site[0])){
 NoiCoreSet::add($site[0]);
}
$current_url=Yii::$app->request->url;
$current_url=str_replace("/".Yii::$app->params['admin_folder'],"",$current_url);
//echo $current_url;
//exit;
      if(isset(Yii::$app->params['only_ip']) and strlen(Yii::$app->params['only_ip'])>0){
      $tmp_explode=explode(".",Yii::$app->params['only_ip']);
      if(count($tmp_explode)==4){
        if(isset($_SERVER['REMOTE_ADDR']) and $_SERVER['REMOTE_ADDR']==Yii::$app->params['only_ip']){
 
        }else {

          echo "denied request";
          exit;
        }

      }
      }

      // parent::init();
     }
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
 
	public function actionError()
	{

	    if($error=Yii::app()->errorHandler->error)
	    {

                if($error['code']=="404"){
                  echo "404 not found";
                  exit;
                }
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

  function render($view,$data=array(),$return=false){
 



          $controllername = Yii::$app->controller->id;
          $data['cur']=new AdminSetup;
          if(!isset($data['site'])){
          $data['site']=NoiCore::app()->site_data;
          }
         // $newPath = "application.modules.admin.views.{$controllername}.".$view;
          $newPath = PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/".$controllername."/".$view.".php";
          if(file_exists($this->path_theme."".$controllername."/".$view.".php")){
          $newPath=$this->path_theme."".$controllername."/".$view.".php";
          $view="@webadmin/".$this->admin_theme."/page/component/".$controllername."/".$view.".php";
          }else {

          $view="@defaultadmin/".$controllername."/".$view;
          }

           
         
         
if((isset($_GET['ajax']) and $_GET['ajax']==1) or $view=="editsite_bar"){
    parent::renderPartial($view, $data, $return);

}else {
 
 
 return parent::render($view,$data);
  
}
      
  }
  static function isMainPage(){
   $current_url=Yii::app()->getRequest()->getUrl() ;
$current_url=str_replace("/".Yii::$app->params['admin_folder'],"",$current_url);
if(strlen($current_url)==0){
   return true;
}else {
    if($current_url=="/"){
     return true;
    }
   return false;
}
  }
  static function isRoot(){
$admin_end_date=NoiCore::app()->getSession('admin_end_date');
   if(isset($admin_end_date) and $admin_end_date=="unlimit"){
     return true;
   }else {
     return false;
   }
  }
  static function isLogin(){
if(DB_TYPE=="mongodb"){
      $is_auth=NoiCore::app()->getSession("admin_auth");
       
 
      if(isset($is_auth) and $is_auth==1){
          return true;
      }else {
          return false;
      }
}
 

  }
  static function change_text($text){
  //$text=  str_replace("/widget", "", $text);
  return $text;
  }
  static function getAdminLink($str){
   return "/".Yii::$app->params['admin_folder']."/".$str;
  }
  public function redirect($url,$statusCode=302){
    //  return parent::redirect($url);
$result=\Yii::$app->getResponse()->redirect($url, 302)->send();
return $result;
 

 
  }
	/**
	 * Displays the contact page
	 */



}