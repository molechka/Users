<?php

yii::import("ext.mongogrid.core.PluginField");
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
  $template="<input type='file' name='field_".$this->field_name."'/>";
  return $template;
  }
  public function setInput($value="",$mg) {
  
 
if(isset($_FILES['field_'.$this->field_name]['tmp_name'])) {
//создание zip архива
$zip = new ZipArchive();
//имя файла архива
$file_name_short="file_".date('j_m_Y_h_i_s').".zip";
$fileName = $this->path_upload."".$file_name_short;
 
if ($zip->open($fileName, ZIPARCHIVE::CREATE) == false) {
   
     return false;
}


$zip->addFile($_FILES['field_'.$this->field_name]['tmp_name'],$_FILES['field_'.$this->field_name]['name']);

$zip->close();
 
return $this->web_path."".$file_name_short;
}else {
  return false;
}

  }
  public function renderValue($value,$mg) {
  $template="<a href='".$value."'>Посмотрет</a>";
  return $template;
  }
}
?>
