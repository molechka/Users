<?php

class ThemeManage {
 static public $theme_name="noiproduct";
 static public $path_left_sidebar="webroot.themes.admin.noishop.views.layouts.sidebar";
 static public $name_file="left.php";
 static public function getViewPath(){
 return Yii::getPathOfAlias(ThemeManage::$path_left_sidebar)."/".  ThemeManage::$name_file;
 }
 static public function get_left_sidebar(){
  return Yii::$app->params['left_col'];;
 }
 static public function isCurrent($url){
 $current_url=Yii::$app->request->url;
 $tmp=str_replace($url,"",$current_url);
 if($tmp!=$current_url or $current_url==$url){
   return true;
 }else {
  return false;
 }
 }
 static public function set_link($array_link,$sub_links=array()){
 if(!isset(Yii::$app->params['links_left_sidebar'])){
 Yii::$app->params['links_left_sidebar']=array();
 }

 $data['links']=Yii::$app->params['links_left_sidebar'];


 $new_array=Yii::$app->params['links_left_sidebar'];;
 $tmp_array_link=$array_link;
 $tmp_array_link['sub']=$sub_links;
 $new_array[]=$tmp_array_link;
  $data['links']=$new_array;
  $result="";
   Yii::$app->params['left_col']=$result;
 Yii::$app->params['links_left_sidebar']=$new_array;


 }
}

