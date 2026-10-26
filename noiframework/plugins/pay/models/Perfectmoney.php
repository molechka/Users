<?php
namespace pay\models;
class Perfectmoney{
  public $payee_account="";
  public $phrase_hash="";
  
  //EUR,USD
  public $amount_type="USD";
  public function exists(){
      return true;
      
  }
  public function listUrl($url){
  $result=array('name'=>'perfectmoney.com','success'=>$url."success/perfectmoney",'error'=>$url."fail/perfectmoney",'status'=>$url."status/perfectmoney");
  return $result;
  }
  public function check(){
  $result=false;
  
  if(  isset($_POST['PAYMENT_ID']) and isset($_POST['PAYEE_ACCOUNT']) and isset($_POST['PAYMENT_AMOUNT']) and isset($_POST['PAYMENT_UNITS']) and isset($_POST['PAYMENT_BATCH_NUM']) and isset($_POST['PAYER_ACCOUNT']) and isset($_POST['TIMESTAMPGMT']) and isset($_POST['ORDER_NUM']) and StrInput::is_Id($_POST['ORDER_NUM'])){
 //$value[0]['phrase_hash']=  mb_strtoupper($value[0]['phrase_hash']);
  
$string=
      $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
      $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
      $_POST['PAYMENT_BATCH_NUM'].':'.
      $_POST['PAYER_ACCOUNT'].':'.strtoupper(md5($this->phrase_hash)).':'.
      $_POST['TIMESTAMPGMT'];

$hash=strtoupper(md5($string));
 
/*
   Please use this tool to see how valid hash is genereted:
   https://perfectmoney.is/acct/md5check.html
*/

 
  if($hash==$_POST['V2_HASH']){ 
   $result=$_POST['ORDER_NUM'];   
  } }
  return $result;
  }
  public function form($order,$value,$user_id){
     
 return  '<form  name="pay" action="https://perfectmoney.is/api/step1.asp" method="POST">
<p>
    <input type="hidden" name="PAYEE_ACCOUNT" value="'.$this->payee_account.'">
    <input type="hidden" name="PAYEE_NAME" value="Fill up money">
    <input type="hidden" name="PAYMENT_AMOUNT" value="'.$order['amount'].'">
    <input type="hidden" name="PAYMENT_UNITS" value="'.$this->amount_type.'">
    <input type="hidden" name="STATUS_URL"
        value="http://'.$_SERVER['HTTP_HOST'].'/pay/status/status/perfectmoney">
    <input type="hidden" name="PAYMENT_URL"
        value="http://'.$_SERVER['HTTP_HOST'].'/pay/status/success/perfectmoney">
    <input type="hidden" name="NOPAYMENT_URL"
        value="http://'.$_SERVER['HTTP_HOST'].'/pay/status/fail/perfectmoney">
    <input type="hidden" name="BAGGAGE_FIELDS"
        value="ORDER_NUM CUST_NUM">
    <input type="hidden" name="ORDER_NUM" value="'.$order['_id']->__toString().'">
    <input type="hidden" name="CUST_NUM" value="2067609">
    <input type="submit" name="PAYMENT_METHOD" value="Оплатить">
</p>
</form>
 
<script>
   document.pay.submit();
</script>';
  
}
}

