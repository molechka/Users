<?php

yii::import("ext.mongogrid.core.PluginField");
class Hidden2Field extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("hidden2",$field_name,$opt);
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