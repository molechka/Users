<?php
//основной класс для рендеринга сайтов пользователей
//Yii::setPathOfAlias('components_path', $_SERVER['DOCUMENT_ROOT']."/".NOIPRODUCT_FOLDER."/components/");
namespace noicms\frontend\controllers;
use yii\extensions\mongogrid\MongoGrid;
use Yii;
use noicms\mongogrid\system_core\MGQuery;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\mongodb\Query;
use NoiCore;
use NoiCoreSet;
use MongoDate;
 
class AppController{
  public $site_data;
  public $var_data=array();
  public $view_name="main.php";
  public $route="";
  public $path_route="";
  public $pre_data;
  public $istpl=false;
  public $view;
  public $view_name_tpl="main.tpl";

  function __construct($domain="www",$route="",$name_type="domain_site",$path_route="") {
    if(isset($domain)){
$url_host=$_SERVER['HTTP_HOST'];

$array_result=array();
    $result=MGQuery::execute2(array(), "widget_user_sites", array());
     if(count($result)>1){
      foreach($result as $r){
if(isset($r['subroute']) and $r['subroute']==$url_host){

  $array_result=$r;
}
      }
      if(!isset($array_result['_id'])){
        foreach($result as $r){
if(isset($r['subroute']) and $r['subroute']=="*"){
  $array_result=$r;
}
      }
      }
     }else {
     if(isset($result[0]['_id'])){
      $array_result=$result[0];
    }
     }

  if(isset($array_result['_id'])){
  //  yii::setPathOfAlias('render_site_tmp', YII_COMPONENT_PATH);
   // yii::import("render_site_tmp.view.*");
          if(!isset($array_result['route'])){
   $array_result['route']=array();
    }
    $array_result['route'][]=array('seo'=>'/sitemap.xml',"normal"=>"/sitemap/get");
    NoiCoreSet::add($array_result);
    
    $this->view= NoiCore::c("viewapp")->init($array_result,$route,$path_route);


    }

    }
  }
  public function before_event($site_id,$page_contain){
  if(strlen($site_id)>0){
   if(file_exists(DOCUMENT_ROOT."/themes/widget/userthemes/".$site_id."/event/BeforeEvent.php")){
  yii::import("webroot.themes.widget.userthemes.".$site_id.".event.*");
//  if(class_exists('BeforeEvent')){
//
//  }
  $error=0;
            try {
            $tmp=new BeforeEvent($site_id,$page_contain);

            } catch (Exception $exc) {
                $error=1;
            }

if($error==0){
 $object=new BeforeEvent($site_id, $page_contain);
 $page_contain=$object->result();

}
  }

}
return $page_contain;
  }
  public function after_event($site_id,$page_contain){
  if(strlen($site_id)>0){

  if(file_exists(DOCUMENT_ROOT."/themes/widget/userthemes/".$site_id."/event/AfterEvent.php")){

  yii::import("webroot.themes.widget.userthemes.".$site_id.".event.*");
//  if(class_exists('BeforeEvent')){
//
//  }
  $error=0;
            try {
            $tmp=new AfterEvent($site_id,$page_contain);

            } catch (Exception $exc) {
                $error=1;
            }

if($error==0){
 $object=new AfterEvent($site_id, $page_contain);
 $page_contain=$object->result();

}
  }
  }
return $page_contain;
  }
  
    public function return_render(){
   if(is_object($this->view)){
      
  $result=$this->view->return_render();

 
  //$result=$this->before_event($this->site_data['_id']->__toString(), $result);
 ///$this->after_event($this->site_data['_id']->__toString(),$result);
//      if(isset($_POST['microtime_start']) and is_numeric($_POST['microtime_start'])){
//          $time=microtime(true) - $_POST['microtime_start'];
//
//         $mb=NoiCore::custom()->memory_usage();
//         
//         $array_insert=array();
//         $array_insert['date']=new MongoDate();
//         $array_insert['time']=$time;
//      
//         $array_insert['mb']=$mb;
//         NoiCore::app()->db()->insert($array_insert,"stats_load");
//         $date = date ( "Y-m-j G:i:s" );
//        $day  =strtotime ( '-1 day' . $date );
//      
//        NoiCore::app()->db()->delete("stats_load",array('date'=>array('$lt'=>new MongoDate($day))));
//
//}
  return $result;
   }else {
     return "not install system please click here <a href='?install=install'>install right now</a>";
   }
  }
  public function config($var){
  if(isset($this->site_data['theme_components']['settings']['options']['fields'][$var]['value'])){
      return $this->site_data['theme_components']['settings']['options']['fields'][$var]['value'];
  }else {
     return "";
  }
  }

