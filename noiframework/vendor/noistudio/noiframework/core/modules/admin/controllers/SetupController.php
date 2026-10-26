<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
 
 
 class SetupController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="setup";
       if(AdminController::isRoot()==false){
     return $this->redirect(AdminController::getAdminLink("index"));
     }
  }
  public function actionReplacecss(){
     if(isset($_GET['css'])){
     if(file_exists(DOCUMENT_ROOT."".$_GET['css'])){
       $result_css=file_get_contents(DOCUMENT_ROOT."".$_GET['css']);
       $result_css=str_replace("display:none","",$result_css);
       $tmp_css=str_replace("display:none","",$result_css);
       echo $result_css;
       
     }
     }
     exit;
  }
     function getThemes(){
      $maindir=scandir(DOCUMENT_ROOT.THEMES_PATH);
      $array_types=array();
      $result_array=array();
      if(isset($maindir) and count($maindir)>0){
      foreach($maindir as $dir){
      if($dir!="." and $dir!=".." and is_dir(DOCUMENT_ROOT.THEMES_PATH."".$dir) ){
      $array_types[]=$dir;

      if(file_exists(DOCUMENT_ROOT.THEMES_PATH."".$dir."/page/main.php")){
     $result_array[]="/".$dir;
      }
      }
      }
      }
     if(count($array_types)>0){
     foreach($array_types as $type){
      $typedir=scandir(DOCUMENT_ROOT.THEMES_PATH."".$type."/");
      if(isset($typedir) and count($typedir)>0){
      foreach($typedir as $d){
       $tmp_replace=str_replace(".php","",$d);
       if($d!="." and $d!=".." and $tmp_replace==$d){
       if(file_exists(DOCUMENT_ROOT.THEMES_PATH."".$type."/".$d."/page/main.php")){
        $result_array[]=$type."/".$d;
       }
       }
      }
      }
     }
     }
return $result_array;
     }
     function actionAjroute(){
       $site=  MGQuery::execute(array(),'widget_user_sites',array());

       if(isset($site[0]['_id'])){
         if(!isset($site[0]['route'])  or !is_array($site[0]['route'])){
         $site[0]['route']=array();
         }

         if(isset($site[0]['route']) and is_array($site[0]['route'])){
         if(isset($_POST['normal']) and isset($_POST['seo'])){
         $exist_key=false;
         $exist_value=false;
         $found_key=0;
         if(count($site[0]['route'])>0){
          foreach($site[0]['route'] as $key=>$rt){
          if(isset($rt['normal']) and $rt['normal']==$_POST['normal']){
          $exist_key=true;
          $found_key=$key;
          }else {
           if(isset($rt['seo']) and $rt['seo']==$_POST['seo']){
            $exist_value=true;
           }
          }

          }
         }
         if($exist_value==false){
         $array_update=array();
         $array_update['route']=$site[0]['route'];
         if($exist_key==true){
         $array_update['route'][$found_key]['seo']=$_POST['seo'];
         }else {
          $array_update['route'][]=array('seo'=>$_POST['seo'],"normal"=>$_POST['normal']);
         }
   MGQuery::update($array_update, 'widget_user_sites', array("_id"=>new \MongoId($site[0]['_id']->__toString())));
         }
         }
         }
       }
       exit;
     }
     function actionRoute(){
       Yii::$app->params['current_page']="route";
       $site=  MGQuery::execute(array(),'widget_user_sites',array());

       if(isset($site[0]['_id'])){
      
        if(isset($site[0]['route']) and is_array($site[0]['route'])){
        $route=$site[0]['route'];
        }else {
        $route=array();
        }
     if(isset($_GET['delete']) and isset($route[$_GET['delete']])){
      $count_route=count($route);
      if($count_route>1){
       unset($route[$_GET['delete']]);
       $route=  array_values($route);
      }else {
        $route=array();
      }
   $array_update=array();
   $array_update['route']=$route;
    MGQuery::update($array_update, 'widget_user_sites', array("_id"=>new \MongoId($site[0]['_id']->__toString())));
    Yii::$app->controller->redirect(AdminController::getAdminLink('route'));
     }
 if(isset($_POST['seo_url']) and isset($_POST['normal_url'])){
   $route[]=array('seo'=>$_POST['seo_url'],'normal'=>$_POST['normal_url']);
   $array_update=array();
   $array_update['route']=$route;
    MGQuery::update($array_update, 'widget_user_sites', array("_id"=>new \MongoId($site[0]['_id']->__toString())));
       }
        return $this->render("route_setup",array('route'=>$route));
       }
     }
     function actionLoad(){
       $results=NoiCore::app()->db()->query(array(),'stats_load',array(),array('mb'=>-1));
       echo json_encode($results);
       exit;
     }
     function actionIndex(){
         Yii::$app->params['current_page']="setup";
        $op=0;
         $site=  MGQuery::execute(array(),'widget_user_sites',array('_id'=>NoiCore::app()->site_data['_id']));
           $array_themes=$this->getThemes();
       $current_theme="";
       if(isset($site[0]['type_site']) and isset($site[0]['theme_site'])){
       $current_theme=$site[0]['type_site']."/".$site[0]['theme_site'];
       }
       
         if(isset($site[0]['_id'])){
         $data['site']=$site[0];
         if(isset($_POST['act_save'])){
         $array_update=array();
         if(isset($_POST['title'])){
         $array_update['title']=$_POST['title'];
         }
         if(isset($_POST['title_mainpage'])){
         $array_update['title_mainpage']=$_POST['title_mainpage'];
         }
         if(isset($_POST['keywords'])){
         $array_update['keywords']=$_POST['keywords'];
         }
         if(isset($_POST['description'])){
         $array_update['description']=$_POST['description'];
         }
           $list_languages=NoiCore::app()->getListLanguges();
        if(count($list_languages)>0){
        foreach($list_languages as $lang){
           if(isset($_POST['title_'.$lang])){
         $array_update['title_'.$lang]=$_POST['title_'.$lang];
         }
         if(isset($_POST['title_mainpage_'.$lang])){
         $array_update['title_mainpage_'.$lang]=$_POST['title_mainpage_'.$lang];
         }
         if(isset($_POST['keywords_'.$lang])){
         $array_update['keywords_'.$lang]=$_POST['keywords_'.$lang];
         }
         if(isset($_POST['description_'.$lang])){
         $array_update['description_'.$lang]=$_POST['description_'.$lang];
         }    
        }       
        }
         if(isset($_POST['tag_widget_disable'])){
         $array_update['tag_widget_disable']=(int)$_POST['tag_widget_disable'];
         }
            if(isset($_POST['tag_short_disable'])){
         $array_update['tag_short_disable']=(int)$_POST['tag_short_disable'];
         }
         if(isset($_POST['load_from_db'])){
         $array_update['load_from_db']=(int)$_POST['load_from_db'];
         }
         if(isset($_POST['multilanguage'])){
         $array_update['multilanguage']=(int)$_POST['multilanguage'];
         }
         if(isset($_POST['type_email']) and ($_POST['type_email']=="sendmail") or $_POST['type_email']=="smtp"){
         $array_update['email_conf']=array();
         if(isset($site[0]['email_conf']) and is_array($site[0]['email_conf'])){
         $array_update['email_conf']=$site[0]['email_conf'];
         }
         $array_update['email_conf']['type']=$_POST['type_email'];
         if(isset($_POST['smtp_host'])){
         $array_update['email_conf']['host']=strip_tags($_POST['smtp_host']);
         }
           if(isset($_POST['smtp_login'])){
         $array_update['email_conf']['login']=strip_tags($_POST['smtp_login']);
         }
           if(isset($_POST['smtp_password'])){
         $array_update['email_conf']['password']=strip_tags($_POST['smtp_password']);
         }

         }
         if(isset($_POST['current_theme'])){
         $array_explode=explode("/",$_POST['current_theme']);
         if(isset($array_explode[0]) and isset($array_explode[1])){
             if(file_exists(DOCUMENT_ROOT.THEMES_PATH."".$array_explode[0]."/".$array_explode[1]."/page/main.php")){
              $array_update['type_site']=$array_explode[0];
              $array_update['theme_site']=$array_explode[1];
             }
         }

         }
         if(count($array_update)>0){
             $op=1;
           
             MGQuery::update($array_update, 'widget_user_sites', array("_id"=>new \MongoId($data['site']['_id']->__toString())));

              $site=  MGQuery::execute(array(),'widget_user_sites',array('_id'=>new \MongoId($data['site']['_id']->__toString())));
              
              $data['site']=$site[0];
              $this->installDemo($site[0]);
                 if(isset($site[0]['type_site']) and isset($site[0]['theme_site'])){
       $current_theme=$site[0]['type_site']."/".$site[0]['theme_site'];
       }
         }
         }
         $data['themes']=$array_themes;
         $data['current_theme']=$current_theme;
         $data['op']=$op;
         
    return     $this->render("index",$data);
         }
     }
     public function installDemo($site_array){
 if(!isset($site_array['theme_components']['widgets']['position'])){
 $site_array['theme_components']['widgets']['position']=array();
 }
 $total_count=0;
 if(count($site_array['theme_components']['widgets']['position'])>0){
  foreach($site_array['theme_components']['widgets']['position'] as $pos){
 $total_count+=count($pos);
  }
 }


// if($total_count==0){
//     $demo_install=new InstallDemo($site_array);
//     $array_update=$demo_install->installWidgets();
//     MGQuery::update($array_update, 'widget_user_sites', array("_id"=>new \MongoId($site_array['_id']->__toString())));
// }


     }
 }

