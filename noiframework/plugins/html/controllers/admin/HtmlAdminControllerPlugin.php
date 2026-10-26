<?php

class HtmlAdminControllerPlugin  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('html',$site);
 }
 public function menu_get_widgets($value="0"){
  $array=array();
  $array[0]=array('value'=>'index','title'=>'Show Html');
  return $array;
 }

}