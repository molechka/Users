<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
class FinancepasswordField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("financepassword",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $value='';
  $template="<input type='password' name='".$this->getNameField()."' ".$required." value='".$value."'><input type='password' name='".$this->getNameField()."_2' ".$required." value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {
    
   if(isset($_POST[''.$this->getNameField()])){
    $_POST[''.$this->getNameField()."_2"]=$_POST[''.$this->getNameField()];
    if(strlen($_POST[''.$this->getNameField()])>=6  and $_POST[''.$this->getNameField()]==$_POST[''.$this->getNameField()."_2"]){
       $value=hash('sha512',$_POST[''.$this->getNameField()]);
      
       return $value;
    }else {
         $_POST['error_finance_password']="1";
          $_POST['main_form_error']="Поле  финансовый пароль заполнено неверно,минимум 6 символов";
        return false;
    }
   }
  
  

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>