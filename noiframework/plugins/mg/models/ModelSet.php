<?php

namespace mg\models;
use NoiCore;
class ModelSet{
    
    static function checkPrivacy($collection){
     $result=false;
   
     if(NoiCore::user()->isLogin() and isset($collection['canadduser']) and (int)$collection['canadduser']==1){
     $result=true;    
     }else if(!NoiCore::user()->isLogin() and isset($collection['canaddguest']) and (int)$collection['canaddguest']==1){
     $result=true;    
     }
     if(isset($collection['fields']) and count($collection['fields'])==0){
      $result=false;   
     }
     if(!isset($collection['fields'])){
     $result=false;    
     }
     
     return $result;
    }
    static function delete($collection,$last_id){
     if(is_numeric($last_id)){    
    $condition=array('last_id'=>(int)$last_id); 
    
     if(NoiCore::user()->isLogin()){
     $user=NoiCore::user()->load();    
     $condition['user._id']=$user['_id'] ;   
     }
     NoiCore::app()->db()->delete($collection['name'],$condition);
     
      }
     
    }
    static function insert($collection){
    $array=ModelSet::getArray($collection);
   
    if(is_array($array)){
    if(NoiCore::user()->isLogin()){
   $user=NoiCore::user()->load();     
    if(!isset($user['finance_password'])){
    NoiCore::app()->setNotify("У вас не установлен платежный пароль!");    
    return false;    
    }    
    if(!isset($_POST['password'])){
    NoiCore::app()->setNotify("У вас не указан платежный пароль!");    
    return false;
    }
    if($user['finance_password']!=hash("sha512",$_POST['password'])){
    NoiCore::app()->setNotify("Платежный пароль неверный!");    
    return false;
    }
    $array['user']=NoiCore::user()->load();   
    }    
     
    
    NoiCore::app()->db()->insert($array,$collection['name']);
    NoiCore::app()->setNotify("Данные успешно добавлены!");
    }
        
    }
    
    static function getArray($collection,$type="insert",$condition=array()){
    $result=array();
    $error=array();
    $finish_f=array();
    $val_array=array();
    if(isset($_POST['data']) and is_array($_POST['data']) and count($_POST['data'])>0){
    $val_array=$_POST['data'];    
    }
    if(isset($_FILES['data']) and is_array($_FILES['data']) and count($_FILES['data'])>0  ){
    foreach($_FILES['data'] as $fkey=>$fval){
    $val_array[$fkey]=$fval;    
    }    
    }
    if(count($val_array)>0){
     foreach($val_array as $key_val=>$val){
     if(isset($collection['fields'][$key_val])){
     $finish_f[$key_val]=1;    
     $field=$collection['fields'][$key_val];    
     $tmp_res=new \noicms\mongogrid\OneField();
     $opt=array();
     if(isset($field['json']) and Collections::isJson($field['json'])){
    $opt=json_decode($field['json'], true);        
     }
     $tmp_res->init($key_val, $field['type'], $opt);
     $_POST[$tmp_res->getName()]=$val;
     $_FILES[$tmp_res->getName()]=$val;
     $result_tmp=$tmp_res->setInput();
     
     if(isset($tmp_res->obj()->_title) and strlen($tmp_res->obj()->_title)>1){
     $result[$key_val."_title"]=$tmp_res->obj()->_title;
     }
     if(!is_bool($result_tmp)){
     $result[$key_val]=$result_tmp;    
     }else {
      if($field['required']==0 and isset($field['default'])){
          
        $error[]=$key_val;  
     //  $result[$key_val]=$field['default'] ;  
      }else {
       NoiCore::app()->setNotify("Значение поля ".$field['title']." неправильное!");   
       return false;   
      }   
     }
     if($field['unique']==1){
     $result[$key_val]=(string)$result[$key_val];
     $result[$key_val]=  strtolower($result[$key_val]);
     $count=NoiCore::app()->db()->count($collection['name'],array($key_val=>$result[$key_val]));
     if($count>0){
     if($field['required']==0 and isset($field['default'])){
          
        $error[]=$key_val;  
       //$result[$key_val]=$field['default'] ;  
      }else {
        NoiCore::app()->setNotify("Значение поля ".$field['title']." уже есть в базе");   
       return false;      
      }    
     }
     }
     }    
     }    
    }
     
 
     foreach($collection['fields'] as $key=>$f){
   
     if(!isset($result[$key]) ){
     if($f['required']==0){
     $result[$key]=$f['default'];   
     }else {
        NoiCore::app()->setNotify("Вы не ввели ".$f['title']." !");     
      return false;   
     }    
         
     }    
     }    
     
    
    return $result;
    }
}

