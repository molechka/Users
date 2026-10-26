<?php

class NavHtmlACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('html',$site);

 }
 public function actionIndex(){
   $data=array();
   $data['widgets']=$this->getAllWidgets();
   return $this->render("index",$data);
 }
}
