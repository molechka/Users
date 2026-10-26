<?php
use html\models\Html;
class HtmlFrontendControllerPlugin extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("html",$cur,$route);
    
    }

    public function actionIndex(){
     
     return $this->render("show",array('content'=>Html::get($this->iswidget,$this->widget)));
     
    }

    }
