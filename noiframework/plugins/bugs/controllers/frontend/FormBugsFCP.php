<?php

class FormBugsFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("bugs",$cur,$route);
         
         
    }
    public function actionCheck(){
    if(isset($_POST['name']) and strlen($_POST['name'])==0){
     $_POST['name']="Кис446;*№%*5873елев а Ольга";   
    }  
    if(isset($_POST['date']) and strlen($_POST['date'])==0){
     $_POST['date']="11.03.2000";   
    }   
    $data=array();
     
    $bugmodel=new bugs\models\BugModel();
    $json=$bugmodel->getCode();
    $data['date_status']=$bugmodel->isCorrectDate();
    $data['date_text']=$bugmodel->getDate();
    $data['fio_status']=$bugmodel->getStatusFio();
    $data['fio_text']=$bugmodel->getFio();
    $data['fio_new']=$bugmodel->getNewFio();
    $data['category']="";
    if($data['date_status']){
    $data['category']=$bugmodel->getCategory();     
    }
    
    
    return $this->render("check",$data);
    }
    
}

