<?php
 
class MgACP  extends CoreAdminControllerPlugin{
 
 
 public function actionTest(){
     exit;
   $collections=NoiCore::app()->db()->query(array(),"collections_list",array());
   if(count($collections)>0){
   foreach($collections as $coll){
       $query=NoiCore::app()->db()->query2(array(),$coll['name'],array());
       if(count($query)>0){
       foreach($query as $qur){
       if(isset($qur['last_id'])){    
       $array_update=array('order_last_id'=>$qur['last_id']); 
       NoiCore::app()->db()->update($array_update,$coll['name'],array('last_id'=>(int)$qur['last_id']));
       }
       }    
       }
   }    
   }
   exit;
 }
}

