<?php
namespace noicms\mongogrid;

class SchemaGrid{
  public $grid;

  function __construct($schema,$name_schema) {
    yii::import($schema,true);
    $array=$name_schema();
    if(is_array($array)){
   if(!isset($array['collection']) or !isset($array['main_options']['limit']) or !isset($array['main_options']['limit']) or !isset( $array['main_options']['short_name']) or !isset($array['main_options']['title'])){
    exit;
   }
   if(!isset( $array['main_options']['offset'])){
        $array['main_options']['offset']=0;
   }
    if(isset($array['collection']) and is_array($array['main_options'])){

    $grid=new MongoGrid($array['collection'], $array['main_options']['limit'], $array['main_options']['offset'], $array['main_options']['short_name'], $array['main_options']['title']);
    if(isset($array['condition'])){
    $grid->condition=$array['condition'];
}
    if(isset($array['options']['sort'])){
    $grid->sort=$array['options']['sort'];
    }
    if(isset($array['fields']) and is_array($array['fields']) and is_array($array['field'])){
    $fields=new GridField();
    $fields->setFields($array['fields']);
 
    foreach($array['fields'] as $field){
   
    if(!isset($array['field'][$field]['label'])){
    $array['field'][$field]['label']=$field;
    }
    if(!isset($array['field'][$field]['required'])){
    $array['field'][$field]['required']=false;
    }
    if(!isset($array['field'][$field]['unique'])){
    $array['field'][$field]['unique']=false;
    }
    if(!isset($array['field'][$field]['options'])){
    $array['field'][$field]['options']=array();
    }
    if(!isset($array['field'][$field]['default_value'])){
    $array['field'][$field]['default_value']="";
    }
 
    if(isset($array['field'][$field]['type'])){
    $fields->setField($field, $array['field'][$field]['type'],$array['field'][$field]['default_value'], $array['field'][$field]['options'], $array['field'][$field]['label'], $array['field'][$field]['required'], $array['field'][$field]['unique']);
    }
    }
      if(isset($array['not_show'])){
    $fields->not_show= $array['not_show'];
    }
    if(isset($array['showid'])){
    $fields->showid=$array['showid'];
    }
   
    $grid->setFields($fields);
    $operation=new GridOperation();
    if(isset($array['operations']['denied'])){
    $operation->denied_access=$array['operations']['denied'];
    }else {
    $operation->denied_access=array();
    }
    if(isset($array['operations']['available'])){
    $operation->available=$array['operations']['available'];
    }else {
    $operation->available=array();
    }
    if(isset($array['operations']['default']['operation'])){
    $operation->default_operation=$array['operations']['default']['operation'];
     }
    if(isset($array['operations']['default']['value'])){
    $operation->default_value=$array['operations']['default']['value'];
    }
    }
    if(isset($array['event']['after']) and count($array['event']['after'])>0){
     foreach($array['event']['after'] as $event){

      if(isset($event['name']) and isset($event['opt']['obj']) and isset($event['opt']['method'])){
     $operation->event_after[$event['name']]=array('obj'=>$event['opt']['obj'],"method"=>$event['opt']['method']);
      }
     }
    }
     if(isset($array['event']['before']) and count($array['event']['before'])>0){
     foreach($array['event']['before'] as $b){
      if(isset($b['name']) and isset($b['opt']['obj']) and isset($b['opt']['method'])){
     $operation->event_before[$b['name']]=array('obj'=>$b['opt']['obj'],"method"=>$b['opt']['method']);
      }
     }
    }
     if(isset($array['event']['main']) and count($array['event']['main'])>0){
     foreach($array['event']['main'] as $main_event){
      if(isset($main_event['name']) and isset($main_event['opt']['obj']) and isset($main_event['opt']['method'])){
     $operation->event[$main_event['name']]=array('class'=>$main_event['opt']['obj'],"method"=>$main_event['opt']['method']);
      }
     }
    }
       if(isset($array['route']['after']) and count($array['route']['after'])>0){
      $operation->route_after=array();
       
     foreach($array['route']['after'] as $key=>$value){
    if(isset($key) and isset($value)){
      $operation->route_after[$key]=$value;

    }
     }
    }
    if(isset($array['view']) and count($array['view'])>0){
     foreach($array['view'] as $view){
      if(isset($view['name']) and isset($view['path'])){
      $grid->view->available[$view['name']]=$view['path'];
      }
     }
    }

    $grid->setOperations($operation);
    $this->grid=$grid;
    }
    }
  }
  public function render(){
      return $this->grid->render();
  }
  public function setCondition($key,$value=0){
    if(is_array($key)){
    $this->grid->condition=$key;
    }
   else if(isset($key) and isset($value)){
   $this->grid->condition[$key]=$value;
   }
  }
  public function setOption($data){
  if(isset($data)){
   $this->grid->view->option=$data;
  }

  }
  public function getFields(){
    return $this->grid->fields;
  }
  public function setFields($fields){
    if(isset($fields)){
    $this->grid->setFields($fields);
    }
  }
  public function getOperations(){
    return $this->grid->operations;
  }
  public function setOperations($operations){
      if(isset($operations)){
       $this->grid->setOperations($operations);
      }
  }
  public function setTitle($title){
   if(isset($title)){
    $this->grid->title=$title;
   }
  }
}
?>