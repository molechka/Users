<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
class IntField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("int",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $added=""; 
   if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }
  $template="<input ".$added." type='number' pattern='[0-9]*'  name='".$this->getNameField()."'  value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {
   if(!isset($_POST[$this->getNameField()])){
    $_POST[$this->getNameField()]=0;
   }
    $value=(int)$_POST[$this->getNameField()];
   return $value;

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>