<?php

class AboutTasksFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("tasks",$cur,$route);
       
    }
    public function actionIndex(){
        header("Content-Type:application/json;q=0.8");
     echo $this->render("about");
     exit;
    }
    
}

