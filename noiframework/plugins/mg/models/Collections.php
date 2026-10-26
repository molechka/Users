<?php
namespace mg\models;
use NoiCore;
use MongoId;
use noicms\mongogrid\OneField;
use noicms\core\StrInput; 
class Collections{
    static function getLastData(){
    $collections=NoiCore::app()->db()->query2(array(),"collections_list",array());
    if(count($collections)>0){
    foreach($collections as $key=>$collection){
    $sort=array('_id'=>-1);    
    if($collection['sort_field'] and isset($collection['sort'])){
      if($collection['sort']==="-1"){
      $sort=array($collection['sort_field']=>-1);    
      }else {
      $sort=array($collection['sort_field']=>1);    
      }   
    }else {
      $sort=array('_id'=>1);     
    }    
        
    $collections[$key]['rows']=NoiCore::app()->db()->query(array(),$collection['name'],array(),$sort);    
    }    
    }
    return $collections;
    }
    static function getAll(){
          $result=NoiCore::app()->db()->query(array(),'collections_list',array());
          return $result;
    }
  
    static function getManage($id_collection){
     $collection=Collections::get($id_collection);
     if(!is_bool($collection)){
     if(isset($collection['fields']) and is_array($collection['fields']) and count($collection['fields'])>0){
     foreach($collection['fields'] as $fkey=>$field){
     if($field['unique']==1){
     $collection['fields'][$fkey]['unique']=true;    
     }else {
      $collection['fields'][$fkey]['unique']=false;      
     } 
      if($field['required']==1){
     $collection['fields'][$fkey]['required']=true;    
     }else {
      $collection['fields'][$fkey]['required']=false;      
     }
     if(Collections::isJson($field['json'])){
     $collection['fields'][$fkey]['json']=  json_decode($field['json'], true);    
     }else {
     $collection['fields'][$fkey]['json']=array();     
     }
    
     }
      return $collection;
     }else {
      $collection['fields']=array();   
      return $collection;
     }    
     }else {
      return false;   
     }
    }
    
