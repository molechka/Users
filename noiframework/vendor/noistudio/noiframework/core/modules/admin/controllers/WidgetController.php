<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
class WidgetController extends AdminController {

    public function init($login=false){
Yii::$app->params['current_page']="widget";
     parent::init($login);
    }
    public function actionGet($plugin){
   if(isset($plugin) and NoiCore::c("plugins")->isInstall($plugin)){
  echo NoiCore::c("widgets")->getAvailables($plugin);
   }
   exit;
    }
    public function actionAll(){
    Yii::$app->params['current_page']="wi_all";
    $data=array();
     $data['site']=NoiCore::app()->site_data;
     $data['plugins']=NoiCore::c("plugins")->getInstalledPlugins();
     $data['positions']=NoiCore::c("widgets")->getPositions();
     $data['widgets']=NoiCore::c("widgets")->getWidgets();
   if(isset($_POST['act_add_widget'])){
    NoiCore::c("widgets")->addWidget();
    NoiCore::app()->redirect(NoiCore::app()->getRoute('wi/all'));
       
   }
   if(isset($_GET['op'])){
   NoiCore::c("widgets")->opWidget();
   NoiCore::app()->redirect(NoiCore::app()->getRoute('wi/all'));
   }


//     if(isset( Yii::$app->params['data_page'])){
//     $data['render']= Yii::$app->params['data_page'];
//     }
     //SiteComponent::render_setup("render",$data,1);
return     $this->render("widgets_list",$data);
    }
    public function actionPositions(){
   Yii::$app->params['current_page']="wi_positions";
    $data=array();
    $data['render']=NoiCore::c("widgets")->doManagePositions();


//     if(isset( Yii::$app->params['data_page'])){
//     $data['render']= Yii::$app->params['data_page'];
//     }
     //SiteComponent::render_setup("render",$data,1);
 return    $this->render("render",$data);
    }
    public function actionRun($position,$number){
   if(isset($position) and isset($number) and is_numeric($number)){
$data['render']=NoiCore::c("widgets")->run($position,$number);

//     if(isset( Yii::$app->params['data_page'])){
//     $data['render']= Yii::$app->params['data_page'];
//     }
     //SiteComponent::render_setup("render",$data,1);
 return    $this->render("render",$data);
   }
    }

}

