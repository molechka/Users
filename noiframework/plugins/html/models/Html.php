<?php
namespace html\models;
use NoiCore;
class Html{
    static function get($iswidget=0,$widget=array()){
     if(!is_array($widget)){
      $widget=array();
     }
     if(!isset($widget['position'])){
     $widget['position']="";
     }
     if(!isset($widget['number'])){
     $widget['number']="";
     }
      $value=NoiCore::app()->plugin_values("html","default",$iswidget,$widget['position'],$widget['number']);
  
     $cur_lang=NoiCore::app()->getLang();
     if(isset($value[0]['content'])){
      if(NoiCore::lang()->is()){


     if(isset($value[0]['content_'.$cur_lang])){
     $value[0]['content']=$value[0]['content_'.$cur_lang];
     }
      }
     }else {
      $value[0]['content']="";
     }
     return $value[0]['content'];
    }
    public function testMethod($name,$surname){
    if(isset($name ) and isset($surname)){
     return $surname." ".$name;   
    }    
    }
}
