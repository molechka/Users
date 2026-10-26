<?php

yii::import("ext.mongogrid.core.PluginField");
class Int2Field extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("int2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $template="<input type='number' name='field_".$this->field_name."' ".$required." value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {
   $value=(int)$value;
   return $value;

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>