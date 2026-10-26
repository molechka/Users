<?php

namespace noicms\mongogrid\plugins\type\fields;
 
use noicms\mongogrid\GridConf;
use Imagick;
use NoiCore;
use noicms\mongogrid\core\PluginField;
class RimageField extends PluginField{
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
    parent::__construct("rimage",$field_name,$opt);;
  }

  public function getInput($value="",$mg) {
     $added="";
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }      
  $template='<input '.$added.' name="'.$this->getNameField().'" type="file">';
  return $template;
  }
  public function setInput($value="",$mg) {


  $value=$this->upload($this->getNameField(),$this->type_upload);

if(!is_array($value)){
 if(strlen($value)>2){
    return $value;
 }else {
   return false;
 }
}else {

 if(count($value)>0){
  return $value;
 }else {
     return false;
 }
}
 if(strlen($value)==0 ){
 if(isset($mg->status->old_result[$this->field_name])){
  $value=$mg->status->old_result[$this->field_name];
  }else  if(isset($this->opt['default_value'])){
   $value=$this->opt['default_value'];

  }  }else {

         if(($mg->operations->default_operation=="update" or $mg->operations->default_operation=="delete") and isset($mg->status->old_result[$this->field_name])){
         $oldvalue=$mg->status->old_result[$this->field_name];
         if(isset($oldvalue) and $oldvalue!="/tmp/nofoto.png" and strlen($oldvalue)>0 and $oldvalue!="/tmp/nofoto.jpg"){
         $tmp=explode("/image/",$oldvalue);
         if(file_exists($this->path_upload."".$tmp[1])){
         unlink($this->path_upload."".$tmp[1]);
         }
         }
         }
  }
   

  }
  public function renderValue($value,$mg) {

        if(!isset($value->bin)){
        $blob=$value;
        }else {
        $blob=$value->bin;
        }
  $template="";
  if($this->type_upload=="file"){
  $template="<a href='".$value."'><img  width='100px' height='100px' src='".$value."'></a>";
  }
  return $template;
  }
    public function getBlob($field,$type){

     if(!isset($_FILES[$field]))
    {
    return "";
    }
else
    {
    try    {
       return  $this->upload($field,$type);
        /*** give praise and thanks to the php gods ***/

        }
    catch(Exception $e)
        {
       /// echo '<h4>'.$e->getMessage().'</h4>';
        return "";
        }
    }
     }
   public function upload($field,$type_action){
/*** check if a file was uploaded ***/


  if(isset($_FILES[$field]) and strlen($_FILES[$field]['tmp_name'])>0){
if(is_uploaded_file($_FILES[$field]['tmp_name']) && getimagesize($_FILES[$field]['tmp_name']) != false)
    {

    /***  get the image info. ***/
    $size = getimagesize($_FILES[$field]['tmp_name']);
    /*** assign our variables ***/
    $type = $size['mime'];
    $imgfp = fopen($_FILES[$field]['tmp_name'], 'rb');
    $size = $size[3];
    $name = $_FILES[$field]['name'];
    $maxsize = 99999999;



    /***  check the file is less than the maximum file size ***/
    if($_FILES[$field]['size'] < $maxsize )
        {
    $image = new Imagick();

    $image->readimage($_FILES[$field]['tmp_name']);
    if($type_action=="blob"){
   $result=$image->getimageblob();

    return  new MongoBinData($result,0);
    }else if($type_action=="file") {

     $file_name=md5(date('YmdHis'.rand(0,9999))).".png";
     unset($this->opt['id_site']);
     if(isset($this->opt['id_site'])){
     $path_web_site=DOCUMENT_ROOT."/themes/widget/userthemes/".$this->opt['id_site'];
     $path_web_site_images=DOCUMENT_ROOT."/themes/widget/userthemes/".$this->opt['id_site']."/images";
       if (!file_exists($path_web_site) && !is_dir($path_web_site)) {

       }else {
        if (!file_exists($path_web_site_images) && !is_dir($path_web_site_images)) {
         mkdir($path_web_site_images);
        }
       }

        $image->writeImage($path_web_site_images."/".$file_name);

     return "/themes/widget/userthemes/".$this->opt['id_site']."/images/".''.$file_name;
     }
     $site_data=NoiCore::app()->site_data;
 
     if(is_array($this->opt['images'])){
 if(count($this->opt['images'])>0){
     $array_values=array();
     $image2=$image;
     foreach($this->opt['images'] as $img){
 
      if(isset($img['width']) and isset($img['height'])){
      $resize_type="auto";
      if(isset($img['resize_type'])){
      $resize_type=$img['resize_type'];
      }

      $new_width=$img['width'];
      $new_height=$img['height'];

      $new_img=$image2;
      $current_size_width=$new_img->getimagewidth();
      $current_size_height=$new_img->getimageheight();
  if($resize_type=='width'){
      $aspect =  $current_size_width / $current_size_height;
      $new_width = $img['width'];
      $new_height = $new_width / $aspect;
      }else if($resize_type=="height"){
        $aspect =  $current_size_height / $current_size_width;
      $new_height = $img['height'];;
      $new_width = $new_height / $aspect;
      }
 
      $new_file_name=$file_name;
      $new_file_name=str_replace(".png",$img['width']."x".$img['height'].".png",$new_file_name);

 
      $new_img->resizeImage($new_width,$new_height,Imagick::FILTER_LANCZOS,1);
      $new_img->writeImage($this->path_upload."".$new_file_name);
      $array_values[$img['width']."x".$img['height']]=$this->web_path.''.$new_file_name;

      }
     }

     if(count($array_values)==1){
       $key=key($array_values);

       return $array_values[$key];
     }else {
   return $array_values;
     }
 }
     }


     $image->writeImage($this->path_upload."".$file_name);

     return $this->web_path.''.$file_name;

    }
        }
    else
        {

        /*** throw an exception is image is not of type ***/
        throw new Exception("File Size Error");
        }
    }
else
    {

    // if the file is not less than the maximum allowed, print an error
    throw new Exception("Unsupported Image Format!");
    }
  }else {
      return "";
  }
}
public function afterEvent($mg){
    if(isset($mg->status->old_result[$this->field_name])){
         $oldvalue=$mg->status->old_result[$this->field_name];
         $tmp=explode("/image/",$oldvalue);
         if(isset($tmp[1])){
         if(file_exists($this->path_upload."".$tmp[1])){
         unlink($this->path_upload."".$tmp[1]);
         }
         }
    }
}
}
?>