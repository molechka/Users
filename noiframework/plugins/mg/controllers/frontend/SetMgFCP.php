<?php

class SetMgFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("user",$cur,$route);
    
    }

public function actionDelete($name_collection,$last_id){
    if(isset($name_collection) and isset($last_id)){
   $collection=  \mg\models\Collections::getByID($name_collection);
   
    if(!is_bool($collection)){
        \mg\models\ModelSet::delete($collection,$last_id);
    }  
    }
      NoiCore::app()->returnback();
         exit;
}
public function actionAddact($name_collection){
    $collection=  \mg\models\Collections::getByID($name_collection);
   
    if(!is_bool($collection)){
        
     if(\mg\models\ModelSet::checkPrivacy($collection)){
          
         \mg\models\ModelSet::insert($collection);
        
     }else {
      NoiCore::app()->setNotify("У вас нет прав доступа для добавления!");   
     }   
    }
     
     
     NoiCore::app()->returnback();
         exit;
}
    
    
    
    
}