   public function render($file="",$return=false,$opt=array(),$default_redirect=1){

  if(isset($_POST['default_redirect']) and $_POST['default_redirect']=="off"){
  $default_redirect=0;
  unset($_POST['default_redirect']);
  }

  if($file==""){
  $file=$this->view_name;
  $file2=$this->view_name_tpl;
  }
  if(!isset($file2) and isset($this->view_name_tpl)){
  $file2=$this->view_name_tpl;
  }
 $tmp_var_1=str_replace(".tpl",".php",$file2);
 if($tmp_var_1!=$file){
  $file2=str_replace(".php",".tpl",$file);
 }


        //theme_site
   //$this->layout='webroot.themes.bootstrap.views.layouts.column2';
//$this->layoutPath = Yii::getPathOfAlias('webroot.themes.bootstrap.views.layouts')
 $path1=Yii::getPathOfAlias('webroot.themes.widget.'.$this->site_data['type_site'].'.'.$this->site_data['theme_site'].'.page');
 $path=$path1;
 $path2=Yii::getPathOfAlias('webroot.themes.widget.userthemes.'.$this->site_data['_id']->__toString().'.tpl');
 $path3=Yii::getPathOfAlias('webroot.themes.widget.userthemes.'.$this->site_data['_id']->__toString().'.page');

 if($default_redirect==1){
 $default_path=$path1."/main.php";
 $default_path2=$path2."/main.tpl";
  $default_path3=$path3."/main.php";
 }else {
  $default_path=$path1."/".$file;
 $default_path2=$path2."/".$file2;
  $default_path3=$path3."/".$file;
 }

// if($file=="pagination.php"){
//  echo $default_path;
//  echo $default_path2;
//  exit;
// }
 $path1=$path1."/".$file;
 $path=$path1;

 $path2=$path2."/".$file2;

 if(file_exists($path2)){
  $path=$path2;
  $this->istpl=true;
 }else {
 if(file_exists($path3."/".$file)){
 $path=$path3."/".$file;
 }else  if(file_exists($path1)){
 $path=$path1;

 }
 $this->istpl=false;
 }

 if(!file_exists($path2) and file_exists($default_path2) and $return==false){
  $path=$default_path2;
  $this->istpl=true;
 }
 if(!file_exists($path) and !file_exists($path2) and !file_exists($default_path2) and $return==false){
  if(file_exists($default_path3)){
  $path=$default_path3;
  }else {
  $path=$default_path;
  }
  $this->istpl=false;
  }
  if($path1==$path){
  $this->istpl=false;
  }


//  if($file=="menu.php"){
//   echo $path;
//   var_dump($this->istpl);
//   exit;
//
//
//  }
 $data=$this->var_data;
 $data['cur']=$this;
 $count_opt=count($opt);
 if($opt==array()){

$count_opt=0;
 }

if($count_opt>0 and is_array($opt)){

  foreach($opt as $key=>$val){
  $data[$key]=$val;
  }
}
if(isset( yii::app()->params['uc_var_array']) and is_array( yii::app()->params['uc_var_array']) and count(yii::app()->params['uc_var_array'])>0){
    foreach(yii::app()->params['uc_var_array'] as $key1=>$val1){
  $data[$key1]=$val1;
  }
}
if(!isset($data['site']['route_site']) or $data['site']['route_site']=="" ){
  $data['site']['route_site']="/";
}
$this->pre_data=$data;

if(file_exists($path)){


 if($this->istpl==false){


if($return==false){

$result=Yii::app()->controller->renderFile($path,$data,true);
 //echo $result;
return $result;
}else {
$result=Yii::app()->controller->renderFile($path,$data,true);
   return  $result;
}
 }else {
 return  $this->preParse($path);
 }
}
//$this->setLayout($result[0]['type_site'],$result[0]['theme_site']);
  }
  public  function get_component($tmp_name=""){


   $param=array();
 if(isset($this->path_route) and $this->path_route!=""){
  $tmp_var=explode("/",$this->path_route);

  if(!isset($tmp_var[1]) and isset($tmp_var[0])){
   $this->route=$tmp_var[0];
  }
  if(isset($tmp_var[1])){
   $this->route=$tmp_var[1];
  }

  if(isset($tmp_var[2])){
  $param[count($param)]=$tmp_var[2];
  }
   if(isset($tmp_var[3])){
  $param[count($param)]=$tmp_var[3];
  }
 }

 if(strlen($tmp_name)>0 and $tmp_name!=""){
 $this->route=$tmp_name;
 }

 if($this->route!=""){
     $class_name=ucfirst($this->route)."UserComponent";
    $path_component=Yii::getPathOfAlias('application.components');
    $path_component.="/".$class_name.".php";

     if(file_exists($path_component)){
     $class_data=new $class_name($param);
     $this->var_data['component']=$class_data->render_component($this->site_data['_id']->__toString());

     if(isset(yii::app()->params['uc_page'])){
 $parent_name=$this->route;
 if(isset(yii::app()->params['uc_page_type'])){
 $parent_name=yii::app()->params['uc_page_type'];
 }
 $this->view_name="component/".$parent_name."_".yii::app()->params['uc_page'].".php";

 }else {
 $this->view_name="component/".$this->route.".php";
 }

 return $this->var_data['component'];
     }else {

    $this->view_name="404.php";
     }


 }
  }
   public function preParse($path){




  if($this->istpl==true){
  $data=$this->pre_data;
  $data['site']=$this->site_data;
  $file_path=$path;

  yii::import("components_path.*");
  require_once 'smarty/SmartRender.php';
  $smart_render=new SmartRender();
  $smart_render->rendersite=&$this;
  $html=$smart_render->render($file_path, $data,1);

   return $html;
  }

  }
   public function get_paginator($url,$count,$limit,$current_page=0,$type="offset"){
   // Array to store page link list



  $noipage=new NoiPage();
  $noi_array_page=$noipage->calculate_pages($count, $limit, $current_page);

   return $noi_array_page;
  }
  public function get_config_var(){
   if(isset($this->site_data['theme_config'])){
    foreach($this->site_data['theme_config'] as $key=>$value){

    $value_arr=array();
    if($value['count']==1){
    if(isset($this->site_data['value'][$key][0])){
     $this->var_data['theme_'.$key]=$this->site_data['value'][$key][0];
    }else {
      $this->var_data['theme_'.$key]="";
    }
    }else {
     if(isset($this->site_data['value'][$key])){
     $this->var_data['theme_'.$key]=$this->site_data['value'][$key];
    }else {
      $this->var_data['theme_'.$key]=array();
    }
    }
    }

}
  }
}

