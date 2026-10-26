<?php
namespace pay\models;
use Interkassa2;
use Interkassa_Shop;
use Interkassa_Payment;
use Interkassa_Status;
use Interkassa_Exception;
use NoiCore;
use MongoId;
class Interkassa{
  public $m_shop="1";
  //EUR,USD,RUB
  public $shop_id="562957e03d1eaf4a358b4569";
  public $shop_password="IJmgnew5Z5CKxrSE";
  public $shop_passwdord_test="zSDT94qrNndb30zD";
  public $shop=null;
  public $amount_type="USD";
  public $m_key="123123";
  
  public function __construct() {
      include_once PATH_TO_ENGINE.'/extensions/ik-php-master/interkassa2.php';
      Interkassa2::register();
      $this->shop = Interkassa_Shop::factory(array(
    'id' => $this->shop_id,
    'secret_key' => $this->shop_password
));
  }
  public function exists(){
      return true;
      
  }
  public function listUrl($url){
  $result=array('name'=>'interkassa','success'=>$url."success/interkassa",'error'=>$url."fail/interkassa",'status'=>$url."status/interkassa");
  return $result;
  }
  public function check(){
 $result=false;     
  
 $query2=NoiCore::app()->db()->query(array(),"interkassa_log",array('_id'=>new MongoId("5628c8c47663fce43e8b4708")));
 if(isset($query2[0]['post'])){
 $_POST=$query2[0]['post']; 
 }
 if(isset($_POST['microtime_start'])){
        unset($_POST['microtime_start']);
    }
 
 if(isset($_POST) and count($_POST)>0){

try {
    $status = $this->shop->receiveStatus($_POST); // POST is used by default
    if(isset($_POST['ik_inv_st']) and $_POST['ik_inv_st']=="success" and isset($_POST['ik_pm_no'])){
    $result=$_POST['ik_pm_no'];
    }
} catch (Interkassa_Exception $e) {
    // The signature was incorrect, send a 400 error to interkassa
    // They should resend payment status request until they receive a 200 status
    $result=false;
}

 
 
  
 }
 
return $result;
  }
  public function form($order,$value,$user_id){
 
$payment_id = $order['_id']->__toString(); // Your payment id
$payment_amount =$order['amount']; // The amount to charge your shop's user
$payment_desc = 'Пополнение счета Caribbean Bridge'; //yment description
 
$payment = $this->shop->createPayment(array(
    'id' => $payment_id,
    'amount' => $payment_amount,
    'description' => $payment_desc
));
 ?>
<form id="forms" action="<?= $payment->getFormAction(); ?>" method="post">
    <?php foreach ($payment->getFormValues() as $field => $value): ?>
    <input type="hidden" name="<?= $field; ?>" value="<?= $value; ?>" />
    <?php endforeach; ?>
    <button type="submit">Оплатить</button>
</form>
<script>
 document.getElementById("forms").submit();   
</script>
<?
exit;
}
}

