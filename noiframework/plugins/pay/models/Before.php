<?php
namespace pay\models;
use NoiCore;
use voucher\models\Service;
use voucher\models\Voucher;
class Before{
    static function insert($order){
        if(isset($_GET['activate'])){
$order['activate']=(int)$_GET['activate'];    
}
if(isset($_GET['service_count']) and is_numeric($_GET['service_count']) and (int)$_GET['service_count']>0
      and isset($_GET['service_id']) and is_numeric($_GET['service_id']) and (int)$_GET['service_id']>0){
$order['service_count']=(int)$_GET['service_count'];
$order['service_id']=(int)$_GET['service_id'];

}
if(isset($_GET['type']) and is_string($_GET['type'])){
$order['type_payment']=$_GET['type'];
$array_title=array(
                                                    'SberOnlineRUB'=>'СбербанкОнлайн',
                                                    'yandexdengir'=>'Яндекс деньги',
                                                     'Webmoney'=>'Webmoney', 
                                                     'LiqPay'=>'LiqPay',
                                                     'PerfectMoney'=>'PerfectMoney',
                                                     'WalletOne'=>'Единый кошелек',
                                                      'Visa'=>'Visa',
                                                      'MasterCard'=>'MasterCard',
                                                      'Maestro'=>'Maestro',
                                                       'Qiwi'=>'Qiwi кошелек',
                                                       'Visa_WPC'=>'Шлюз Visa',
                                                       'Mastercard_WPC'=>'Шлюз MasterCard'
                                                        
                                                        
                                                        
                                                    );
if(isset($array_title[$_GET['type']])){
$order['type_payment_title']=$array_title[$_GET['type']];    
}
}
      return $order; 
    }
   static function delete($order){
     if(isset($order['activate']) and is_numeric($order['activate'])){
    $result=Voucher::doBuy((int)$order['activate'],NoiCore::user()->load($order['id_user']));
      if($result==true){
      NoiCore::app()->setNotify("Вы успешно купили ".$order['activate']." ваучеров");  
    
      }else {
       NoiCore::app()->setNotify("При покупке произошла ошибка. ");  
   
      }  
      
}  
if(isset($order['service_count']) and isset($order['service_id'])){
    $service=Service::getById((int)$order['service_id']);
   
    if(!is_bool($service)){
    $result=Service::doPay($service,$order['service_count'],NoiCore::user()->load($order['id_user']));
    }
}
 
   } 
}

