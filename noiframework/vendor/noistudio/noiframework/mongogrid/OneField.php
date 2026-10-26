<?php
namespace noicms\mongogrid;

use noicms\mongogrid\system_core\GridOperation;
class OneField{
    public $field_start_name;
    public $plugins;
    public $current_plugin;
    public $operations;
    public $current_name="";
    public function init($name_field,$type,$opt=array()){
    $dir    = PATH_TO_ENGINE.'/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/';
    $plugins = scandir($dir);

    $i=0;
    $this->current_name=$name_field;
    $this->operations=new GridOperation();
    while(isset($plugins[$i])){
     if(strlen($plugins[$i])>2){
         $newname=  str_replace("Field.php", "", $plugins[$i]);
         $newname=mb_strtolower($newname);
         $this->plugins[count($this->plugins)]=$newname;
     }
     $i++;
    }

   $conf=new GridConf();

   $this->field_start_name=$conf->name_field;
   $opt['post_name_field']=$this->field_start_name;
   if(in_array($type,$this->plugins)){
    require_once (PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/".ucfirst($type)."Field.php");
   $classname="noicms\\mongogrid\\plugins\\type\\fields\\".ucfirst($type)."Field";
  // yii::import("ext.mongogrid.plugins.type.fields.".$classname);
   $this->current_plugin=new $classname($name_field,$opt);
   }
    }
    public function getName(){
         
      return $this->field_start_name."".$this->current_name;
    }
    public function getInput($value=""){
     return $this->current_plugin->getInput($value,$this);
    }
    public function setInput($value=""){
     return $this->current_plugin->setInput($value,$this);
    }
    public function showInput($value){
     return $this->current_plugin->renderValue($value,$this);
    }
}
?>