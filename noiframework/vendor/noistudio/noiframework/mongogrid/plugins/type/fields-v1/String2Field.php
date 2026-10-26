<?php

yii::import("ext.mongogrid.core.PluginField");
class String2Field extends PluginField{
   private $length=60;
   private $check_format='';

  function __construct($field_name,$opt) {

      if(isset($opt['length']) and $opt['length']>0){
       $this->length=$opt['length'];
      }
      $this->check_format="/^[a-zA-Zаеё-яАЕЁ-Я0-9_]{0,".$this->length."}$/";

      parent::__construct("string2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $template='<input name="field_'.$this->field_name.'" type="text" maxlength="'.$this->length.'" value="'.$value.'"';
  return $template;
  }
  public function setInput($value="",$mg) {
if(!isset($_POST['field_'.$this->field_name])){
  
   return false;
}
   
  if (preg_match($this->check_format, $_POST['field_'.$this->field_name])) {

   if(strlen($_POST['field_'.$this->field_name])<=$this->length){
       return $_POST['field_'.$this->field_name];
   }else {
       return false;
   }
      
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
