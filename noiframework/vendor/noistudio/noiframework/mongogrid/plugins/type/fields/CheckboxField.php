<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
class CheckboxField extends PluginField{


  function __construct($field_name,$opt) {



      parent::__construct("checkbox",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  if($value==""){
  $value=$this->opt['default_value'];
  }
  $checked=0;
  if($value==1){
  $checked="checked";
  }
  $template='<input name="'.$this->getNameField().'" '.$checked.' type="checkbox"  value="1">';
  return $template;
  }
  public function setInput($value="",$mg) {
  
if(!isset($_POST[$this->getNameField()])){

   return 0;
}else {
    return 1;
}
 




  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>