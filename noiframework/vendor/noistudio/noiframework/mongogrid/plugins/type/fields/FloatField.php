<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
class FloatField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("float",$field_name,$opt);
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
  $template="<input ".$added." type='text' name='".$this->getNameField()."' ".$required." value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {
    if(is_numeric($_POST[$this->getNameField()])){
    $value=(float)$_POST[$this->getNameField()];
   return $value;

    }else {
       return false;
    }
  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>