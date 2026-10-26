<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use noicms\mongogrid\system_core\MGQuery;

use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
 class TemplateController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="template";
  }
     public function getAllFiles(){
    $site=NoiCore::app()->site_data;
    $result_array=array();
    $page_dirs=array();
   if(isset($site['type_site']) and isset($site['theme_site'])){
   $current_theme=$site['type_site']."/".$site['theme_site'];
  $typedir=scandir(DOCUMENT_ROOT.THEMES_PATH."".$current_theme."/");
  if(is_array($typedir) and count($typedir)>0){
  foreach($typedir as $dir){
  $newname=str_replace("page","",$dir);
  if($dir!=$newname){
  if(file_exists(DOCUMENT_ROOT.THEMES_PATH."".$current_theme."/".$dir."/main.php") and is_dir(DOCUMENT_ROOT.THEMES_PATH."".$current_theme."/".$dir."/plugin")){
  $page_dirs[]=$dir;
  $cur_path=DOCUMENT_ROOT.THEMES_PATH."".$current_theme."/".$dir."/main.php";
    $cur_path=str_replace("//","/",$cur_path);
  $result_array[]=$cur_path;
  }
  }
  }
  }
    }
    if(count($page_dirs)>0){
    foreach($page_dirs as $dd){
    $folder_result=array();
    $cur_path=DOCUMENT_ROOT.THEMES_PATH."".$current_theme."/".$dd."/plugin";
    $cur_path=str_replace("//","/",$cur_path);
    
    $tmp_res=scandir($cur_path);

   $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($cur_path), RecursiveIteratorIterator::SELF_FIRST );

foreach ( $iterator as $path ) {
    if ($path->isDir()) {
       // print($path->__toString() . PHP_EOL);
    } else {
        $cur2_path=$path->__toString();
        $cur2_path=str_replace("//","/",$cur2_path);

       $result_array[]=$cur2_path;
    }
//    if(count($tmp_res)>0){
//    foreach($tmp_res as $res){
//     if($res!="." and $res!=".."){
//     $folder_result[]=$res;
//     }
//    }
    }
    }    
    }
    return $result_array;
     }
     public function getFile($path){

      $result=  MGQuery::execute(array(), 'template_page',array('path'=>$path));
      $content="";
      if(isset($result[0]['_id'])){
      if(isset($result[0]['content'])){
      return $result[0]['content'];
      }
      }
     if(file_exists($path)){
     $content=  file_get_contents($path);
      return $content;
    }
     }
     public function saveContent($path,$content){
     if(file_exists($path) and isset($content)){
     $result=  MGQuery::execute(array(), 'template_page',array('path'=>$path));
     if(!isset($result[0]['_id'])){
     $array=array();
     $array['path']=$path;
     $array['content']=$content;
     MGQuery::insert($array, 'template_page');
     }else {
     $array_update=array();
     $array_update['content']=$content;
     MGQuery::update($array_update,  'template_page', array('path'=>$path));
     }
     }
     }
     function actionIndex(){
    $files=$this->getAllFiles();
    if(isset($_GET['key']) and isset($files[$_GET['key']])){
      if(isset($_POST['content'])){
      $this->saveContent($files[$_GET['key']],$_POST['content']);
  }
    $content=$this->getFile($files[$_GET['key']]);

    return $this->render("edit_file",array('content'=>$content,'file'=>$files[$_GET['key']]));
    }else {
    if(isset($_GET['delete']) and isset($files[$_GET['delete']])){
        MGQuery::delete("template_page", array('path'=>$files[$_GET['delete']]));
        Yii::$app->controller->redirect(AdminController::getAdminLink('template'));
    }
   return $this->render("list_files",array('files'=>$files));
    }
     }
 }


