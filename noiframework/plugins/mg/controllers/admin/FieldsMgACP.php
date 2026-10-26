<?php
use mg\models\Collections;
use noicms\mongogrid\OneField;
use noicms\core\StrInput; 
class FieldsMgACP  extends CoreAdminControllerPlugin{
    
  function actionIndex($id_collection){
  if(isset($id_collection) and StrInput::is_Id($id_collection)){
   $collection=Collections::get($id_collection);
   if(!is_bool($collection)){
    return $this->render("fields_list",array('collection'=>$collection));   
   }
  }    
  }
  function actionAdd($id_collection){
    if(isset($id_collection) and StrInput::is_Id($id_collection)){
   $collection=Collections::get($id_collection);
   if(!is_bool($collection)){
       Collections::addField($id_collection);
       NoiCore::app()->redirect(NoiCore::app()->getRoute('p_mg/fields/index/'.$id_collection));
   }    
  }
  }
   function actionDelete($id_collection,$key=0){
    if(isset($id_collection) and StrInput::is_Id($id_collection)){
   $collection=Collections::get($id_collection);
   if(!is_bool($collection)){
       Collections::deleteField($id_collection,$key);
       NoiCore::app()->redirect(NoiCore::app()->getRoute('p_mg/fields/index/'.$id_collection));
   }    
  }
  }  
  function actionUpdate($id_collection,$key){
      if(isset($id_collection) and StrInput::is_Id($id_collection)){
   $collection=Collections::get($id_collection);
   if(!is_bool($collection) and isset($collection['fields'][$key])){
    $collection['fields'][$key]['name']=$key;   
   return $this->render("edit",array('collection'=>$collection,'field'=>$collection['fields'][$key]));        
    }    
  }  
  }
    function actionUpdate2($id_collection,$key){
      if(isset($id_collection) and StrInput::is_Id($id_collection)){
   $collection=Collections::get($id_collection);
   if(!is_bool($collection) and isset($collection['fields'][$key])){
       Collections::updateField($id_collection,$key);
     NoiCore::app()->redirect(NoiCore::app()->getRoute('p_mg/fields/index/'.$id_collection));

    }    
  }  
  }
}

