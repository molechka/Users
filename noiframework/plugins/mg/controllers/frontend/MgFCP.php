<?php
use mg\models\Collections;
class MgFCP extends CoreFrontendControllerPlugin {
  
    public function actionIndex($cat_id,$post_id=0){
       
    
    if(isset($cat_id) and ( is_numeric($cat_id) or is_string($cat_id) ) and isset($post_id) and $post_id==0){
     return $this->loadCat($cat_id);   
    }else if(isset($cat_id)  and (is_numeric($cat_id) or is_string($cat_id) ) and isset($post_id) and is_numeric($post_id) and $post_id>0){
    return $this->loadPost($cat_id,$post_id);
    } 
    }
    public function loadCat($cat_id,$condition=array(),$prefix="",$count=0){
       
    $collection=Collections::getByID($cat_id);
     
    if(!is_bool($collection)){
    $data['collection']=$collection; 
    $data=Collections::getDocuments($data,$condition,$count);
$ismainpage=NoiCore::app()->getParam("ismainpage");
if(($ismainpage===0 or $ismainpage===false)){
if(((isset($collection['canchange']) and $collection['canchange']==0) or !isset($collection['canchange']) )){    
 
    if(isset($collection['meta_keywords'])){
 NoiCore::app()->setParam("keywords",$collection['meta_keywords']);
}
if(isset($collection['meta_description'])){
 NoiCore::app()->setParam("description",$collection['meta_description']);
}
if(isset($collection['meta_title'])){
     
$this->setTitle($collection['meta_title']);
}
NoiCore::app()->setParam("mg_current_page",$collection['name']);
}

}
 
    return $this->render($collection['name']."_list".$prefix,$data);
    }
    }
    public function loadPost($cat_id,$post_id){
      $collection=Collections::getByID($cat_id);
       if(!is_bool($collection)){
       $data['collection']=$collection;
       $data['document']=Collections::getDocument($post_id,$collection);
       if(!is_bool($data['document'])){
        if(isset($data['document']['meta_keywords'])){
 NoiCore::app()->setParam("keywords",$data['document']['meta_keywords']);
}
if(isset($data['document']['meta_description'])){
 NoiCore::app()->setParam("description",$data['document']['meta_description']);
}
if(isset($data['document']['meta_title'])){
     
$this->setTitle($data['document']['meta_title']);
}   
        return $this->render($collection['name']."_one",$data);
       }
       }
    }
    
}

