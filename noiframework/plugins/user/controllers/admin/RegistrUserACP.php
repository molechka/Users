<?php

class RegistrUserACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('user',$site);

 }
 public function actionIndex(){
    $data=array(); 
   return $this->render("index",$data);
 }
}

