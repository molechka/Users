<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
class PasswordField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("password",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
 $added="class='form-control overflow'";       
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $value='';
 // $template="<input ".$added." type='password' name='".$this->getNameField()."' ".$required." value='".$value."'><br><input ".$added." type='password' name='".$this->getNameField()."_2' ".$required." value='".$value."'>";
   $template="<input ".$added." type='text' name='".$this->getNameField()."' ".$required." value='".$value."'>";

  return $template;
  }
  public function setInput($value="",$mg) {

   if(isset($_POST[''.$this->getNameField()])){
   
    $_POST[''.$this->getNameField()."_2"]=$_POST[''.$this->getNameField()];
    if(strlen($_POST[''.$this->getNameField()])>=1  and $_POST[''.$this->getNameField()]==$_POST[''.$this->getNameField()."_2"]){
       $value=hash('sha512',$_POST[''.$this->getNameField()]);
 
       return $value;
    }else {
         $_POST['main_form_error']="Поле пароль заполнено неверно,минимум 6 символов";
         $_POST['error_password']="1";
        return false;
    }
   }



  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>