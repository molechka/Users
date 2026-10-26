<?php

yii::import("ext.mongogrid.core.PluginField");
class Email2Field extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("email2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $template="<input type='email' name='field_".$this->field_name."' ".$required." value='".$value."'>";
  return $template;
 
  }
  public function setInput($value="",$mg) {
   if(filter_var($_POST['field_'.$this->field_name],FILTER_VALIDATE_EMAIL)){
 
    return $_POST['field_'.$this->field_name];
   }else {
       return false;
   }
 

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>