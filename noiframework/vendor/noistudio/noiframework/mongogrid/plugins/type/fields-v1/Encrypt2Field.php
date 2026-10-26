<?php

yii::import("ext.mongogrid.core.PluginField");
class Encrypt2Field extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("encrypt2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {

        $key_forps=$this->opt['key'];
        If($mg->operations->default_operation=="update"){
        if(isset($this->opt['field']) and $this->opt['field']==1){
         $key_forps=$mg->status->old_result[$this->opt['key']];
        }
        if($value=="" and isset($mg->status->old_result[$this->field_name])){
        $value=$mg->status->old_result[$this->field_name];
        }
        if(strlen($value)>0){
        $tmp= GridStr::decode($value, $key_forps);
        $value=$tmp;
        }
        }
        
        $template=Yii::app()->getController()->widget('ext.redactor.ImperaviRedactorWidget',array(
    'name'=>'field_'.$this->field_name,
    'value'=>$value,
    // Redactor options
    'options'=>array(),
),true);
  return $template;
  }
  public function setInput($value="",$mg) {
  $key_forstr=$this->opt['key'];
  
  if(isset($this->opt['key']) and $this->opt['field']==1){
   $key_forstr=$mg->fields->row[$this->opt['key']];
   }

 $tmp=  GridStr::encode($_POST['field_'.$this->field_name], $key_forstr);
 $value=$tmp;
return $value;

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>