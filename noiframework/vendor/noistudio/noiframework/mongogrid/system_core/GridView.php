<?php
 namespace noicms\mongogrid\system_core;
 use NoiCore;
// get html dom from string
use noicms\mongogrid\GridConf;
include  PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/core/simple_html_dom.php";
function str_get_html($str, $lowercase=true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
{
    include  PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/core/simple_html_dom.php";
	$dom = new \simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
	if (empty($str) || strlen($str) > MAX_FILE_SIZE)
	{
		$dom->clear();
		return false;
	}
	$dom->load($str, $lowercase, $stripRN);
	return $dom;
}

class GridView{
    public $rerender;
    public $message_notify;
    public $available=array(
        "list"=>"{ext}/mongogrid/views/standart/list.php",
        "create"=>"{ext}/mongogrid/views/standart/create.php",
        "update"=>"{ext}/mongogrid/views/standart/update.php",
        "delete"=>"{ext}/mongogrid/views/standart/delete.php",
        'notify'=>"{ext}/mongogrid/views/standart/notify.php",
         'clone'=>"{ext}/mongogrid/views/standart/clone.php",
        'show'=>'{ext}/mongogrid/views/standart/show.php',
        );
    public $route;
    public $mg;
    public $tmp_var=array();
    public $tmp_url;
    public $current_html="";
    public $option=array();

    public function render(){
  
 foreach($this->available as $key=>$tmp_path){
  $this->available[$key]=str_replace("{ext}",PATH_TO_ENGINE."/vendor/noicms",$tmp_path);

 }

    $current=$this->tmp_var[1];
    if(isset($this->available[$current])){
     $data['mg']=$this->mg;
     $data['option']=$this->option;
 
     if(count($this->option)>0){
     foreach($this->option as $name_key=>$key){
     $data[$name_key]=$key;
     }
     }
     $tmp_explode1=str_replace("/","",$this->available["notify"]);
     $tmp_explode2=str_replace("/","",$this->available[$current]);
  
     if($tmp_explode1!=$this->available["notify"]){

      $view=$this->preRender(NoiCore::app()->render($this->available["notify"], $data));


     }else {
      
     $view=$this->preRender(NoiCore::app()->render($this->available["notify"], $data));
     }
     if($tmp_explode2!=$this->available[$current]){
       $view .=$this->preRender(NoiCore::app()->render($this->available[$current], $data));
     }else {
     $view .=$this->preRender(NoiCore::app()->render($this->available[$current], $data));
     }
    
     $view=$this->prePlugin($view);

     if(isset($_GET['ajaxx'])){

     if( $_GET['ajax']==1 and $this->mg->status->status==0){
     if(isset($this->message_notify) and $this->message_notify!=null and strlen($this->message_notify)>0){
    $arr = array('message' => $this->message_notify);

 $view=json_encode($arr);
     }
     }
    }

      return $view;
    }else {
        return "404 error";
    }

    }
    private function prePlugin($html){
    $this->mg->view->current_html=$html;
  
    if(isset($_GET['plugin']) and isset($_GET['params'])){
 $name_plugin=$_GET['plugin'];

 $params=  unserialize($_GET['params']);
 if(count($params)>0){
 $upname_plugin=ucfirst($name_plugin);

 if (file_exists(YiiBase::getPathOfAlias('vendor.noicms.mongogrid.plugins.type.events.').'/'.$name_plugin.'/'.$upname_plugin."Event.php")) {
     yii::import("vendor.noicms.mongogrid.plugins.type.events.".$name_plugin.".".$upname_plugin."Event");
     $event_plugin_classname=$upname_plugin."Event";

     $addedplugin=new $event_plugin_classname($params);
     $html=$addedplugin->execute($this->mg);
     }
 }
}
 
return $html;
    }
    private function preRender($html){
     if(strlen($html)>0){
        
    $rend = str_get_html($html);
 

    foreach($rend->find('mgplugin') as $element) { //выборка всех тегов img на странице
       $params=array();
       $name_plugin=$element->innertext;
       $upname=ucfirst($name_plugin);
        $src_plugin="<mgplugin";
        foreach($element->attr as $attr=>$value){
           $src_plugin=$src_plugin.' '.$attr.'="'.$value.'"';
           $params[$attr]=$value;

        }
        $src_plugin=$src_plugin.">".$name_plugin."</mgplugin>";
       
        require_once(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/views/".$name_plugin."/".ucfirst($name_plugin)."View.php");
        $class_plugin=ucfirst($name_plugin)."View";
        $params['mg']=$this->mg;
        $plugin=new $class_plugin($params);
        $html_plugin=$plugin->render();

        $html=  str_replace($src_plugin, $html_plugin, $html);
     
}
     }else {
        return $html;
     }
  return $html;
    }
    public function setRoute($route,$version=2){

 
      $conf=new GridConf();
      $rules_route=$conf->rules_route;
      $arr_search=array('url','short_name','route');
 $tmp_text=  str_replace("?", "", $this->mg->url);
$fix_symbol="?";
 if($tmp_text!=$this->mg->url){
 $fix_symbol="&";
 $rules_route=  str_replace("?", "&", $rules_route);
 }
      $arr_replace=array($this->mg->url,$this->mg->get_name_short."".$this->mg->name_short,$route);
      $newroute = str_replace($arr_search, $arr_replace, $rules_route);

      if($version==1){
      $newroute=str_replace($this->mg->url."".$fix_symbol,"",$newroute);
      }
     return $newroute;
     }
}
?>