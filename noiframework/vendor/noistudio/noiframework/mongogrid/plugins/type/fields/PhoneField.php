<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
class PhoneField extends PluginField{
   private $length=60;
   private $check_format='';

  function __construct($field_name,$opt) {



      parent::__construct("phone",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  if($value==""){
  $value=$this->opt['default_value'];
  }
  $added=""; 
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }
  $template='<input '.$added.' name="'.$this->getNameField().'" type="text"   value="'.$value.'">';
  return $template;
  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}
$value=$_POST[$this->getNameField()];
   $yes="1";

//eliminate every char except 0-9
$justNums = preg_replace("/[^0-9]/", '', $value);

//eliminate leading 1 if its there
if (strlen($justNums) == 11) $justNums = preg_replace("/^1/", '',$justNums);

//if we have 10 digits left, it's probably valid.
if (strlen($justNums) == 10) $isPhoneNum = true;

//return $isPhoneNum;
return $value;
  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>