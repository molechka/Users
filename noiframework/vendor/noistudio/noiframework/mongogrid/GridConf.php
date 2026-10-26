<?php
/*
 * основной файл конфигурации))
 */
namespace noicms\mongogrid;

class GridConf{
   public $path_web;
   public $path_upload;
   public $rules_route="url?short_name=route";
   public $name_field="noibiz_";
 
   public function __construct() {
      $this->path_upload=DOCUMENT_ROOT."/tmp/";
      $this->path_web="/tmp/";
   }
}
?>