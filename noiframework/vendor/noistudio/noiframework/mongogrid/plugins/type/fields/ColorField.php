<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
class ColorField extends PluginField{
   private $length=60;
   private $check_format='';

  function __construct($field_name,$opt) {



      parent::__construct("color",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  if($value==""){
  $value=$this->opt['default_value'];
  }
  $template='<input name="'.$this->getNameField().'" type="color"   value="'.$value.'">';
  return $template;
  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}else {
 return $_POST[$this->getNameField()];
}
   $yes="1";

 
  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>