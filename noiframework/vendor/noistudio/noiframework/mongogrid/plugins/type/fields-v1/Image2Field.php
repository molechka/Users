<?php

yii::import("ext.mongogrid.core.PluginField");
class Image2Field extends PluginField{
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
    parent::__construct("image2",$field_name,$opt);;
  }

  public function getInput($value="",$mg) {
  $template='<input name="field_'.$this->field_name.'" type="file">';
  return $template;
  }
  public function setInput($value="",$mg) {


  $value=$this->upload('field_'.$this->field_name,$this->type_upload);
 
  if(strlen($value)==0 ){
  if(isset($this->opt['default_value'])){
   $value=$this->opt['default_value'];
  }  }else {
         if(($mg->operations->default_operation=="update" or $mg->operations->default_operation=="delete") and isset($mg->status->old_result[$this->field_name])){
         $oldvalue=$mg->status->old_result[$this->field_name];
         $tmp=explode("/image/",$oldvalue);
         if(file_exists($this->path_upload."".$tmp[1])){
         unlink($this->path_upload."".$tmp[1]);
         }
         }
  }
      
  return $value;
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
         if(file_exists($this->path_upload."".$tmp[1])){
         unlink($this->path_upload."".$tmp[1]);
         }
         }
}
}
?>
