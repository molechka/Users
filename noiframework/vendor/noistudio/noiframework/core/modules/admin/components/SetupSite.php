<?php
namespace noicms\admin\components;
class SetupSite{
    public $plugin;
    public $component;
    public $value;
    public function __construct($options,$widget) {
    $this->plugin=new AdminRender;
    if(isset($options['component']) ){
    $this->component=$options['component'];
    }
    if(isset($options['value'])){
    $this->value=$options['value'];
    }
    if(isset($options['site'])){
    $this->site_data=$options['site'];
    }

    }
    public function render(){

     return $this->execute();
    }
     private function execute(){

 if($this->component!=""){

     $class_name=ucfirst($this->component)."UserComponent";
  //  $path_component=Yii::getPathOfAlias('application.components');

 $path_component=YII_COMPONENT_PATH."".$class_name.".php";
     if(file_exists($path_component)){
         require_once $path_component;
   //  $path_view=Yii::getPathOfAlias('application.modules.admin.views.mysites');;
     $path_view=PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/mysites";
     $class_data=new $class_name(array(),$path_view);

   return  $class_data->setup_component($this->site_data,$this);


     }


 }
  }
}

