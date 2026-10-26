<?php
use user\models\MManager;
use voucher\models\Voucher;

class StatusPayFCP extends CoreFrontendControllerPlugin{
   public function __construct($route,&$cur) {
        parent::__construct("pay",$cur,$route);
  
    }
    
  public function actionIndex($name,$type){
  $value=$this->get_value();    
   if($name=="success" and isset($type)){
     $result=NoiCore::events()->execute($type."_exists",array(),true);
     if($result===true){
     $ispay=NoiCore::events()->execute($type."_check",array(),true);  
     if(!is_bool($ispay)){
     if(!is_numeric($ispay)){    
     $order=$this->db()->query(array(),"plugin_pay",array('type'=>(string)$type,'_id'=>new MongoId($ispay)));
     }else {
         $order=$this->db()->query(array(),"plugin_pay",array('type'=>(string)$type,'last_id'=>(int)$ispay));
     
     }
     if(isset($order[0]['_id']) and isset($value[0]['field_money']) and strlen($value[0]['field_money'])>0){
   if(isset($order[0]['id_user'])){
    $user_load=$this->user()->load($order[0]['id_user']);
    $array_update=array();
    $array_update[$value[0]['field_money']]=$order[0]['amount'];
    if(isset($user_load[$value[0]['field_money']])){
     $array_update[$value[0]['field_money']]=(float)$user_load[$value[0]['field_money']]+$array_update[$value[0]['field_money']];
    }
    $arr_data=array('fillup'=>1,'type'=>'payment','title'=>$type);
    if(isset($order[0]['type_payment_title'])){
    $arr_data['title2']=$order[0]['type_payment_title'];  
    } 
    if(isset($order[0]['type_payment'])){
    $arr_data['title3']=$order[0]['type_payment'];  
    } 
    if(isset($_POST['ik_inv_id'])){
    $arr_data['inv_id']=$_POST['ik_inv_id'];    
    }
    
    MManager::plus($order[0]['id_user'],(float)$order[0]['amount'],'report_fillup',2000,$arr_data);
       $this->db()->delete("plugin_pay",array('_id'=>new MongoId($order[0]['_id']->__toString())));

    if(isset($order[0]['activate'])){
    
   $result=Voucher::doBuy((int)$order[0]['activate'],NoiCore::user()->load($order[0]['id_user']));
      if($result==true){
      NoiCore::app()->setNotify("Вы успешно купили ".$order[0]['activate']." ваучеров");  
    
      }else {
       NoiCore::app()->setNotify("При покупке произошла ошибка. ");  
   
      }    
 }
//     $history['id_user']=$order[0]['id_user'];
//      $history['user']=$user_load;
//    $history['date']=new MongoDate();
//    $history['op']="plus";
//    $history['pop']=2000;
//    $history['amount']=(float)$order[0]['amount'];
//    $history['comment']="пополнение счета через payeer.com";
//    $this->db()->insert($history,"historyop_collection");
//     $this->user()->update(array($value[0]['field_money']=>$order[0]['amount']),$order[0]['id_user'],'$inc');
    // $this->user()->update($array_update,$order[0]['id_user']);

   }
  }
     }
          
     }
       
   } 
   exit;
  }
  
  }  
   

