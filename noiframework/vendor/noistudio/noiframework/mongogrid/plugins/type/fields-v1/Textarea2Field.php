<?php

yii::import("ext.mongogrid.core.PluginField");
class Textarea2Field extends PluginField{


  function __construct($field_name,$opt) {


      parent::__construct("textarea2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
   $template=Yii::app()->getController()->widget('ext.redactor.ImperaviRedactorWidget',array(
    'name'=>'field_'.$this->field_name,
    'value'=>$value,
    // Redactor options
    'options'=>array(),
),true);
  return $template;
  
  }
  public function setInput($value="",$mg) {
if(!isset($_POST['field_'.$this->field_name])){

   return false;
}
if(isset($_POST['field_'.$this->field_name])){
 $value=$_POST['field_'.$this->field_name];
}else {
  $value=$this->opt['default_value'];
}

return $value;
  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>
