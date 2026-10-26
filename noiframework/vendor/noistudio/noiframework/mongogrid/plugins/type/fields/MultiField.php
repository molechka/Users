<?php

namespace noicms\mongogrid\plugins\type\fields;
use yii;
use NoiCore;
use noicms\mongogrid\core\PluginField;
class MultiField extends PluginField{
  public $fields=array();
  public $plugins=array();
  public $n_field="";
    public function __construct( $field_name, $opt) {
        $strlen=strlen($field_name)-1;
        $one_f=$field_name[rand(0, $strlen)];
        $two_f=$field_name[rand(0, $strlen)];
        $three_f=$field_name[rand(0, $strlen)];
        $this->n_field=$one_f."".$two_f."".$three_f;

        parent::__construct('multi', $field_name, $opt);
              $dir    = PATH_TO_ENGINE.'/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/';
    $plugins = scandir($dir);

    $i=0;

    while(isset($plugins[$i])){
     if(strlen($plugins[$i])>2){
         $newname=  str_replace("Field.php", "", $plugins[$i]);
         $newname=mb_strtolower($newname);
         $this->plugins[count($this->plugins)]=$newname;
     }
     $i++;
    }

    }
    public function afterEvent($mg) {
        parent::afterEvent($mg);
    }
  public function getInput($value,$mg) {
 
  $result_html="";

  if(is_array($this->opt['fields']) and count($this->opt['fields'])>0){
  $result_html='<div id="sample_field_'.$this->getNameField().'" style="display:none;">';

  foreach($this->opt['fields'] as $name_field=>$field){
  $type=$field['type'];


   if($type!="mult111i"){

  if(in_array($type,$this->plugins)){


   $classname="noicms\\mongogrid\\plugins\\type\\fields\\".ucfirst($type)."Field";
//   require_once $_SERVER['DOCUMENT_ROOT']."".NOIPRODUCT_FOLDER."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/".$classname.".php";

   // yii::import("ext.mongogrid.plugins.type.fields.".$classname);
    /*
     *   $plugin_opt=$included_opt;
     $plugin_opt['label']=$label;
    $plugin_opt['required']=$required;
    $plugin_opt['unique']=$unique;
     */
    $label=$name_field;
    if(isset($field['label'])){
    $label=$field['label'];
    }

    $plugin_opt=array('label'=>$label);

    if(isset($field['opt'])){
    $included_opt=$field['opt'];
    }else {
    $included_opt=array();
    }
    if(isset($this->opt['id_site'])){
    $included_opt['id_site']=$this->opt['id_site'];
    
    }
    if(isset($this->opt['site'])){
    $included_opt['site']=$this->opt['site'];
    
    }

    if(isset($included_opt) and is_array($included_opt) and count($included_opt)>0){
     foreach($included_opt as $key => $values){
       $plugin_opt[$key]=$values;
     }
    }
    //$classsname="noicms\\mongogrid\\plugins\\type\\fields\\".$classname;
    $plugin_opt['post_name_field']=$this->opt['post_name_field'];
    $included_opt['plugin']=new $classname($this->field_name."_".$name_field."_".$this->n_field."",$plugin_opt);
    $pl_included_field=$included_opt['plugin']->getInput("",$mg);
     $pl_included_field=str_replace("required","",$pl_included_field);
    $result_html.="<p>".$label.":".$pl_included_field."</p>";
//      if($name_field=="vars"){
//   echo  $result_html;
//   exit;
//    }

if($plugin_opt['label']){
  $included_opt['label']=$plugin_opt['label'];
}
    $this->fields[$name_field]=$included_opt;
  }
  }
  }
   $i=0;
   $forinsert="";
   if(isset($value) and is_array($value) and count($value)>0){
 
    foreach($value as $keyvv=>$vv){

    if(isset($vv) and is_array($vv) and count($vv)>0){
     $forinsert.="<p  id='dinamic_row_".$this->n_field."_".$keyvv."'>";
     foreach($vv as $subvkey=>$subval){


     if(isset($this->fields[$subvkey]['label']) and isset($this->fields[$subvkey]['plugin'])){
      $label=$this->fields[$subvkey]['label'];
      $render_subval=  $this->fields[$subvkey]['plugin']->getInput($subval,$mg);
      $render_subval=str_replace("required","",$render_subval);
      
      $render_subval=str_replace($this->n_field,$keyvv,$render_subval);
      $forinsert.="".$label.":".$render_subval."<br>";

    
     }
     }
     $forinsert.="<a  href='#' style='color:red;' class='delete_row_".$this->n_field."' data-dynamic='".$this->n_field."'  data-idn='".$keyvv."'>[x]</a></p>";
    }
  $i++;
    }

   }
   $result_html.="</div><div class='forinsert_".$this->getNameField()."'>".$forinsert."</div><a id='fastadd_".$this->getNameField()."'  href='javascript:fast_add_".$this->getNameField()."();'>".NoiCore::app()->lang('multi_add')."</a><br><input type='checkbox' value='1' name='".$this->getNameField()."_clear'>Изменить";

   $result_html.="<script>"."var i_".$this->getNameField()."=".$i.";var content_".$this->getNameField()."=$('#sample_field_".$this->getNameField()."').html();"
          . ""
           . " function fast_add_".$this->getNameField()."(){"
           . ""
           ."var newinput=content_".$this->getNameField().";"

          . "newinput=replaceAll".$this->getNameField()."('".$this->n_field."',i_".$this->getNameField().",newinput);"
          . "$('.forinsert_".$this->getNameField()."').append(newinput);"
          . "i_".$this->getNameField()."++;"
          . "return false;"
           . "}"
           . "  function replaceAll".$this->getNameField()."(find, replace, str)
    {
      while( str.indexOf(find) > -1)
      {
        str = str.replace(find, replace);
      }
     return str;
    } "
           ."function new_sort".$this->getNameField()."(dynamic,idn)"
           . "{"
           . "var nidn=parseInt(idn)+1;"
           ."i_".$this->getNameField()."=i_".$this->getNameField()."-1;"
          .  "var count_all=i_".$this->getNameField().";"
           .""
           . "var temp_name='dinamic_row_'+dynamic+'_';"
           . "var start_pos=nidn;"
           . "var status_while=true;"
           . "while(status_while){"
           .""
           ." if($('#'+temp_name+''+start_pos+' input').length>0){"

           ."var temp_global_name=temp_name+''+start_pos;"
           ."var new_pos=start_pos-1;"

           ."temp_global_name=replaceAll".$this->getNameField()."(start_pos,new_pos,temp_global_name);"
           ."$('#'+temp_name+''+start_pos+' input').each(function() {"
           ."var temp_el_name=$(this).attr('name');"
           ."temp_el_name=replaceAll".$this->getNameField()."(start_pos,new_pos,temp_el_name);"
           ."$(this).attr('name',temp_el_name);"
           ."});"

           ."$('#'+temp_name+''+start_pos+'').attr('id',temp_global_name);"
           ."start_pos=start_pos+1;"
           ."}else {"
           ."status_while=false;"
           ."}"
           . "}"
           . "}"
           . "$('.delete_row_".$this->n_field."').on('click',function(){"
           . "var idn=$(this).attr('data-idn');"
           . "var dinamic=$(this).attr('data-dynamic');"
           . "$('#dinamic_row_'+dinamic+'_'+idn).html('');"
           . "$('#dinamic_row_'+dinamic+'_'+idn).attr('id','deleted');"
           . "new_sort".$this->getNameField()."(dinamic,idn);"
           . "return false;"
           . "});"

          . " </script>";
  }
return $result_html;


  }

