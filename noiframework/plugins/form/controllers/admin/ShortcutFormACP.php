<?php

class ShortcutFormACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('form',$site);
 }
 public function actionIndex(){
     return $this->render("index");
 }
}

