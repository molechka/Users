<?php
namespace noicms\admin\controllers;
use Yii;
use MongoDate;
use noicms\admin\components\AdminController;
use noicms\mongogrid\system_core\MGQuery;
use NoiCore;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
class DefaultController extends AdminController {

    public function init($login=false){
 
     parent::init($login);

    }
    public function actionIndex(){
      $site=  MGQuery::execute(array(),'widget_user_sites',array());
      if(isset($site[0]['_id'])){
     Yii::$app->params['current_page']="default";
      $data=array('site'=>$site[0]);
   
    $data['count_items']=NoiCore::app()->db()->count("user_shop",array());
    $data['count_pages']=NoiCore::app()->db()->count("user_content",array());
    $data['count_orders']=NoiCore::app()->db()->count("user_shop_orders",array());
   
    
  
   return $this->render("index",$data);
      }
    }
    function getStats($date){
    $stats_results=NoiCore::app()->db()->query2(array(),"stats_plugin",array('date'=>$date));
    if(isset($stats_results[0]['_id'])){
       return $stats_results[0];
    }else {
        return null;
    }
    }
    public function actionAbout(){
   
   Yii::$app->params['current_page']="about";
  return  $this->render("about");
    }
}
?>