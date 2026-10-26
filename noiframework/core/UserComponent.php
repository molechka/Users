<?php
//основной класс для определения взаимодействия веб-сайтов
abstract class UserComponent{
    public $param;
    public $path_view="";
    public $default_path_view="";
    public $cur=null;
    public $name_component="";
    public $site_data=array();
    public function __construct($param=array(),$path_view="") {
    $this->param=$param;
    $this->path_view=$path_view;
    if($path_view==""){
    //$this->path_view=Yii::getPathOfAlias('application.modules.admin.views.mysites');

    }
  //  $this->default_path_view=Yii::getPathOfAlias('application.modules.admin.views.mysites');;
 $name_class=get_class($this);
 $name_class=  str_replace("UserComponent", "", $name_class);
 $name_class=  strtolower($name_class);
 $this->name_component=$name_class;

  //  Yii::setPathOfAlias('componentviews', $this->path_view."/");
    }
    abstract protected function setup_component($site,$setup);
    abstract protected function render_component($site);
    public function setCur(&$cur){
    $this->cur=$cur;
    }

     public function find_best_path($view){
      if(isset($this->site_data['_id'])){


    if(isset($this->site_data['theme_site']) and isset($this->site_data['type_site'])){
    if(file_exists(DOCUMENT_ROOT."/themes/widget/".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/".$this->name_component."/".$view.".php")){


  return DOCUMENT_ROOT."/themes/widget/".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/".$this->name_component."/".$view.".php";

    }else if(file_exists(DOCUMENT_ROOT."/themes/widget/userthemes/".$this->site_data['_id']->__toString()."/page/".$this->name_component."/".$view.".php")){
      return DOCUMENT_ROOT."/themes/widget/userthemes/".$this->site_data['_id']->__toString()."/page/".$this->name_component."/".$view.".php";
    }else {

    }
    }
}
if(file_exists($this->path_view."/".$view.".php")){
          return $this->path_view."/".$view.".php";
        }


        return "";

    }
    public function setView($page_type,$page){

    yii::app()->params['uc_page']=  $page;
    yii::app()->params['uc_page_type']=  $page_type;
    }
    public function setData($data){
    if(is_array($data))  {
    yii::app()->params['uc_var_array']=$data;
    }
    }
    public function setRoute($route){

    }
     public function render_frontend($view,$data){
    if(!isset($this->site_data['_id'])){
      return "";
    }else {
    if(isset($this->site_data['theme_site']) and isset($this->site_data['type_site'])){
    if(file_exists(DOCUMENT_ROOT."/themes/widget/".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/".$this->name_component."/".$view.".php")){
        $data['cur']=$this;

   return Yii::app()->controller->renderFile(DOCUMENT_ROOT."/themes/widget/".$this->site_data['type_site']."/".$this->site_data['theme_site']."/page/".$this->name_component."/".$view.".php",$data,$data,true);

    }else if(file_exists(DOCUMENT_ROOT."/themes/widget/userthemes/".$this->site_data['_id']->__toString()."/page/".$this->name_component."/".$view.".php")){
        return Yii::app()->controller->renderFile(DOCUMENT_ROOT."/themes/widget/userthemes/".$this->site_data['_id']->__toString()."/page/".$this->name_component."/".$view.".php",$data,$data,true);
    }else {
        return "";
    }
    }

    }
    }
      public function return_path($view){
     return YII_COMPONENT_PATH."".$this->name_component."/view/".$view.".php";
    }
    public function render($view,$data=array()){
    if(file_exists(YII_COMPONENT_PATH."".$this->name_component."/view/".$view)){
     $data['cur']=$this;
      return Yii::app()->controller->renderFile(YII_COMPONENT_PATH."".$this->name_component."/view/".$view,$data,$data,true); 
    }
    }
    public function render_setup($view,$data,$full=0){
    if(strlen($this->path_view)){
     $this->path_view=$this->default_path_view;
    }
    $full=0;
 
    $path=PATH_TO_ENGINE."/modules/admin/views/mysites/".$view.".php";
    
       $data['cur']=$this;
     
if($full==0){
        //return Yii::app()->controller->renderFile($path,$data,$data,true);
        return NoiCore::app()->render($path,$data);
}else {
   
       return NoiCore::app()->render($path,$data);

}
    }

    public function getPathRoute($path){

 return 'componentviews.'.$path."";
    }


}

