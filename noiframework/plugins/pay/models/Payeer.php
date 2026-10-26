<?php
namespace pay\models;
use NoiCore;
class Payeer{
  public $m_shop="1";
  //EUR,USD,RUB
  public $amount_type="USD";
  public $m_key="123123";
  public function exists(){
      return true;
      
  }
  public function listUrl($url){
  $result=array('name'=>'payeer.com','success'=>$url."success/payeer",'error'=>$url."fail/payeer",'status'=>$url."status/payeer");
  return $result;
  }
  public function check(){
 $result=false;     
 $_POST=$_GET;
   if ( isset($_POST["m_operation_id"]) && isset($_POST["m_sign"]))
{
	$m_key = $this->m_key;
	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);
	$sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));
      
	if ($_POST["m_sign"] == $sign_hash && $_POST['m_status'] == "success")
{   
       $result=$_POST['m_orderid'];     
            } }
return $result;
  }
  public function form($order,$value,$user_id){
  $m_shop = $this->m_shop;
$m_orderid = $order['_id']->__toString();
$m_amount = $m_amount = number_format($order['amount'], 2, '.', '');
 
$m_curr = $this->amount_type;
 
$m_desc = base64_encode('пополнение');
$m_key = $this->m_key;

$arHash = array(
	$m_shop,
	$m_orderid,
	$m_amount,
	$m_curr,
	$m_desc,
	$m_key
);

$sign = strtoupper(hash('sha256', implode(":", $arHash)));
NoiCore::app()->redirect("http://payeer.com/api/merchant/m.php?m_shop=".$m_shop."&m_orderid=".$order['_id']->__toString()."&m_amount=".$m_amount."&m_curr=".$m_curr."&m_desc=".$m_desc."&m_sign=".$sign."&m_process=send");    
 exit;
}
}