    public function renderValue($value, $mg) {
        return "";
    }
   public function setInput($value="",$mg) {

 if(is_array($this->opt['fields']) and count($this->opt['fields'])>0){
  $first_fields="";
  foreach($this->opt['fields'] as $name_f=>$f){
  $first_fields=$name_f;
  break;
  }

  $i=0;
  $result=array();
 $i = 0;
 $continue=1;
 $execute=0;
do {

  if($execute==1 and $continue==1){

 if(isset($_POST[$this->opt['post_name_field']."".$this->field_name."_".$first_fields."_".$i]) or isset($_FILES[$this->opt['post_name_field']."".$this->field_name."_".$first_fields."_".$i])){

     foreach($this->opt['fields'] as $name_field=>$field){
     if(!isset($result[$i]) or !is_array($result[$i])){
     $result[$i]=array();
     }
      $type=$field['type'];


   if($type!="multi111"){

  if(in_array($type,$this->plugins)){


    $classname="noicms\\mongogrid\\plugins\\type\\fields\\".ucfirst($type)."Field";

    /*
     *   $plugin_opt=$included_opt;
     $plugin_opt['label']=$label;
    $plugin_opt['required']=$required;
    $plugin_opt['unique']=$unique;
     */
    $label=$name_field;
    if(isset($field['label'])){
    $label=$field['label'];
    }

    $plugin_opt=array('label'=>$label);
    if(isset($field['opt'])){
    $included_opt=$field['opt'];
    }else {
    $included_opt=array();
    }
    if(isset($included_opt)){
     foreach($included_opt as $key => $value){
       $plugin_opt[$key]=$value;
     }
    }
    $plugin_opt['post_name_field']=$this->opt['post_name_field'];

    $included_opt['plugin']=new $classname($this->field_name."_".$name_field."_".$i,$plugin_opt);

    $result[$i][$name_field]=$included_opt['plugin']->setInput("",$mg);
    if($name_field=="vars"){

    }
    $this->fields[$name_field]=$included_opt;
  }
  }

    }
    $i++;
  }else {
   $continue=0;
   $execute=0;
   break;
  }
  }else if($execute==0 and $continue==1){

if(isset($_POST[$this->opt['post_name_field']."".$this->field_name."_".$first_fields."_".$i]) or isset($_FILES[$this->opt['post_name_field']."".$this->field_name."_".$first_fields."_".$i])){
 $execute=1;
 $continue=1;
}else {
  $continue=0;
  $execute=0;
  break;
}
  }
} while ($continue>0);

 }
  if(!isset($_POST[$this->getNameField()."_clear"]) or (isset($_POST[$this->getNameField()."_clear"]) and  $_POST[$this->getNameField()."_clear"]!=1) ){
  $result=array();   
  }
 if(is_array($result) and count($result)==0){
    if(!isset($_POST[$this->getNameField()."_clear"]) or (isset($_POST[$this->getNameField()."_clear"]) and  $_POST[$this->getNameField()."_clear"]!=1) ){
   if(isset($mg->status->old_result[$this->field_name])){
   if(count($mg->status->old_result[$this->field_name])>0){    
   $result=$mg->status->old_result[$this->field_name];
   }
   }
    }else {
    
    }
   

 }
 return $result;
  }
}
?>