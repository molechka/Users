<?php

class Plugins{
    private function get_value($route,$start,$increment=0){
    if(!is_array($route)){
     return 0;
    }
     $new2_key= $start+$increment;
      $val2=0;
      if(isset($route[$new2_key])){
      $val2=$route[$new2_key];
      }
      return $val2;
    }
     private function find_frontend_controller($name_plugin,$route,&$cur,$iswidget=0,$widget=array()){
 $result=array();
   if(isset($name_plugin) and isset($route) and is_array($route))
     {

     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/config.php")){
     $array_classes=array();
     if(count($route)>0){
     foreach($route as $key=>$r){
     $tmp_array2=array('key'=>$key,'class'=>ucfirst($r)."".ucfirst($name_plugin)."FCP");
      $array_classes[]=$tmp_array2;
     $tmp_array=array('key'=>$key,'class'=>ucfirst($r)."".ucfirst($name_plugin)."FrontendControllerPlugin");
     $array_classes[]=$tmp_array;
     }
     }
     $array_classes[]=array('class'=>ucfirst($name_plugin)."FCP");;
     $array_classes[]=array('class'=>ucfirst($name_plugin)."FrontendControllerPlugin");;

     if(is_array($array_classes) and count($array_classes)>0){
     foreach($array_classes as $class){
     if(isset($class['class'])){

     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/frontend/".$class['class'].".php"))
     {
      if(!class_exists("CoreFrontendControllerPlugin")){
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreFrontendControllerPlugin.php";
      }
require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/frontend/".$class['class'].".php";

      $result['class']=new  $class['class']($route,$cur);
      if($iswidget==1){
   $result['class']->iswidget=1;
    $result['class']->widget=$widget;
    }
    
 
      if(isset($class['key'])){
      $tmp_key=$class['key']+1;

      if(isset($route[$tmp_key])){
 
      if(method_exists($result['class'],'action'.$route[$tmp_key])){
 
      $current_value="";
      $new_tmp_key=$tmp_key+1;

      if(isset($route[$new_tmp_key])){
      $current_value=$route[$new_tmp_key];
      }

      $method = new ReflectionMethod($result['class'],'action'.$route[$tmp_key]);

      $num = $method->getNumberOfParameters();
 
 
      $method='action'.$route[$tmp_key];
       if($num==1 or $num==0){
      $result['result']=$result['class']->$method($current_value);
      }else if($num==2) {
 
      $result['result']=$result['class']->$method($current_value,$this->get_value($route, $new_tmp_key,1));
      }else if($num==3){

      $result['result']=$result['class']->$method($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2));
      }else if($num==4){

      $result['result']=$result['class']->$method($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2),$this->get_value($route, $new_tmp_key,3));
      }else if($num==5){
        $result['result']=$result['class']->$method($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2),$this->get_value($route, $new_tmp_key,3),$this->get_value($route, $new_tmp_key,4));
      }
      return $result;
      }else if(method_exists($result['class'], 'actionIndex')){
        
           
      $current_value="";
      $new_tmp_key=$tmp_key;
      if(isset($route[$new_tmp_key])){
      $current_value=$route[$new_tmp_key];
      }

      $method='actionIndex';
        $method = new ReflectionMethod($result['class'],$method);

      $num = $method->getNumberOfParameters();


       if($num==1 or $num==0){
      $result['result']=$result['class']->actionIndex($current_value);
      }else if($num==2) {

      $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, $new_tmp_key,1));
      }else if($num==3){

      $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2));
      }else if($num==4){

      $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2),$this->get_value($route, $new_tmp_key,3));
      }else if($num==5){
        $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, $new_tmp_key,1),$this->get_value($route, $new_tmp_key,2),$this->get_value($route, $new_tmp_key,3),$this->get_value($route, $new_tmp_key,4));
      }

      return $result;
      }
      }
      }else {
           include YII_PLUGIN_PATH."".$name_plugin."/config.php";

     if(isset($route[0]) and $route[0]==$plugin_config['route']){
      $count_route=count($route);
      unset($route[0]);
      if($count_route>1){
      $route=  array_values($route);
      }else {
      $route=array();
      }
     }
      if(isset($route[0])){
        if(method_exists($result['class'],'action'.$route[0])){
      $current_value="";

      if(isset($route[1])){
      $current_value=$route[1];
      }
      $method='action'.$route[0];
     $result['result']=$result['class']->$method($current_value);
      return $result;
      }
      }
      if(method_exists($result['class'],"actionIndex")){
      $current_value="";
      if(isset($route[0])){
      $current_value=$route[0];
      }

      $method="actionIndex";
     
        $method = new ReflectionMethod($result['class'],$method);

      $num = $method->getNumberOfParameters();
     


       if($num==1 or $num==0){
      $result['result']=$result['class']->actionIndex($current_value);
      }else if($num==2) {

      $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, 0,1));
      }else if($num==3){

      $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, 0,1),$this->get_value($route, 0,2));
      }else if($num==4){

      $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, 0,1),$this->get_value($route, 0,2),$this->get_value($route, 0,3));
      }else if($num==5){
        $result['result']=$result['class']->actionIndex($current_value,$this->get_value($route, 0,1),$this->get_value($route, 0,2),$this->get_value($route, 0,3),$this->get_value($route, 0,4));
      }
   
      return $result;
      }
      }

   //  echo $class['class'];
  //  exit;

     }
     }
     }
     }
     }
     }

     }
    public function run($name,$route_url,$iswidget=0,$widget=array(),$cur){
    $route=explode("/",$route_url);


    if(is_array($route) and count($route)>0){
    foreach($route as $key=>$part_route){
      $route[$key]=str_replace(".html","",$route[$key]);
    }
    }

    // yii::setPathOfAlias('tmp_render_site_plugin', YII_PLUGIN_PATH);
    // yii::import("tmp_render_site_plugin.".$name.".controllers.frontend.*");
     $result_action="";

     $result_action=  $this->find_frontend_controller(mb_strtolower($name), $route, $cur, $iswidget, $widget);


 if(isset($result_action) and isset($result_action['class']) and is_string($result_action['result'])){
     if(isset($result_action['result']) and strlen($result_action['result'])>0){

   if(method_exists($result_action['class'], 'setData') and method_exists($result_action['class'], 'setView')){


   $result_action['class']->setData(array('plugin'=>$result_action['result']));
   $result_action['class']->setView('plugin', "run");
   }
   if(method_exists($result_action['class'],"getResource")){
   $result_action['result']=$result_action['class']->getResource()."".$result_action['result'];
   }
   return $result_action['result'];
     }
 }
    }
    
     public function getInstalledPlugins(){
    $site_data=NoiCore::app()->site_data;
    $result_array=array();
    if(isset($site_data['theme_components']['plugins']['available'])){
     $result_array=$site_data['theme_components']['plugins']['available'];
    }
    return $result_array;
  }
  public function runController($classname){
       if($this->isControllerName($classname)){
       $new_classname=$this->filterControllerName($classname);
       preg_match_all('((?:^|[A-Z])[^A-Z]*)', $new_classname, $matches);
      if(isset($matches[0]) and count($matches[0])>0){
       $count_ll=count($matches[0]);
       $count_ll--;

       if(in_array(strtolower($matches[0][$count_ll]),$this->getInstalledPlugins())){
       $name_plugin=strtolower($matches[0][$count_ll]);

       if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/frontend/".$classname.".php"))
     {
      if(!class_exists("CoreFrontendControllerPlugin")){
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreFrontendControllerPlugin.php";
      }
require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/frontend/".$classname.".php";
$new_class=new $classname(array(),$this);
     if(is_object($new_class)){
       return $new_class;
     }else {
         return false;
     }
     }

       }
      }

       exit;
       }else {
           return false;
       }
    }

       public function filterControllerName($classname){
     $pos      = strripos($classname, "FCP");
     if(!is_bool($pos)){
      $classname=str_replace("FCP","",$classname);
      return $classname;
     }else {
     $pos      = strripos($classname, "FrontendControllerPlugin");
     if(!is_bool($pos)){
         $classname=str_replace("FrontendControllerPlugin","",$classname);
       return $classname;
     }else {
         return false;
     }
     }
    }
    public function isControllerName($classname){
     $pos      = strripos($classname, "FCP");
     if(!is_bool($pos)){
      
      return true;
     }else {
     $pos      = strripos($classname, "FrontendControllerPlugin");
     if(!is_bool($pos)){
       return true;
     }else {
         return false;
     }
     }
    }
}

