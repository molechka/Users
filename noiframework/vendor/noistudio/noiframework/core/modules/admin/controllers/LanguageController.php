<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use MongoId;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
class LanguageController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="language";
    if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }
  public function actionIndex(){
    $list_language=NoiCore::app()->getListLanguges();
 
  $site_data=NoiCore::app()->site_data;
  if(is_array($list_language) and isset($list_language)>0){
  return $this->render("manage",array("langs"=>$list_language,'language_data'=>$site_data));
  }
  }
  public function doUpdate($key){
  $list_language=NoiCore::app()->getListLanguges();
  if(isset($list_language) and count($list_language)>0){
      $array_language=array();
       $site_data=NoiCore::app()->site_data;
   foreach($list_language as $lang){
   if(!isset($_POST['enable_'.$lang])){
 $this->redirect(NoiCore::app()->getRoute('language/update/'.$key));
 
}
 
if($_POST['enable_'.$lang]!="html" and $_POST['enable_'.$lang]!="string"){
$this->redirect(NoiCore::app()->getRoute('language/update/'.$key));    
}
if($_POST['enable_'.$lang]=='html' and !isset($_POST['html_value_'.$lang])){
 $this->redirect(NoiCore::app()->getRoute('language/update/'.$key));   
}
if($_POST['enable_'.$lang]=='string' and !isset($_POST['string_value'])){
 $this->redirect(NoiCore::app()->getRoute('language/update/'.$key));   
}


  if(!isset($site_data['language_'.$lang])){
  $array_language['language_'.$lang]=array();    
  }else {
  $array_language['language_'.$lang]=$site_data['language_'.$lang];    
  }
   
if($_POST['enable_'.$lang]=="html"){
  $array_language['language_'.$lang][$key]=$_POST['html_value_'.$lang];
  
  
}else if($_POST['enable_'.$lang]=="string"){
$array_language['language_'.$lang][$key]=$_POST['string_value_'.$lang];    
}    
   }   
  }
if(count($array_language)>0){
MGQuery::update($array_language, 'widget_user_sites', array("_id"=>new \MongoId($site_data['_id']->__toString())));
$this->redirect(NoiCore::app()->getRoute('language/index'));  
}

}
public function doAdd(){
 $list_language=NoiCore::app()->getListLanguges();
 $array_language=array();
 $site_data=NoiCore::app()->site_data;
 if(isset($list_language) and count($list_language)>0){
 foreach($list_language as $lang){    
 if(!isset($_POST['enable_'.$lang])){
 $this->redirect(NoiCore::app()->getRoute('language/add/'));
 
}
if(!isset($_POST['index_phrase']) or strlen($_POST['index_phrase'])<3){
$this->redirect(NoiCore::app()->getRoute('language/add/'));      
}
if($_POST['enable_'.$lang]!="html" and $_POST['enable_'.$lang]!="string"){
$this->redirect(NoiCore::app()->getRoute('language/add/'));    
}
if($_POST['enable_'.$lang]=='html' and !isset($_POST['html_value_'.$lang])){
 $this->redirect(NoiCore::app()->getRoute('language/add/'));   
}
if($_POST['enable_'.$lang]=='string' and !isset($_POST['string_value_'.$lang])){
 $this->redirect(NoiCore::app()->getRoute('language/add/'.$lang));   
}

  if(!isset($site_data['language_'.$lang])){
  $array_language['language_'.$lang]=array();    
  }else {
  $array_language['language_'.$lang]=$site_data['language_'.$lang];    
  }
   if(isset($array_language['language_'.$lang][$_POST['index_phrase']])){
   $this->redirect(NoiCore::app()->getRoute('language/add/'));    
  }
if($_POST['enable_'.$lang]=="html"){
  $array_language['language_'.$lang][$_POST['index_phrase']]=$_POST['html_value_'.$lang];
  
  
}else if($_POST['enable_'.$lang]=="string"){
$array_language['language_'.$lang][$_POST['index_phrase']]=$_POST['string_value_'.$lang];    
} 
 }
 }

 if(count($array_language)>0){
MGQuery::update($array_language, 'widget_user_sites', array("_id"=>new \MongoId($site_data['_id']->__toString())));
$this->redirect(NoiCore::app()->getRoute('language/index'));  
 }

}
public function actionUpdate($key){
   $list_language=NoiCore::app()->getListLanguges();
 if(isset($list_language) and count($list_language)>0){
   $site_data=NoiCore::app()->site_data;
  
 
  if(isset($_POST['edit_phrase'])){
    $this->doUpdate($key);  
  }   
      
   return $this->render("update",array('langs'=>$list_language,'site_data'=>$site_data,"key"=>$key));
  
}
     
}
public function actionDelete($key){
   $list_language=NoiCore::app()->getListLanguges();
 
   $site_data=NoiCore::app()->site_data;
   $array_update=array();
   if(isset($list_language) and count($list_language)>0){
   foreach($list_language as $lang){
       if(!isset($site_data['language_'.$lang])){
  $site_data['language_'.$lang]=array();    
  }
  if(isset($site_data['language_'.$lang][$key])){
 
  $array_update['language_'.$lang]=$site_data['language_'.$lang];
  unset($array_update['language_'.$lang][$key]);

      
   
  } 
   }    
   }
   if(count($array_update)>0){
       MGQuery::update($array_update, 'widget_user_sites', array("_id"=>new \MongoId($site_data['_id']->__toString())));
$this->redirect(NoiCore::app()->getRoute('language/index'));    
   }
 
  
}
  public function actionAdd($lang="null"){
   $list_language=NoiCore::app()->getListLanguges();
  if(isset($list_language) and count($list_language)>0){ 
    if(isset($_POST['add_phrase'])){
    $this->doAdd($lang);    
    }
    return $this->render("add",array('langs'=>$list_language));  
  }   
  }
  public function actionManage($lang="null"){
  $list_language=NoiCore::app()->getListLanguges();
  if(in_array($lang,$list_language)){
  $site_data=NoiCore::app()->site_data;
  if(!isset($site_data['language_'.$lang])){
  $site_data['language_'.$lang]=array();    
  }
  return $this->render("manage",array("lang"=>$lang,'language_data'=>$site_data['language_'.$lang]));
  }
  }
  
}
