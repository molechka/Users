<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
class PluginController extends AdminController {

    public function init($login=false){
Yii::$app->params['current_page']="plugin";
     parent::init($login);
    }
    public function actionGet($plugin){
     if(isset($plugin) and NoiCore::c("plugins")->isInstall($plugin)){
        
         echo NoiCore::c("plugins")->getLinks($plugin);
     }
     exit;
    }
    public function actionAll(){
   Yii::$app->params['current_page']="plugins";
  if(isset($_POST['name_install_plugin'])){
 NoiCore::c("plugins")->installNewPlugin($_POST['name_install_plugin']);
   $this->redirect(NoiCore::app()->getRoute("plugins"));
}
if(isset($_GET['delete_plugin'])){
  NoiCore::c("plugins")->deletePlugin($_GET['delete_plugin']);
  $this->redirect(NoiCore::app()->getRoute("plugins"));
}
   $data=array();
   $data['plugins']=NoiCore::c("plugins")->getInstalledPlugins();
   $data['new']=NoiCore::c("plugins")->getNewPlugins();


//     if(isset( Yii::$app->params['data_page'])){
//     $data['render']= Yii::$app->params['data_page'];
//     }
     //SiteComponent::render_setup("render",$data,1);
 return    $this->render("list_plugins",$data);
    }
    public function actionManage($plugin,$route="config"){
 if(isset($_SERVER['QUERY_STRING'])){
 $tmp_str=explode("p_".$plugin."/",$_SERVER['QUERY_STRING']);
 if(isset($tmp_str[1]) and strlen($tmp_str[1])>2){
$route=$tmp_str[1];
 }
 }

  $route_new=explode("?",$route);

            if(isset($route_new[0])){
             $route=$route_new[0];
              $route_new=explode("&",$route);
                 if(isset($route_new[0])){
                    $route=$route_new[0];
                 }

            }
            
   Yii::$app->params['current_page']="p_".$plugin ;
 
// $result_site=  NoiCore::app()->site_data;
// $widget=new AdminRender;
//  $_GET['page']=$route;
// $_GET['plugin_selected']=$plugin;
//
//  $setup=new SetupSite(array('component'=>"plugins",'value'=>$result_site['_id']->__toString(),'site'=>$result_site), $widget);
     $data['render']=NoiCore::c('plugins')->run($plugin,$route);
 
 
//     if(isset( Yii::$app->params['data_page'])){
//     $data['render']= Yii::$app->params['data_page'];
//     }
     //SiteComponent::render_setup("render",$data,1);
  return   $this->render("render",$data);
    }
   
}
?>