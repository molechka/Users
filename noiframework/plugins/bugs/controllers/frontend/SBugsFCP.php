<?php

class SBugsFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("bugs",$cur,$route);
         
         
    }
    public function actionIndex(){
    $data=array();
    
    return $this->render("suggestions",$data);
    }
}

