<?php
 
class HtmlRCP extends CoreRealtimeControllerPlugin{

 public function __construct() {
   $site=NoiCore::app()->site_data;
 
     parent::__construct('html',$site);
 }
 
  

}

?>