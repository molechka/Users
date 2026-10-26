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
 class SitesController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="sites";
    if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }
  public function actionDelete($siteid){
      NoiCore::admin()->setDisableConditionDb();
      if(isset($siteid) and StrInput::is_Id($siteid)){
      NoiCore::app()->db()->delete("widget_user_sites",array('_id'=>new MongoId($siteid),"subroute"=>array('$ne'=>"*")));
      $this->redirect(NoiCore::app()->getRoute('sites/index'));
      }
  }
   public function actionUpdate($siteid){
          NoiCore::admin()->setDisableConditionDb();
      if(isset($siteid) and StrInput::is_Id($siteid)){
      $sites=NoiCore::app()->db()->query(array(),"widget_user_sites",array('_id'=>new MongoId($siteid)));
      if(isset($sites[0]['_id'])){
      if(isset($_POST['domain'])  and $this->is_valid_domain_name($_POST['domain'])){
        $new_insert=array();

        $new_insert['subroute']=$_POST['domain'];
        NoiCore::app()->db()->update($new_insert,"widget_user_sites",array('_id'=>new MongoId($siteid)));
        $this->redirect(NoiCore::app()->getRoute('sites/index'));
      }
   
      return $this->render("copy_update",array('site_update'=>$sites[0]));
      }

      }
  }
  public function actionCopy($siteid){
          NoiCore::admin()->setDisableConditionDb();
      if(isset($siteid) and StrInput::is_Id($siteid)){
      $sites=NoiCore::app()->db()->query(array(),"widget_user_sites",array('_id'=>new MongoId($siteid)));
      if(isset($sites[0]['_id'])){
      if(isset($_POST['domain']) and $this->is_valid_domain_name($_POST['domain'])){
        $new_insert=array();
        $new_insert=$sites[0];
        $new_insert['_id']=new MongoId();
        $new_insert['subroute']=$_POST['domain'];
        NoiCore::app()->db()->insert($new_insert,"widget_user_sites");
        $this->redirect(NoiCore::app()->getRoute('sites/index'));
      }
      return $this->render("copy",array('site'=>$sites[0]));
      }

      }
  }
  function is_valid_domain_name($domain_name)
{
    return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
}
  public function actionIndex(){
       NoiCore::admin()->setDisableConditionDb();
   $count=NoiCore::app()->db()->count("widget_user_sites",array());
   if($count==1){
   $array_update=array();
   $array_update['subroute']="*";
   NoiCore::app()->db()->update($array_update,"widget_user_sites",array());
   }
   include(DOCUMENT_ROOT."/conf/config.php");

if(isset($config_admin['admin_folder'])){
   $sites=NoiCore::app()->db()->query2(array(),"widget_user_sites",array());
 
      return $this->render("list",array('admin_folder'=>$config_admin['admin_folder'],'sites'=>$sites));
}
  }

 }

