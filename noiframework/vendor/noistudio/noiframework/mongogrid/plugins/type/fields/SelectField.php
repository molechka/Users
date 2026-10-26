<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;
use noicms\mongogrid\system_core\MGQuery;
class SelectField extends PluginField{
  private $type="array";
  private $value_row="_id";
  private $data;
  private $id_data=array();
  private $isnull=0;
  function __construct($field_name,$opt) {
  if(isset($opt['isnull']) and $opt['isnull']==1){
      $this->isnull=1;
      }
     if(isset($opt['collection']) and isset($opt['condition']) and is_array($opt['condition']) and  isset($opt['select']) and is_array($opt['select'])){
      $this->type="db";
      if(isset($opt['value_row'])){
       $opt['select'][count($opt['select'])]=$opt['value_row'];
       $this->value_row=$opt['value_row'];
      }
      $opt['select'][count($opt['select'])]="_id";
      $result=  MGQuery::execute($opt['select'],  $opt['collection'], $opt['condition'], array('_id'=>-1), null,0);
      $this->data=array();
    
     

      if(isset($result[0]['_id'])){
          foreach($result as $row){
          if(isset($row[$opt['select'][0]]) and isset($row['_id'])){
          $value="";
          if($this->value_row=="_id"){
          $value=$row['_id']->__toString();
          }else {
          $value=$row[$this->value_row];
          }
          $this->data[count($this->data)]=array('value'=>$value,'title'=>$row[$opt['select'][0]]);
          $this->id_data[count($this->id_data)]=$value;
          }
          }
     
      }
     }
    
     if(isset($opt[0]['title']) and isset($opt[0]['value'])){
     $this->id_data=array();
     $this->data=$opt;
     $i=0;
      while(isset($opt[$i]['value'])){
 $this->id_data[count($this->id_data)]=$opt[$i]['value'];
$i++;

     }
     }
 if($this->isnull==1){
  $this->data[]=array('value'=>'null','title'=>'null');
  $this->id_data[]="null";
 }

      parent::__construct("select",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $added="class='form-control input-lg'";   
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