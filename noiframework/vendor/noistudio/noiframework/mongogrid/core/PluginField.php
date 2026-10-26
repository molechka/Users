<?php
namespace noicms\mongogrid\core;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use NoiCore;
    abstract class PluginField
{
   public $name="";
   public $field_name;
   public $opt=array();
   public $visible=true;

   //отображение поля при сохранении
    abstract public function getInput($value,$mg);
   //обработка события сохранения в бд
    abstract public function setInput($value,$mg);
   //отображение поля в списке
    abstract public function renderValue($value,$mg);

   public function __construct($name,$field_name,$opt) {
     $this->name=$name;
     $this->field_name=$field_name;
      if(!isset($opt['default_value'])){
    $opt['default_value']="";
    }

     $this->opt=$opt;
   }
   public function afterEvent($mg){
       
   }
     public function getNameField(){

     $field_name=$this->opt['post_name_field']."".$this->field_name;
//     $tmp_explode=explode("_",$this->field_name);
//     if(isset($tmp_explode[0])){
//     $tmp_name=$tmp_explode[0];
//     }else {
//     $tmp_name=$this->field_name;
//     }
//     $field_name=str_replace("[n]","n_".$tmp_name,$field_name);
     return $field_name;

  }
   public function isVisible(){
       return $this->visible;
   }
    public function render($view,$data=array()){
 $data['plugin']=$this;
 $new_name_plugin=mb_strtolower($this->name);
 if(file_exists(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/".$new_name_plugin."/views/".$view.".php")){
 
  $return=NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/".$new_name_plugin."/views/".$view.".php",$data);
  return $return;
 }else  {
return "not found";
 }
}
}


?>