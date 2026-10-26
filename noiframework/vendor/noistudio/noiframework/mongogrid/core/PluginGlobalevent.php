<?php
namespace noicms\mongogrid\core;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    abstract class PluginGlobalevent
{
   public $name="";
   public $params=array();
   public $type="";
   public $enable=0;



   //отображение поля в списке
    abstract public function execute(&$mg);


   public function __construct($name,$params) {
     $this->name=$name;
     $this->params=$params;
   }
}


?>