<?php
namespace noicms\mongogrid\plugins\type\fields;
use Imagick;
use NoiCore;
use noicms\mongogrid\GridConf;
use noicms\mongogrid\core\PluginField;
class FimageField extends PluginField{
  private $path_upload;
  private $web_path;
  private $type_upload='file';

  function __construct($field_name,$opt) {
    if(isset($type)){

     $this->type_upload=$type;
    }
  
    $conf=new GridConf();
    $this->path_upload=$conf->path_upload."/image/";
   
    $this->web_path=$conf->path_web."/image/";
    parent::__construct("fimage",$field_name,$opt);;
  }
   public function getInput($value="",$mg) {
    $added="";
  if(NoiCore::app()->isAdmin()){
 
  return $this->render("show",array('value'=>$value,"field"=>$this));
    }else {
        
    }    
  }
   public function setInput($value="",$mg) {
       if(isset($_POST[$this->getNameField()])){
        if(file_exists(DOCUMENT_ROOT."".$_POST[$this->getNameField()]) and !is_bool($this->isImage(DOCUMENT_ROOT."".$_POST[$this->getNameField()]))){
        return $_POST[$this->getNameField()];  
        }else {
       
        return false; 
        }
      
       }else {
           return false;
       }
   }
   function isImage($file)
{
    $fh = fopen($file,'rb');
    if ($fh) { 
        $bytes = fread($fh, 6); // read 6 bytes
        fclose($fh);            // close file

        if ($bytes === false) { // bytes there?
            return false;
        }

        // ok, bytes there, lets compare....

        if (substr($bytes,0,3) == "\xff\xd8\xff") { 
            return 'image/jpeg';
        }
        if ($bytes == "\x89PNG\x0d\x0a") { 
            return 'image/png';
        }
        if ($bytes == "GIF87a" or $bytes == "GIF89a") { 
            return 'image/gif';
        }

        return 'application/octet-stream';
    }
    return false;
}
   public function renderValue($value,$mg) {
         return "";
     }
}
?>