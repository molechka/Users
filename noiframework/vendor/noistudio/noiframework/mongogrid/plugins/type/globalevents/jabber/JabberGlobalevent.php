<?php

 
 use noicms\mongogrid\core\PluginGlobalevent;
 class JabberGlobalevent extends PluginGlobalevent{
     public function __construct($params=array()) {
         parent::__construct("jabber", $params);
     }
     public function execute(&$mg) {

     if($mg->status->operation=="update" and $mg->status->status==1 and $mg->collection=="cms_user"){
        if(isset($mg->status->old_result['role']) and isset($mg->status->new_result['role']) and $mg->status->old_result['role']!=$mg->status->new_result['role'])
        {
          
        }
     }
     }
 }
?>