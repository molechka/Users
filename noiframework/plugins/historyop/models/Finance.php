<?php

namespace historyop\models;
use NoiCore;
use MongoId;
use MongoDate;
use Yii;
class Finance{
 
    static function getTotal(){
    $user=NoiCore::user()->load();    
    $result=array();
    $result['linebonus']=0;
    $result['leaderbonus']=0;
    $result['advbonus']=0;
    $result['binarbonus']=0;
    $result['total']=0;
    $result['linebonus']=Finance::getSumm($user, "data.linebonus", 1);
    $result['leaderbonus']=Finance::getSumm($user,"data.leaderbonus",1);
    $result['advbonus']=Finance::getSumm($user,"data.advbonus",1);
    $result['binarbonus']=Finance::getSumm($user, 'data.binarbonus', 1);
    $result['total']=$result['linebonus']+$result['leaderbonus']+$result['advbonus']+$result['binarbonus'];
    return $result;
    }
    static function getItogo2($condition=array()){
     $itogo=null;
    $collection=Yii::$app->mongodb->getCollection("historyop_collection");
    $match_array=array();
    if(count($condition)>0){
     $condition['op']="plus";
     
     $condition2=$condition; 
     $condition2['op']="minus";
     $match_array=array('$match' => $condition) ;  
$match_array2=array('$match' => $condition2) ;  
    }else {
      return null;  
    }
     
    if(!isset($condition['data.vauchersumm']) and !isset($condition['data.buyvaucher']) and  !isset($condition['data.usermoney'])){
    $result= $collection->aggregate(
             array(
            $match_array,
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$amount')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );
      $result2= $collection->aggregate(
             array(
            $match_array2,
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$amount')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );
 $minus=0;
  if(isset($result2[0]['summ'])){
   $minus=$result2[0]['summ'];  
  }else {
  $minus=0;
  }
  if(isset($result[0]['summ'])){
   $itogo=$result[0]['summ'];  
  }else {
  $itogo=0;
  }
   $itogo=$itogo-$minus;
    }
     
     return $itogo;
    }
    static function getTotale(){
    $total=array('count'=>0,'price'=>0);    
    $collection=Yii::$app->mongodb->getCollection("stats_pay");    
    $user=NoiCore::user()->load();    
    $match_array=array('$match' =>array('user._id'=>$user['_id'])) ;    
     $result= $collection->aggregate(
             array(
            $match_array,
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'price' => array('$sum' => array('$multiply'=>array('$price')) ),
                    'count' => array('$sum' => array('$multiply'=>array('$count')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) ); 
    
       if(isset($result[0]['count'])){
   $total['count']=$result[0]['count']; 
  }
    if(isset($result[0]['price'])){
   $total['price']=$result[0]['price']; 
  }
  return $total;
    }
    static function getItogo($condition=array()){
     $itogo=null;
    $collection=Yii::$app->mongodb->getCollection("historyop_collection");
    $match_array=array();
    if(count($condition)>0){
     $match_array=array('$match' => $condition) ;  

    }else {
      return null;  
    }
    if(!isset($condition['data.vauchersumm']) and !isset($condition['data.buyvaucher']) and  !isset($condition['data.usermoney'])){
    $result= $collection->aggregate(
             array(
            $match_array,
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$amount')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );
  if(isset($result[0]['summ'])){
   $itogo=$result[0]['summ'];  
  }else {
  $itogo=0;
  }
    }else {
    if(isset($condition['data.buyvaucher'])){    
        $result= $collection->aggregate(
             array(
            $match_array,
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$data.vauchers')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );
  if(isset($result[0]['summ'])){
   $itogo=$result[0]['summ']." ваучеров";  
  }else {
  $itogo="0  ваучеров";
  }
  
    }else if(isset($condition['data.usermoney'])){
    $newcondition=array();
    if(isset($condition['user.last_id'])){
    $newcondition['last_id']=$condition['user.last_id'];    
    }
     if(isset($condition['user.login'])){
    $newcondition['login']=$condition['user.login'];    
    }
    if(isset($condition['date'])){
    $newcondition['date_register']=$condition['date'];    
    }
      $collection=Yii::$app->mongodb->getCollection("cms_users");   
    if(count($newcondition)==0){
    $result= $collection->aggregate(
             array(
             
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$user_money')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );    
    }else {
     $match_array=array('$match' => $newcondition) ;    
      
     $result= $collection->aggregate(
             array(
            $match_array, 
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$user_money')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );    
      
    }
   
     
  if(isset($result[0]['summ'])){
   $itogo=$result[0]['summ'];  
  }else {
  $itogo="0";
  }    
    }
    if(isset($condition['data.vauchersumm'])){
      $newcondition=array();
    if(isset($condition['user.last_id'])){
    $newcondition['last_id']=$condition['user.last_id'];    
    }
     if(isset($condition['user.login'])){
    $newcondition['login']=$condition['user.login'];    
    }
    if(isset($condition['date'])){
    $newcondition['date_register']=$condition['date'];    
    }
      $collection=Yii::$app->mongodb->getCollection("cms_users");   
    if(count($newcondition)==0){
    $result= $collection->aggregate(
             array(
             
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$count_vouchers')) ),
                     'lost' => array('$sum' => array('$multiply'=>array('$lost_moneyv')) ),
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );    
    }else {
     $match_array=array('$match' => $newcondition) ;    
      
     $result= $collection->aggregate(
             array(
            $match_array, 
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$count_vouchers')) ),
                     'lost' => array('$sum' => array('$multiply'=>array('$lost_moneyv')) ),
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );    
      
    }
  if(!isset($result[0]['summ'])){
  $result[0]['summ']=0;    
  } 
  if(!isset($result[0]['lost'])){
  $result[0]['lost']=0;    
  }   
  $price=Voucher::getPrice(); 
  $result[0]['summ']=($result[0]['summ']*$price)-$result[0]['lost'];
   $itogo=$result[0]['summ'];  
    }
    }
     
     return $itogo;
    }
    static function getSummary($user,$side){
      $collection=Yii::$app->mongodb->getCollection("summary_balls");
      $result= $collection->aggregate(
             array(
            array(
                '$match' => array(
                    'user._id' => $user['_id'],
                    "side"=>$side
                 
                    
                )
            ),
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$price')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            )
            
        ) );
   $ismoney=0;   
  if(isset($result[0]['summ'])){
    $ismoney=$result[0]['summ'];  
  }else {
     $ismoney=0;
  }    
   
  $result_user=NoiCore::app()->db()->query(array(),"cms_users",array("binar.side"=>$side,"binar.parent"=>$user['login']));
    if(isset($result_user[0]['binar']['side'])){
    if(isset($result_user[0]['balls'])){
    $ismoney=$ismoney+$result_user[0]['balls'];    
    }
    }
  return $ismoney;
    }
    static function getSumm($user,$key,$field){
      $collection=Yii::$app->mongodb->getCollection("historyop_collection");
      $result= $collection->aggregate(
             array(
            array(
                '$match' => array(
                    'user._id' => $user['_id'],
                    $key=>$field
                 
                    
                )
            ),
            
            array(
                '$group' => array(
                    "_id" => 1,
                    'summ' => array('$sum' => array('$multiply'=>array('$amount')) )
                ),
            ),
            array(
                '$sort' => array(
                    '_id' => 1
                ),
            ),
            array(
                '$limit' => 30
            )
        ) );
  if(isset($result[0]['summ'])){
    return $result[0]['summ'];  
  }else {
      return 0;
  }
    }
}

