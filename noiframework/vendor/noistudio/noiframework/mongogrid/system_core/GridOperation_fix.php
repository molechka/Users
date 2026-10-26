<?php

class GridOperation_fix {
    public $denied_access=array();
    public $mg;
    public $available=array("list",'create','update','delete');
    public $event=array(
        "list"=>array('class'=>'GridStatic','method'=>'eventList'),
        "create"=>array('class'=>'GridStatic','method'=>'eventCreate'),
        'update'=>array('class'=>'GridStatic','method'=>'eventUpdate'),
        'delete'=>array('class'=>'GridStatic','method'=>'eventDelete'),
        'show'=>array('class'=>'GridStatic','method'=>'eventShow'),

    );
    public $event_before;
    public $event_after;
    public $route_after=array();
    public $message_notify="";
    public $default_operation;
    public $trash_var="";
    public $default_value;
    public $plugins=array();
    public function __construct() {
     $dir    = PATH_TO_ENGINE.'/vendor/noistudio/noiframework/mongogrid/plugins/type/globalevents/';
    $plugins = scandir($dir);

    $i=0;
    while(isset($plugins[$i])){
     if(strlen($plugins[$i])>2){

         $newname=mb_strtolower($plugins[$i]);
         $this->plugins[count($this->plugins)]=$newname;

     }
     $i++;
    }
    }
    //выполнение операции перед показом данных
    public function executeEvent($operation){

      if(in_array($operation,$this->denied_access)){

       return false;
      }
    /*
     * TODO:переменная $operation меняет свое значение входе работы метода executeEvent
     */
    $this->trash_var=$this->default_operation;
    $res= $this->trash_var;
   // echo $res;

      $result=true;

      if(isset($this->event_before[$operation]) and is_array($this->event_before[$operation]) and (isset($_POST['act_'.$operation]) or $operation=="list") ){



        $result=call_user_func($this->event_before[$operation]['obj'].'::'.$this->event_before[$operation]['method'],$this->mg);

        }

         if($result==true){
      $result_operation=call_user_func($this->event[$operation]['class'].'::'.$this->event[$operation]['method'],$this->mg);

       if($result_operation==true){

           if(isset($this->event_after[$operation]) and is_array($this->event_after[$operation]) and isset($_POST['act_'.$operation])){

               call_user_func($this->event_after[$operation]['obj'].'::'.$this->event_after[$operation]['method'],$this->mg);


          }

       }
       }else {
           $this->mg->view->message_notify="Произошла ошибка";
           return false;
       }

       if(isset($this->route_after[$operation])){
       $this->mg->view->route=$this->route_after[$operation];
       $this->mg->view->rerender=true;
       }else {
       $this->mg->view->route="/".$this->default_operation."/1";
        $this->mg->view->rerender=false;
       }



       $this->executePlugins();
       return $result_operation;


    }
    public function executeEvent2($operation){



      if(in_array($operation,$this->denied_access)){

       return false;
      }


     if($operation=="create" and    in_array($operation, $this->available)){

      }else if($operation=="delete" and in_array($operation, $this->available_method)){

      }
      else if($operation=="update" and in_array($operation, $this->available)){

      }
     }
     private function executePlugins(){
       if(isset($this->plugins) and count($this->plugins)>0)
       foreach($this->plugins as $plugin){
           $tmp_class=  ucfirst($plugin)."Globalevent";
           $path="ext.mongogrid.plugins.type.globalevents.".$plugin.".".ucfirst($plugin)."Globalevent";
           yii::import($path);

           $tmp_plugin=new $tmp_class(array());
           $tmp_plugin->execute($this->mg);
       }
     }
     /*
      * запуск задач в фоновом режиме.
      */
     private function inBackground($path,$name){
         return false;
//     $client = new GearmanClient();
//     $client->addServer("127.0.0.1");
//
////$result = $client->do("reverse", "string");
//     $job=array('path'=>$path,'name'=>$name);
//     $client->addTaskBackground("plugins");
//
//     $client->runTasks();
     }
}


