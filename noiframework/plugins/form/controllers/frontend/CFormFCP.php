<?php
use noicms\core\StrInput; 
class CFormFCP extends CoreFrontendControllerPlugin {
public $result_fields=array();
    public function __construct($route,&$cur) {

        parent::__construct("form",$cur,$route);



    }
    public function preParse($forms){
         if(!NoiCore::lang()->is()){
       return $forms;
     }

           $cur_lang=NoiCore::app()->getLang();     
     foreach($forms as $keya=>$val){

 if(isset($val['title_'.$cur_lang])){
        
     $forms[$keya]['title']=$val['title_'.$cur_lang];
     } 
      if(isset($val['description_'.$cur_lang])){
        
     $forms[$keya]['description']=$val['description_'.$cur_lang];
     } 
     if(isset($val['meta_keywords_'.$cur_lang])){
        
     $forms[$keya]['meta_keywords']=$val['meta_keywords_'.$cur_lang];
     } 
      if(isset($val['meta_description_'.$cur_lang]) ){
        
     $forms[$keya]['meta_description']=$val['meta_description_'.$cur_lang];
     } 
        if(isset($val['before_'.$cur_lang]) ){
        
     $forms[$keya]['before']=$val['before_'.$cur_lang];
     } 
      if(isset($val['after_'.$cur_lang])){
        
    $forms[$keya]['after']=$val['after_'.$cur_lang];
     } 
      if(isset($val['notify_success_'.$cur_lang]) ){
        
     $forms[$keya]['notify_success']=$val['notify_success_'.$cur_lang];
     } 
       if(isset($val['notify_error_'.$cur_lang])){
        
     $forms[$keya]['notify_error']=$val['notify_error_'.$cur_lang];
     }    
     }     
    
         
     return $forms;    
     }
     public function preParseCat($val){
      if(!NoiCore::lang()->is()){
       return $val;
     }
       $cur_lang=NoiCore::app()->getLang();
     if(isset($val['title_'.$cur_lang]) ){
        
     $val['title']=$val['title_'.$cur_lang];
     } 
       
     if(isset($val['meta_keywords_'.$cur_lang])){
        
     $val['meta_keywords']=$val['meta_keywords_'.$cur_lang];
     } 
      if(isset($val['meta_description_'.$cur_lang]) ){
        
     $val['meta_description']=$val['meta_description_'.$cur_lang];
     } 
     
         
     return $val;    
     }
    public function actionIndex($id_cat){

    }
    public function actionLinks($id_cat){
    if(isset($id_cat) and StrInput::is_Id($id_cat)){
    $category=$this->db()->query(array(),"forms_category",array('visible'=>1,'_id'=>new MongoId($id_cat)));
    if(isset($category[0]['_id'])){
    $category[0]=$this->preParseCat($category[0]);    
    $forms=$this->db()->query2(array(),"plugin_forms",array('category'=>$id_cat,"visible"=>1));
    if(isset($forms) and count($forms)>0){
    $forms=$this->preParse($forms);    
    if(isset($category[0]['prefix']) and strlen($category[0]['prefix'])>1){
     return $this->render($category[0]['prefix']."_links",array('forms'=>$forms,'category'=>$category[0]));
    }else {
      return $this->render("links",array('forms'=>$forms,'category'=>$category[0]));
    }
    }
    }
    }
    }
}

