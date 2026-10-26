<?php

 use noicms\mongogrid\core\PluginGlobalevent;
 class MultiacGlobalevent extends PluginGlobalevent{
     public $ip;
     public function __construct($params=array()) {
       
         parent::__construct("multiac", $params);
     }
     public function execute(&$mg) {

     return true;
     }
     
 }

?>