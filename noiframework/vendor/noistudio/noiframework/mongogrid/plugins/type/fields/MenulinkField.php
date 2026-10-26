<?php

namespace noicms\mongogrid\plugins\type\fields;

 
use noicms\mongogrid\core\PluginField;
class MenulinkField extends PluginField{
   private $length=60;
   private $check_format='';

  function __construct($field_name,$opt) {



      parent::__construct("menulink",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  if($value==""){
  $value=$this->opt['default_value'];
  }
  if(isset($this->opt['site'])){
  $template=$this->render("show",array('value'=>$value,'site'=>$this->opt['site']));
  }else {
  $template="";
  }
  return $template;
  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}else {
 return $_POST[$this->getNameField()];
}
   $yes="1";


  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>