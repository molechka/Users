<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
class HiddenField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("hidden",$field_name,$opt);
      $this->visible=false;
  }

  public function getInput($value="",$mg) {

  return "";
  }
  public function setInput($value="",$mg) {
   return $this->opt['default_value'];

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>