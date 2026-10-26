<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
class UsernameField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("username",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
    $added="";
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }    
  $template="<input ".$added." type='text' name='".$this->getNameField()."' ".$required." value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {
     $allowed = array(".", "-", "_");

  if ( strlen($_POST[''.$this->getNameField()])>=3  and strlen($_POST[''.$this->getNameField()])<16 and ctype_alnum( str_replace($allowed, '', $_POST[''.$this->getNameField()] ) ) ) {

return strtolower($_POST[''.$this->getNameField()]) ;
  } else {
    $_POST['error_username']="1";
     $_POST['main_form_error']="Поле логин заполнено неверно,минимум 3 символа,максимум 15 символов";

    $this->opt['label']="";
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