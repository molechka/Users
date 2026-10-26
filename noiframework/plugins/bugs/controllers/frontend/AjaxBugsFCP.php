<?php

class AjaxBugsFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("bugs",$cur,$route);
         
         
    }
    public function actionRequest(){
      $json=array('type'=>'error','message'=>'Некорректная дата!');
      $bugmodel=new bugs\models\BugModel();
      $json=$bugmodel->getCode();
      echo json_encode($json);
      exit;
    }
    
}

