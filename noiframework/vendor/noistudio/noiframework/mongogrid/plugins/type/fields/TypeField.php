<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
class TypeField extends PluginField{
   private $length=60;
   private $check_format='';
   private $types=array();
   private $data=array();
   private $id_data=array();

  function __construct($field_name,$opt) {

      $results_dir=scandir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields");
      if(isset($results_dir) and count($results_dir)>0){
       foreach($results_dir as $dir){
       $tmp_str=str_replace(".php","",$dir);
        $value=$dir;
       $value=$value;
    $value=str_replace("Field.php","",$value);
    $value=  mb_strtolower($value);
       if($tmp_str!=$dir){
       $this->types[]=array('value'=>$value,'title'=>$dir);
       $this->id_data[]=$value;
       }
       }
      }

      parent::__construct("type",$field_name,$opt);
  }

 public function getInput($value="",$mg) {
   $this->data=$this->types;
     $added="";
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }    
  $template="<select ".$added." name='".$this->getNameField()."'>";
 $i=0;
  if(isset($this->data) and count($this->data)>0){
    while(isset($this->data[$i]['value'])){
    $row=$this->data[$i];
    $selected="";

    if($row['value']==$value){
     $selected="selected";
    }
    $tmp=$row['value'];
    $template.='<option '.$selected." value='".$tmp."'>".$row['title']."</option>";
    $i++;
    }
  }

  $template.="</select>";
  return $template;
  }
  public function setInput($value="",$mg) {
 if(!isset($_POST[''.$this->getNameField()])){
    return false;
 }
 $this->data=$this->types;

  if(in_array($_POST[''.$this->getNameField()],$this->id_data)){
    $key_val=array_search($_POST[''.$this->getNameField()], $this->id_data);
    $mg->fields->row[$this->field_name."_title"]=$this->data[$key_val]['title'];
   
    return $_POST[$this->getNameField()];
  }
  if($this->opt['required']==true){
     return false;
  }else {
   return $this->opt['default'];
  }


  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>