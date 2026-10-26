<?php
namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
class EmailField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("email",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  
  if($this->opt['required']=true){
  $required='required';
  }
    $added="class='form-control input-lg'";
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }  
  $template="<input ".$added." type='email' name='".$this->getNameField()."' ".$required." value='".$value."'>";
  return $template;
 
  }
  public function setInput($value="",$mg) {
   if(filter_var($_POST[''.$this->getNameField()],FILTER_VALIDATE_EMAIL)){
    return strtolower($_POST[''.$this->getNameField()]);  
   
   }else {
       return false;
   }
 

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>