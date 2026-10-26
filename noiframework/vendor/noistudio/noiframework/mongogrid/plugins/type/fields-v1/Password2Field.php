<?php

yii::import("ext.mongogrid.core.PluginField");
class Password2Field extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("password2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $value='';
  $template="<input type='password' name='field_".$this->field_name."' ".$required." value='".$value."'><input type='password' name='field_".$this->field_name."_2' ".$required." value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {
   if(isset($_POST['field_'.$this->field_name]) and isset($_POST['field_'.$this->field_name."_2"])){
    if($_POST['field_'.$this->field_name]==$_POST['field_'.$this->field_name."_2"]){
       $value=hash('sha512',$_POST['field_'.$this->field_name]);
      
       return $value;
    }else {
        return false;
    }
   }
  
  

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>