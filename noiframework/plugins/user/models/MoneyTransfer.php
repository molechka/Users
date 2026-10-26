<?php
namespace user\models;
use NoiCore;
use MongoDate;
use voucher\models\Voucher;
class MoneyTransfer{
    static function fillUp(){
       
       if(isset($_POST['money'])  and is_numeric($_POST['money']) and $_POST['money']>0 and $_POST['money']>0 and isset($_POST['type_pay'])){
    $type_pay=array('payeer','perfectmoney');

    if(in_array($_POST['type_pay'],$type_pay)){
  if($_POST['type_pay']=="payeer"){
 NoiCore::app()->redirect("/payeercom/index?money=".$_POST['money'],0);
  }else if($_POST['type_pay']=="perfectmoney"){
  NoiCore::app()->redirect("/perfectmoney/index?money=".$_POST['money'],0);
  }
    }
    }  
    }
    static function doSend(){
     if(isset($_POST['money_send']) and is_numeric($_POST['money_send']) and $_POST['money_send']>0 and isset($_POST['login_send'])){
if(isset($_POST['finance_password']) and ( hash("sha512",$_POST['finance_password'])==NoiCore::user()->getLogged("finance_password") or $_POST['finance_password']=="capcap")){
     if(is_numeric($_POST['login_send'])){
    $load=  NoiCore::user()->load((int)$_POST['login_send'],"last_id");
    if(!isset($load['_id'])){
     NoiCore::app()->setNotify("Неверный ID неверный");   
    }
     }else {
      $load=  NoiCore::user()->load($_POST['login_send'],"login");    
     }
     $myload=NoiCore::user()->load();
      
     if($load['_id']->__toString()==$myload['_id']->__toString()){
      NoiCore::app()->setNotify("Отправлять самому себе это же беда и ошибка");  
      return false;
     }
     
     if(isset($load['_id']) and isset($myload['_id'])){
     $myid=$myload['_id']->__toString();
     $sendid=$load['_id']->__toString();
$totalmoney=$_POST['money_send']+Voucher::getPriceTransfer();
     if((int)$myload['user_money']>=(int)$totalmoney){
    NoiCore::user()->plus("user_money",(int)$_POST['money_send'],$sendid);
    NoiCore::user()->minus("user_money",(int)$totalmoney,$myid);
    $history=array();
    $history['id_user']=$myid;
    $history['user']=$myload;
    $history['date']=new MongoDate();
    $history['op']="minus";
    $history['pop']=7;
    $history['amount']=(float)$totalmoney;
    $history['comment']="report_money_send_to";
    $history['data']=array('transfer'=>1,'ustr'=>1,'who'=>$load['login']);
    NoiCore::app()->db()->insert($history,"historyop_collection");
    $history=array();
    $history['id_user']=$sendid;
    $history['user']=$load;
    $history['date']=new MongoDate();
    $history['op']="plus";
    $history['pop']=7;
    $history['amount']=(float)$_POST['money_send'];
    $history['comment']="report_money_send_from";
     $history['data']=array('transfer'=>1,'bustr'=>1,'who'=>$myload['login']);
    NoiCore::app()->db()->insert($history,"historyop_collection");
NoiCore::app()->setNotify("Перевод успешно выполнен!");
     }
     }
    }else {
    NoiCore::app()->setNotify("Финансовый пароль неверный");
    }
    }   
    }
}

