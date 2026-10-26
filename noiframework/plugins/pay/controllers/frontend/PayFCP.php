<?php
use user\models\MManager;
use voucher\models\Voucher;
use pay\models\Before;
class PayFCP extends CoreFrontendControllerPlugin{
   public function __construct($route,&$cur) {
        parent::__construct("pay",$cur,$route);
  
    }  
  public function actionStart($type=""){
      
   $value=$this->get_value();   
   if(!isset($type) and strlen($type)<=0){
    exit;   
   }   
   if(isset($_GET['money'])){
   $_POST['summ']=$_GET['money'];
   }
//   NoiCore::app()->redirect("/user/bill/index.html");
//exit;
    if($this->user()->isLogin()){
  

    if(!isset($_POST['summ'])){
  exit;
    }else {
  if(is_numeric($_POST['summ'])){
  $value=$this->get_value();
$_POST['summ']=(float)$_POST['summ'];
$order=array();
$order['_id']=new MongoId();
$order['id_user']=$this->user()->getLogged("user_id");
$order['user']=NoiCore::user()->load();
$order['amount']=(float)$_POST['summ'];
$order['type']=(string)$type;
$order=Before::insert($order);
 $order=NoiCore::app()->db()->insert($order,"plugin_pay",true);
 $result=NoiCore::events()->execute($type."_exists",array($order),true);
  if(isset($value[0]['disable']) and $value[0]['disable']==1 and $result==true){
 
   $order=array($order);
 
    if(isset($order[0]['_id']) and isset($value[0]['field_money']) and strlen($value[0]['field_money'])>0){
  
   if(isset($order[0]['id_user'])){
   
MManager::plus($order[0]['user']['_id']->__toString(),(float)$order[0]['amount'],'пополнение счета',2000,array('fillup'=>1,'type'=>'payment','title'=>$type));

Before::delete($order[0]);
//    $history['id_user']=$this->user()->id;
//    $history['user']=$this->user()->load();
//    $history['date']=new MongoDate();
//    $history['op']="plus";
//    $history['pop']=2000;
//    $history['amount']=(float)$order[0]['amount'];
//    $history['comment']="пополнение счета через payeer.com";
//    $this->db()->insert($history,"historyop_collection");
//    // $this->user()->update($array_update,$order[0]['id_user']);
//    $this->user()->update(array($value[0]['field_money']=>$order[0]['amount']),$this->user()->id,'$inc');
     $this->db()->delete("plugin_pay",array('_id'=>new MongoId($order[0]['_id']->__toString())));
$saved_lastid=NoiCore::app()->getSession("saved_lastid");
if(is_numeric($saved_lastid)){
  NoiCore::app()->redirect("/bugs/xls/view/".$saved_lastid);  
  NoiCore::app()->removeSession("saved_lastid");
  exit;  
}
     NoiCore::app()->returnback(); 
 exit;
  if(!isset($_GET['activate'])){
     NoiCore::app()->returnback();
 }else {
     NoiCore::app()->returnback(); 
 }
 exit;
   }
  }
}else if($result==true) {
  $payment_form=NoiCore::events()->execute($type."_form",array('order'=>$order,'value'=>$value,'user_id'=>$this->user()->getLogged("user_id")),true);
  
 if(!is_bool($payment_form)){
    echo $payment_form; 
 }
      exit;
}else {
    exit;
}

  }

    }
    }
    }  
}
