<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
class ShoppaymentField extends PluginField{
   private $length=60;
   private $check_format='';
  public $data_array=array();
  function __construct($field_name,$opt) {


 $resultdir=scandir(YII_PLUGIN_PATH);
  $data_array=array();
  if(count($resultdir)>0){
  foreach($resultdir as $file){
  $tmp_file=str_replace('_shop',"",$file);
  if($tmp_file!=$file){
  $data_array[]=$file;
  }
  }
  $this->data_array=$data_array;
  }

      parent::__construct("shoppayment",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  if($value==""){
  $value=$this->opt['default_value'];
  }
  $options="";
  if(isset($this->data_array) and count($this->data_array)>0){
  foreach($this->data_array as $option){
  $selected="";
  if($option==$value){
  $selected="selected";
  }
  $options.="<option ".$selected." value='".$option."'>".$option."</option>";
  }
  }
     $added="";
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }  
  $template="<select ".$added." name='".$this->getNameField()."'>".$options."</select>";
 
  return $template;
  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}
   $yes="1";

  if(in_array($_POST[$this->getNameField()],$this->data_array)){
   return $_POST[$this->getNameField()];
  }
        else {

        return false;
        }

return false;;
  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>