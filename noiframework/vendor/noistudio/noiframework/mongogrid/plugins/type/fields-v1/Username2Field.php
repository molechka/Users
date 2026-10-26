<?php

yii::import("ext.mongogrid.core.PluginField");
class Username2Field extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("username2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $template="<input type='text' name='field_".$this->field_name."' ".$required." value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {
     $allowed = array(".", "-", "_");

  if ( ctype_alnum( str_replace($allowed, '', $_POST['field_'.$this->field_name] ) ) ) {

return $_POST['field_'.$this->field_name] ;
  } else {
    $result_validate['status']=false;
    $result_validate['message_notify']="Поле ".$this->opt['label']." введено не верно";
    $result_validate['route']="";
    return false;
  }
  
  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>