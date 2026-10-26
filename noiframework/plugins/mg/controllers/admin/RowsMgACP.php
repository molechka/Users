<?php

class RowsMgACP  extends CoreAdminControllerPlugin{
 
    public function actionIndex(){
       
    $data=array();
    $data['collections']=  mg\models\Collections::getLastData();
    return $this->render("index",$data);
    }
 
 
}

