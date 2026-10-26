<?php

namespace noicms\mongogrid\plugins\type\fields;

use Yii;
use noicms\mongogrid\core\PluginField;
class EncryptField extends PluginField{

  function __construct($field_name,$opt) {


      parent::__construct("encrypt",$field_name,$opt);
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
    'name'=>$this->getNameField(),
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

 $tmp=  GridStr::encode($_POST[''.$this->getNameField()], $key_forstr);
 $value=$tmp;
return $value;

  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>