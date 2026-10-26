<?php

namespace noicms\mongogrid\plugins\type\fields;
use NoiCore;
use ZipArchive;
use noicms\mongogrid\core\PluginField;
use noicms\mongogrid\GridConf;
class FileField extends PluginField{
  private $path_upload;
  private $web_path;
  function __construct($field_name,$opt) {
      $conf=new GridConf();
      $this->path_upload=$conf->path_upload."/zip/";
      $this->web_path=$conf->path_web."/zip/";
      parent::__construct("file",$field_name,$opt);
  }
  
  public function getInput($value="",$mg) {
     $added="";
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }      
  $template="<input ".$added." type='file' name='".$this->getNameField()."'/>";
  return $template;
  }
  public function setInput($value="",$mg) {
  
 
if(isset($_FILES[''.$this->getNameField()]['tmp_name'])) {
//создание zip архива
$zip = new ZipArchive();
//имя файла архива
$file_name_short="file_".date('j_m_Y_h_i_s').".zip";
$fileName = $this->path_upload."".$file_name_short;
 
if ($zip->open($fileName, ZIPARCHIVE::CREATE) == false) {
   
     return false;
}


$zip->addFile($_FILES[''.$this->getNameField()]['tmp_name'],$_FILES[''.$this->getNameField()]['name']);

$zip->close();
 
return $this->web_path."".$file_name_short;
}else {
  return false;
}

  }
  public function renderValue($value,$mg) {
  $template="<a target='_blank' href='".$value."'>Посмотреть</a>";
  return $template;
  }
}
?>