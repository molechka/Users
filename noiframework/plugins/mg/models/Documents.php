<?php

namespace mg\models;
use NoiCore;
class Documents{
  static function parsec($collection){
      
  if(NoiCore::lang()->is()){
    $cur_lang=NoiCore::app()->getLang();  
   if(isset($collection['meta_title_'.$cur_lang])){
         $collection['meta_title']=$collection['meta_title_'.$cur_lang];    
        }
        if(isset($collection['meta_keywords_'.$cur_lang])){
         $collection['meta_keywords']=$collection['meta_keywords_'.$cur_lang];    
        }
        if(isset($collection['meta_description_'.$cur_lang])){
         $collection['meta_description']=$collection['meta_description_'.$cur_lang];    
        }   
         if(isset($collection['description_'.$cur_lang])){
         $collection['description']=$collection['description_'.$cur_lang];    
        }    
  } 
  
  return $collection  ;  
  }  
  static function parse($results,$collection){
      $lang_array=array();
      if(count($collection['fields'])>0){
       foreach($collection['fields'] as $nf=>$field){
       if(isset($field['multilang']) and $field['multilang']==1){  
      
       $lang_array[]=$nf;    
       }    
       }   
      }
      $cur_lang=NoiCore::app()->getLang();
      if(count($results)>0 and NoiCore::lang()->is() and count($lang_array)>0){
       foreach($results as $key=>$row){
        foreach($lang_array as $field){
        if(isset($row[$field."_".$cur_lang])){
        $results[$key][$field]=$row[$field."_".$cur_lang];
        }    
        }   
        if(isset($row['meta_title_'.$cur_lang])){
         $results[$key]['meta_title']=$row['meta_title_'.$cur_lang];    
        }
        if(isset($row['meta_keywords_'.$cur_lang])){
         $results[$key]['meta_keywords']=$row['meta_keywords_'.$cur_lang];    
        }
        if(isset($row['meta_description_'.$cur_lang])){
         $results[$key]['meta_description']=$row['meta_description_'.$cur_lang];    
        }
       }   
      } 
   
      return $results;
  }  
}

