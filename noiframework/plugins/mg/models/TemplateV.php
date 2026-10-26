<?php

namespace mg\models;
use NoiCore;
class TemplateV{
    public function check(){
    $site=NoiCore::app()->get();   
    $q_string=$_SERVER['QUERY_STRING'];
    $result=false;
   
    if(count($q_string)==0 or count($q_string)==1){
    $result=true;    
    }
    if($result==false){
    $result= strpos($q_string, "/mg");
    }
   
   
    
  $result_lk= strpos($q_string, "invest");
    if($result_lk==true){
    $result=false;    
    }
    $result_lk= strpos($q_string, "user");
   
    if($result_lk==true){
    $result=false;    
    }
    $result_lk= strpos($q_string, "voucher");
    if($result_lk==true){
    $result=false;    
    }
     $result_lk= strpos($q_string, "matrix");
    if($result_lk==true){
    $result=false;    
    }
    $result_lk= strpos($q_string, "user/lk/");
    if($result_lk==true){
    $result=false;    
    }
     $result_lk= strpos($q_string, "struct");
    if($result_lk==true){
    $result=false;    
    }
     $result_lk= strpos($q_string, "historyop");
    if($result_lk==true){
    $result=false;    
    }
     
    $result_tmp= strpos($q_string, "user/login/index");
    
   if($result_tmp==true){
     $result=true;  
       
   }else {
     $result_tmp= strpos($q_string, "user/register/index");   
     if($result_tmp==true){
         $result=true;
     }else {
          $result_tmp= strpos($q_string, "user/lost/index");  
          if($result_tmp==true){
           $result=true;   
          }
     }
   }
     $result_lk= strpos($q_string, "user/lost");
    if($result_lk==true){
    $result=true;    
    } 
 if(isset($_GET['ref'])){
      
 NoiCore::app()->setSession("from_user",array('user'=>$_GET['ref'])); 
 NoiCore::app()->redirect("/user/register/index.html");
 exit;
 }
 $res_from=NoiCore::app()->getSession("from_user");
 if(is_array($res_from) and isset($res_from['user'])){
 $_GET['referal']=$res_from['user'];    
 }
    if($result===true){
    $site['theme_site']="ap";
    
   if(strlen($_SERVER['QUERY_STRING'])==0){
    NoiCore::app()->setParam("title2","mlink_home");   
   }
    $res_entertainment=strpos($q_string,"/mg/5/1");
     if($res_entertainment!==false){
     NoiCore::app()->setParam("title2","mlink_entertainment");    
     } 
     $res_hotels=strpos($q_string,"/mg/6");
     if($res_hotels!==false){
     NoiCore::app()->setParam("title2","mlink_hotels");    
     } 
      $res_opportunity=strpos($q_string,"/mg/5/2");
     if($res_opportunity!==false){
     NoiCore::app()->setParam("title2","mlink_opportunity");    
     } 
     
      $res_adv=strpos($q_string,"/mg/5/3");
     if($res_adv!==false){
     NoiCore::app()->setParam("title2","mlink_advertising");    
     } 
      $res_ab=strpos($q_string,"/mg/5/4");
     if($res_ab!==false){
     NoiCore::app()->setParam("title2","mlink_aboutus");    
     } 
      $res_ab=strpos($q_string,"/mg/8");
     if($res_ab!==false){
     NoiCore::app()->setParam("title2","mlink_news");    
     } 
    
    NoiCore::app()->site_data=$site;
    }else {
     $site['theme_site']="ap_lk";
    NoiCore::app()->site_data=$site;    
    }
    }
}

