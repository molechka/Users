<?php

class MainpageUserACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('user',$site);

 }
 public function actionIndex(){
   $data=array();
   $data['rows']=NoiCore::app()->db()->query(array(),"cms_users",array(),array('_id'=>-1),10);
   
   return $this->render("index",$data);
 }
}
