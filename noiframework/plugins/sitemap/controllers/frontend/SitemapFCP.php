<?php

class SitemapFCP extends CoreFrontendControllerPlugin {


    public function __construct($route,&$cur) {

        parent::__construct("sitemap",$cur,$route);

    }

    public function actionGet(){
      
    $data=array();
 
    $data['forms']=$this->db()->query2(array(),"plugin_forms",array('visible'=>1));
    $data['collections']=NoiCore::app()->db()->query2(array(),"collections_list",array());
    $data['results']=array();
    if(count($data['collections'])>0){
    foreach($data['collections'] as $key=>$coll){
    if(file_exists(DOCUMENT_ROOT."/templates/villa/page/plugin/mg/".$coll['name']."_list.php")){
    $data['collections'][$key]['list']=1;
      
    
    }
    
   if(file_exists(DOCUMENT_ROOT."/templates/villa/page/plugin/mg/".$coll['name']."_one.php")){
   
    $data['collections'][$key]['one']=1;
    $data['results'][$coll['name']]=NoiCore::app()->db()->query2(array(),$coll['name'],array());
    }else {
    $data['results'][$coll['name']]=array();    
     $data['collections'][$key]['one']=0;
    }
    
    }    
    }
    
    $result=$this->render("sitemap",$data);
    $result=NoiCore::route()->replace($result);
    
    $xmlstr =
'<?xml version="1.0" encoding="UTF-8"?>
'.$result;
   $doc= new DOMDocument();
   $doc->loadXML($xmlstr);
   echo $doc->saveXML();
   exit;
    }

}
