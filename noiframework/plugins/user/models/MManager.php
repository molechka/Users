<?php
namespace user\models;
use NoiCore;
class MManager{
  
   public static function minus($user_id,$money,$comment="",$pop=1,$data=array()){
   $load_user=  NoiCore::user()->load($user_id,"_id");
   $result=false;
   if(isset($load_user['_id'] ) and is_numeric($money)){
   if(isset($load_user['user_money']) and $load_user['user_money']>=$money){
       NoiCore::user()->history($load_user,"minus",$money,$comment,$pop,$data);
  NoiCore::user()->minus("user_money",$money,$load_user['_id']->__toString());
  $result=true;
   }
   }
   return $result;
   }
      
   public static function plus($user_id,$money,$comment="",$pop=1,$data=array()){
   $load_user=  NoiCore::user()->load($user_id,"_id");
    
   
   $result=false;
   if(isset($load_user['_id'] ) and is_numeric($money)){
 
    NoiCore::user()->history($load_user,"plus",$money,$comment,$pop,$data);
  NoiCore::user()->plus("user_money",$money,$load_user['_id']->__toString());
  $result=true;

   }
   return $result;
   }
   public static function toFond($type="charity",$id_user,$money){
   if(isset($type) and ($type=="charity"  or $type=="company") and isset($id_user) and isset($money)){
     $comment="перевод средств на счет компании";
     if($type=="charity"){
     $comment="перевод в благотворительный фонд";
     }
       $user_info=  NoiCore::user()->load($id_user);
       MoneyManager::minus($id_user, $money,$comment,1);
       $array_insert=array();
       $array_insert['user']=$user_info;
       $array_insert['money']=(float)$money;
       $array_insert['date']=new MongoDate();
       $array_insert['type']=$type;
       NoiCore::app()->db()->insert($array_insert,"plugin_matrix_public_money");
   }
   }

}

