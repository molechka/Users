<?php

class CountFormACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('form',$site);

 }
 public function actionIndex(){
   $data=array();
   $data['count_pages']=NoiCore::app()->db()->count("plugin_forms",array());
   return $this->render("index",$data);
 }
}
