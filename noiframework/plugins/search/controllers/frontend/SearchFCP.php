<?php

class SearchFCP extends CoreFrontendControllerPlugin {

   public $search_array=array(
   'content'=>array(
       'condition'=>array('visible'=>1,'$or'=>array(array('content'=> array('$regex' => '{replace}')),array('title'=> array('$regex' => '{replace}')))),
       'collection'=>'user_content',
       'params_id'=>'_id',
       'title'=>'title',
       'url'=>'/content/page/{params_id}.html',
       )
   );

    public function __construct($route,&$cur) {

        parent::__construct("search",$cur,$route);

    }
    public function actionIndex(){
    if(isset($_POST['act_search'])){
    if(isset($_POST['where']) and isset($this->search_array[$_POST['where']]) and isset($_POST['q']) and strlen($_POST['q'])>2){
    $this->redirect("/search/do/".$_POST['where']."?q=".$_POST['q']);
    }
    }
    return $this->render("show");
    }
    public function actionDo($type){
    if(isset($type) and isset($this->search_array[$type])){
 if(isset($_GET['q']) and strlen($_GET['q'])>2){
 $_GET['q']=strip_tags($_GET['q']);
 if(strlen($_GET['q'])>2){
 $current_type=$this->search_array[$type];
 if(isset($current_type['condition']) and $current_type['title'] and isset($current_type['collection']) and isset($current_type['params_id']) and isset($current_type['url'])){
 $condition_old=$current_type['condition'];
 $condition_new=$this->getCondition($condition_old,$_GET['q']);
 if($condition_old!=$condition_new){
 $results=NoiCore::app()->db()->query(array(),$current_type['collection'],$condition_new,array('_id'=>-1),10,NoiCore::c("ppaginator")->getOffset(10));
 $count=NoiCore::app()->db()->count($current_type['collection'],$condition_new);
 $array_result=array();
 if(count($results)>0){
     foreach ($results as $row){
     if(isset($current_type['params_id'])){
     $params_id=$row[$current_type['params_id']];
     if($current_type['params_id']=="_id"){
      $params_id=$params_id->__toString();
     }
     $url=str_replace("{params_id}",$params_id,$current_type['url']);
     if(isset($row[$current_type['title']])){
     $array_result[]=array('url'=>$url,'title'=>$row[$current_type['title']]);
     }
     }
     }
 }

 return $this->render("search",array('result'=>$array_result,'phrase'=>$_GET['q'],'type'=>$type,'paginator'=>NoiCore::c("ppaginator")->show($count,10, $this->getRoute('do/'.$type."?q=".$_GET['q'],0))));
 }
 }
 }
 }
    }
    }
    public function getCondition($condition,$q){
    if(isset($condition) and is_array($condition)){
    foreach($condition as $key=>$cond){
    if(is_string($cond)){
     $condition[$key]=  str_replace('{replace}', $q, $condition[$key]);
    }else if(is_array($cond)){
     $condition[$key]=$this->getCondition($cond, $q);
    }
    }
    }
    return $condition;
    }
}

