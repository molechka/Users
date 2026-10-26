<?php
namespace noicms\mongogrid\plugins\type\fields;

use Yii;
use noicms\mongogrid\core\PluginField;
class FroalaField extends PluginField{


  function __construct($field_name,$opt) {



      parent::__construct("froala",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
 if(!isset(Yii::$app->params['type_run'])){
  Yii::$app->params['type_run']="normal";
 }
 $template=' <textarea class="froala" name="'.$this->getNameField().'" rows="10">'.$value.'</textarea>';
  return $template;

  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}
if(isset($_POST[$this->getNameField()])){

 $value=$_POST[$this->getNameField()];
 $value=str_replace("http://noibiz.com/tmp","/tmp",$value);
 $value=str_replace("http://noibiz.com/themes","/themes",$value);
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