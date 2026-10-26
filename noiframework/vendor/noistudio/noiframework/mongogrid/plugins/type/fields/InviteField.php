<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
use noicms\mongogrid\system_core\MGQuery;
class InviteField extends PluginField{

  /*
   * array(
   * 'collection'=>'cms_user',
   * 'select'=>''
   * )
   */
  function __construct($field_name,$opt) {


      parent::__construct("invite",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  if($this->opt['required']=true){
  $required='required';
  }
  $template="<input type='text' name='".$this->getNameField()."' ".$required." value='".$value."'>";
  return $template;
  }
  public function setInput($value="",$mg) {

   if(!isset($_POST[$this->getNameField()])){
    $_POST[$this->getNameField()]="";
    //  return false;
   }
   if(strlen($_POST[$this->getNameField()])==0){
   $_POST[$this->getNameField()]="";
    //  return false;
   }
   if(!isset($this->opt['select'])){
       return false;

   }
   if(!isset($this->opt['collection'])){
       return false;
   }

   $condition=array($this->opt['select'][0]=>$_POST[$this->getNameField()]);
   $result=MGQuery::execute2($this->opt['select'], $this->opt['collection'], $condition);

   if(isset($this->opt['site_id'])){
   $count=MGQuery::count($this->opt['collection'], array('site_id'=>$this->opt['site_id']));
   }else {
  $count=MGQuery::count($this->opt['collection'], array());
   }


   if(isset($result[0][$this->opt['select'][0]])){
    $value=$_POST[$this->getNameField()];
       return $value;
   }else {
       if($count==0){
        return $value;
       }
//      $result=MGQuery::execute2($this->opt['select'], $this->opt['collection'], array('isadmin'=>1));
//
//       if(isset($result[0][$this->opt['select'][0]])){
//       $value=$_POST[$this->getNameField()];
//       return $value;
//       }
       return false;
   }



  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>