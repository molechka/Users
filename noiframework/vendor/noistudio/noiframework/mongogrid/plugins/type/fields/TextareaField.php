<?php

namespace noicms\mongogrid\plugins\type\fields;
use NoiCore;
use Yii;
use noicms\mongogrid\core\PluginField;
class TextareaField extends PluginField{


  function __construct($field_name,$opt) {


      parent::__construct("textarea",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
   $added="class='form-control overflow'";      
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control overflow'";    
  }
   $template="<textarea ".$added." name='".$this->getNameField()."'>".$value."</textarea>";
  return $template;
  
  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}
if(isset($_POST[$this->getNameField()])){
 $value=strip_tags($_POST[$this->getNameField()]);
}else {
  $value=$this->opt['default_value'];
}

return $value;
  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>