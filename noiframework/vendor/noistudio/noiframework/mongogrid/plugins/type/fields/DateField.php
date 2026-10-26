<?php

namespace noicms\mongogrid\plugins\type\fields;

use MongoDate;
use noicms\mongogrid\core\PluginField;
class DateField extends PluginField{
   private $length=120;
   private $check_format='';

  function __construct($field_name,$opt) {


      parent::__construct("date",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  if($value==""){
  $value=$this->opt['default_value'];
  }
  if(is_object($value)){
  $value=date("Y-m-d",$value->sec);
 
  }
   $added="class='form-control input-lg'"; 
  $template='<input '.$added.' name="'.$this->getNameField().'"  type="date"  value="'.$value.'">';
  return $template;
  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}
   $yes="1";

 $start = new MongoDate(strtotime($_POST[$this->getNameField()]));
 return $start;
  }
  public function renderValue($value,$mg) {
 if(is_object($value)){
  $value=date("Y-m-d",$value->sec);
  
  }
  return $value;
  }
}
?>