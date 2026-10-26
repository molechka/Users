<?php

class HtmlCCP extends CoreCronControllerPlugin{

 public function __construct($site) {
     parent::__construct('html',$site);
 }
 public function actionIndex(){
   echo "cron2";
 
 }

}

?>