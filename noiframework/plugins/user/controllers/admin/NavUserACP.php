<?php

class NavUserACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('user',$site);

 }
 public function actionIndex(){
   return $this->render("index");
 }
}