    static function getDocuments($data,$condition=array(),$count=0){
   
    if(isset($data['collection']['condition']) and Collections::isJson($data['collection']['condition'])){
    $newcondition=  json_decode($data['collection']['condition'],true); 
  
    if(is_array($newcondition) and count($newcondition)>0){
     foreach($newcondition as $newkey=>$newval){
     $condition[$newkey]=$newval;    
     }   
    }
 
    }
    if($count>0){
    $data['collection']['count_on_page']=$count;    
    }
    
    $result_condition=NoiCore::events()->execute($data['collection']['name']."_list_condition",array('collection'=>$data['collection'],'condition'=>$condition),true);
   
    if(is_array($result_condition)){
     
    $condition=$result_condition;    
    }
 
   
    $sort=array('_id'=>-1);
  
    
    if($data['collection']['sort_field'] and isset($data['collection']['sort'])){
      if($data['collection']['sort']==="-1"){
      $sort=array($data['collection']['sort_field']=>-1);    
      }else {
      $sort=array($data['collection']['sort_field']=>1);    
      }   
    }else {
      $sort=array('_id'=>1);     
    }
    $data['all']=NoiCore::app()->db()->query(array(),$data['collection']['name'],$condition,$sort,$data['collection']['count_on_page'],NoiCore::c("ppaginator")->getOffset($data['collection']['count_on_page']));
  
    $data['all']=  Documents::parse($data['all'], $data['collection']);
    if(count($data['all'])>0){
    foreach($data['all'] as $kd=> $d){
    $data['all'][$kd]['last_url']="/mg/".$data['collection']['name']."/".$d['last_id'].".html";    
    }    
    }
    $data['collection']=  Documents::parsec($data['collection']);
    $data['count']=NoiCore::app()->db()->count($data['collection']['name'],$condition);
    $data['url_document']="/mg/".$data['collection']['last_id']."/";
    $data['pages']=NoiCore::c("ppaginator")->show($data['count'],$data['collection']['count_on_page']);
    return $data;
    }
    static function getDocument($last_id,$collection){
     if(is_numeric($last_id) and isset($collection['_id'])){
        $result=NoiCore::app()->db()->query(array(),$collection['name'],array('last_id'=>(int)$last_id));
    if(isset($result[0]['_id'])){
     $result=  Documents::parse($result, $collection);   
      $result_new=NoiCore::events()->execute($collection['name']."_one",array('collection'=>$collection,'document'=>$result[0]),true);
    
      if(is_array($result_new)){
    $result[0]=$result_new;  

    }   
     if($collection['sort_field'] and isset($collection['sort'])){
      if($collection['sort']==="-1"){
      $sort=array($collection['sort_field']=>-1);    
      }else {
      $sort=array($collection['sort_field']=>1);    
      }   
    }else {
      $sort=array('_id'=>1);     
    }
    $next=NoiCore::app()->db()->query(array(),$collection['name'],array('last_id'=>array('$gt'=>(int)$last_id)),array('_id'=>1),1);
    if(isset($next[0]['_id'])){
     $next[0]=  Documents::parse($next[0], $collection);    
    $result[0]['next']=$next[0];    
    }  
    
    $prev=NoiCore::app()->db()->query(array(),$collection['name'],array('last_id'=>array('$lt'=>(int)$last_id)),array('_id'=>-1),1);
    if(isset($prev[0]['_id'])){
     $prev[0]=  Documents::parse($prev[0], $collection);      
    $result[0]['prev']=$prev[0];    
    } 
    NoiCore::app()->setParam("mg_current_page",$collection['name']."_".$last_id);

     return  $result[0];  
    }else {
       return false; 
    }  
     }else {
         return false;
     }   
    }
    static function getByID($last_id){
      
    if(isset($last_id) and is_numeric($last_id)){
    $result=NoiCore::app()->db()->query(array(),'collections_list',array('last_id'=>(int)$last_id));
    if(isset($result[0]['_id'])){
      $result[0]=  Documents::parsec($result[0]);
     return  $result[0];  
    }else {
       return false; 
    }
    }else if(isset($last_id) and is_string($last_id)){
    $result=NoiCore::app()->db()->query(array(),'collections_list',array('name'=>$last_id));
  
    if(isset($result[0]['_id'])){
      $result[0]=  Documents::parsec($result[0]);
  
     return  $result[0];  
    }else {
       return false; 
    }     
    }else {
        return false;
    }    
    }
    static function get($id_collection){
        if(isset($id_collection) ){
     if(StrInput::is_Id($id_collection))  {    
     $result=NoiCore::app()->db()->query(array(),'collections_list',array('_id'=>new MongoId($id_collection)));
        }else {
          $result=NoiCore::app()->db()->query(array(),'collections_list',array('name'=>$id_collection));
      
        }
     if(isset($result[0]['_id'])){
         return $result[0];
     }else {
         return false;
     }
        }else {
            return false;
        }
    }
    static function updateField($id_collection,$key){
      if(isset($id_collection) and StrInput::is_Id($id_collection)){
      $colection=  Collections::get($id_collection);
      if(isset($colection['fields'][$key])){
      $array_update=array('fields'=>$colection['fields']);
       if(isset($_POST['field_title']) and strlen($_POST['field_title'])>0){
       $array_update['fields'][$key]['title']=strip_tags($_POST['field_title']);
       
       }
     $type=new OneField();
     $type->init("type","type"); 
     $result_type=$type->setInput();
     if(!is_bool($result_type)){
     $array_update['fields'][$key]['type']=$result_type;     
     }
     $multilang=0;
     if(isset($_POST['multilang'])){
     $multilang=1;    
     }
   
     $array_update['fields'][$key]['multilang']=$multilang;    
   
     if(isset($_POST['required']) and (int)$_POST['required']==1){
     $array_update['fields'][$key]['required']=1;    
     }else {
     $array_update['fields'][$key]['required']=0;    
     }
     if(isset($_POST['unique']) and (int)$_POST['unique']==1){
     $array_update['fields'][$key]['unique']=1;    
     }else {
      $array_update['fields'][$key]['unique']=0;       
     }
     if(isset($_POST['showinlist']) and (int)$_POST['showinlist']==1){
     $array_update['fields'][$key]['showinlist']=1;    
     }else {
     $array_update['fields'][$key]['showinlist']=0;     
     }
     if(isset($_POST['field_value']) and strlen($_POST['field_value'])>0){
     $array_update['fields'][$key]['default']=strip_tags($_POST['field_value']);    
     }
     if(isset($_POST['json'])){
     $array_update['fields'][$key]['json']=$_POST['json']; 
     }
     
   
      NoiCore::app()->db()->update($array_update,'collections_list',array('_id'=>new MongoId($id_collection)));

      }
     }   
    }
    static function deleteField($id_collection,$key){
     if(isset($id_collection) and StrInput::is_Id($id_collection)){
      $colection=  Collections::get($id_collection);
      if(isset($colection['fields'][$key])){
      $array_update=array('fields'=>$colection['fields']);
      unset($array_update['fields'][$key]);
      NoiCore::app()->db()->update($array_update,'collections_list',array('_id'=>new MongoId($id_collection)));

      }
     }
    }
    static function addField($id_collection){
     if(isset($id_collection) and StrInput::is_Id($id_collection)){
      $colection=  Collections::get($id_collection);
     if(isset($_POST['field_title']) and strlen($_POST['field_title'])>0){
     $username=  new OneField();
     $username->init("name","username"); 
     $result_name=$username->setInput();
     if(!is_bool($result_name)){
     $type=new OneField();
     $type->init("type","type"); 
     $result_type=$type->setInput();
     if(!is_bool($result_type)){
     $required=0;
     $unique=0;
     $default_value="";
     $showinlist=0;
     if(isset($_POST['required']) and $_POST['required']==1){
     $required=1;    
     }
     if(isset($_POST['unique']) and $_POST['unique']==1){
     $unique=1;    
     }
     if(isset($_POST['showinlist']) and $_POST['showinlist']==1){
     $showinlist=1;    
     }
     if(isset($_POST['field_value']) and strlen($_POST['field_value'])>0){
     $default_value=strip_tags($_POST['field_value']);    
     }
     if(isset($_POST['json'])){
     $json=$_POST['json'];    
     }
     $multilang=0;
     if(isset($_POST['multilang'])){
     $multilang=1;    
     }
     if(!isset($colection['fields'][$result_name])){
     $array_update=array('fields'=>array());
     if(isset($colection['fields'])){
     $array_update['fields']=$colection['fields'];    
     }
     $array_update['fields'][$result_name]=array('title'=>strip_tags($_POST['field_title']),'multilang'=>$multilang,'type'=>$result_type,'required'=>$required,'unique'=>$unique,'default'=>$default_value,'showinlist'=>$showinlist,'json'=>$json);
    
     NoiCore::app()->db()->update($array_update,'collections_list',array('_id'=>new MongoId($id_collection)));
     }
     }
     }
     }
              
     } 
     
    }
     static function isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}
}

