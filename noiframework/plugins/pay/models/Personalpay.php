<?php

namespace pay\models;
use NoiCore;
use MongoId;
class Personalpay{
  public $secret_token="55c1a60bd8252";
  public $_apiUrl="https://servicesexchnangermoney.com/_ps/api";
  public $secret_key="e90d3c0255c1a60bd8252953fec24b6a4cf1d7d4";
  public function exists(){
      return false;
      
  }
  public function getType(){
 return NoiCore::app()->db()->query2(array(),"type_payments",array());
  }
  public function isValidType($type){
  if(isset($type) and   is_string($type)){
    $count=NoiCore::app()->db()->count("type_payments",array('type'=>$type));
    
    if($count>0){
     return true;   
    }else {
        return false;
    }
  }else {
   return false;   
  }
  
  }
  public function check(){
  $result=false;    
 
//  NoiCore::app()->db()->insert(array('post'=>$_POST),"checktestpay");
 
  
 
 if(isset($_POST['data']) and isset($_POST['sign'])){
  $result_tmp=$this->_apiVerifyData($_POST['data'], $_POST['sign']);  
 
  if($result_tmp[0]===true){
   
   $unquoted_data = json_decode(urldecode($_POST['data']),true); 
 
   if(isset($unquoted_data['paymentid'])){
 
      
 
    
    if(isset($result_tmp[1]->payment_state) and $result_tmp[1]->payment_state=="success"){
     //$result=true;
     $result=(string)$unquoted_data['paymentid'];
    }
   }
  }
 }
 
 
 
    return $result;
  }
  
  public function listUrl($url=""){
  $result=array('name'=>'personalpay','success'=>$url."success/personalpay",'error'=>$url."fail/personalpay",'status'=>$url."status/personalpay");
  return $result;
  }
  public function getSign($data){
  $q_string="";
  foreach($data as $val){
  $q_string.=$val;    
  }
 
  return hash("sha224",$q_string.$this->secret_key);
  }
   public function form($order,$value,$user_id){
    if(isset($_GET['type']) and $this->isValidType($_GET['type'])){   
       $ch = curl_init();

 
curl_setopt($ch, CURLOPT_URL,"https://servicesexchnangermoney.com/_ps/api");
curl_setopt($ch, CURLOPT_POST, 1);
 $post=array(
  'data'=>array(
  
  'deposit_max'=>$order['amount'],
  'deposit_min'=>$order['amount'],
   'locale'=>'ru',
   'country'=>'ru', 
     'token'=>$this->secret_token,   
     'action'=>'prepare',   
    'currency'=>$_GET['type'],
   'payment_desc'=>'test',      
  'paymentid'=>(string)$order['_id']->__toString(),    
 
  'amount_value'=>$order['amount']
  
 
  
      
  ),
    
     
 );
 
 $result=$this->_apiRequest($post['data']);
  
 $html="";
if(isset($result[1]->url)){
 
    NoiCore::app()->redirect($result[1]->url);
 
}
 
curl_close ($ch);

        
    return $html;
    }
}
  function _apiVerifyData($data, $sign) {
        try {
            $unquoted_data = json_decode(urldecode($data));
            $hash = hash('sha224', $data . $this->secret_key);
            return array($hash == $sign, $unquoted_data);
        } catch (Exception $e) {
            error_log('_apiVerifyData Exception: ' . print_r($e, true));
            return array(false, null);
        }
    }


function _apiRequest($requestData) {

        error_log('_apiRequest $requestData:' . print_r($requestData, true));

        $dataSign = $this->_apiSignData($requestData);
        $response_nojson=$this->_curlRequest($dataSign);
         
        $response = json_decode($response_nojson, true);
      
        if (!empty($response['error'])) {
            error_log('_apiRequest Error' . print_r($response, true));
            return $response['error'];
        }

        return $this->_apiVerifyData($response['data'], $response['sign']);
    }

    private function _apiSignData($data) {
        $quoted_data = rawurlencode(json_encode($data));
        $hash = hash('sha224', $quoted_data . $this->secret_key);
        return array('data' => $quoted_data, 'sign' => $hash);
    }

private function _curlRequest($data, $method = 'POST') {

        error_log('Exchenger api request data:' . print_r($data, true));

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->_apiUrl);
        curl_setopt($ch, CURLOPT_POST, $method == 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);
        curl_close($ch);
        error_log('Exchenger api response: ' . print_r($res, true));

        return $res;
    }
}

