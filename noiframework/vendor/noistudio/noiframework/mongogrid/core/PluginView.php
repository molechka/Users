<?php
namespace noicms\mongogrid\core;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use NoiCore;
    abstract class PluginView
{
   public $name="";
   public $params=array();



   //отображение поля в списке
    abstract public function render();
    public function renderPlugin($data){
    
     $view=NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/views/".$this->name."/themes/".$this->name.".php",$data);
   return $view;
     }

   public function __construct($name,$params) {
     $this->name=$name;
     $this->params=$params;
   }
}


?>