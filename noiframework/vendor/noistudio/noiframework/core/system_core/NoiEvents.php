<?php
 namespace noicms\core;
 use NoiCore;
 use Yii;
class NoiEvents{
 public $events=array();  
  private $site_data=array();
  function __construct($site_data) {
    
   $this->site_data=$site_data;   
  }
  public function execute($name_event,$arguments,$onlyfirst=false){
  if(!isset($name_event)){
   return null;   
  }    
  $first_result_is_array=false;
  $array_of_results=array();
   if(isset($this->events[$name_event])){
   foreach($this->events[$name_event] as $event){
    if(isset($event['class']) and isset($event['method'])){
     $class=$event['class'];
     $tmp_object=new $class();
     $tmp_results=call_user_func_array(array($tmp_object, $event['method']), $arguments);
     if($onlyfirst==false){
     $array_of_results[]=$tmp_results;    
     }else {
     if(is_bool($tmp_results) and $tmp_results===false){
         
     }else {
     if($onlyfirst==true and is_array($tmp_results)){
         $first_result_is_array=true; 
     }     
     $array_of_results[]=$tmp_results;     
     }    
     }
    }
   }    
   }
   if(count($array_of_results)>0){
   if($onlyfirst===true and isset($array_of_results[0])){
    $array_of_results=$array_of_results[0];   
   }else if($onlyfirst===true and !isset($array_of_results[0])){
    $array_of_results=false;   
   }  
   }
   if($onlyfirst===true and !isset($array_of_results[0]) and $first_result_is_array==false){
    if(is_array($array_of_results)){   
    $array_of_results=false;   
    }
   }
   return $array_of_results;
  }
  public function load(){

 
 $site_data=$this->site_data;
    $plugins_folder=array();
    if(isset($site_data['theme_components']['plugins']['available'])){
     $plugins_folder=$site_data['theme_components']['plugins']['available'];
    }
   
 
  if(count($plugins_folder)>0){
   foreach($plugins_folder as $plugin){
   
   if(file_exists(YII_PLUGIN_PATH."".$plugin."/events.php")){
 
 
    require_once  YII_PLUGIN_PATH."".$plugin."/events.php";
    if(isset($events_array) and count($events_array)>0){
    foreach($events_array as $name_event=>$event){
    if(!isset($this->events[$name_event])){
    $this->events[$name_event]=array();   
    } 
    if(isset($event[0])){
         
    foreach($event as $ev){
    $this->events[$name_event][]=$ev;    
    }    
    }else {
    $this->events[$name_event][]=$event;
    }
    }    
    }
  
   }    
   }   
  }
 
 
  }
}

