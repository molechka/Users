<?php
namespace noicms\mongogrid\core;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    abstract class PluginEvent
{
   public $name="";
   public $params=array();



   //отображение поля в списке
    abstract public function execute($mg);
 

   public function __construct($name,$params) {
     $this->name=$name;
     $this->params=$params;
   }
}


?>