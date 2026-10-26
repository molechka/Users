<?php
namespace noicms\mongogrid\system_core;

 class GridImage  {

    static  public function showImage($blob,$width=0,$height=0,$_id,$field,$url,$nourl=0){
    $imagick=new Imagick();
    if((bool)parse_url($blob))
{
  if($nourl==0){
    $before="<a href='".$url."'>";
    $after="</a>";
  }
      return $before."<img src='".$blob."' style='width:".$width."px;height:".$height."px;'>".$after;;
}

    $imagick->readimageblob($blob);
    if(isset($width) and isset($height) and $width>0 and $height>0){
    $imagick->resizeImage($width,$height, imagick::FILTER_LANCZOS, 0.9, true);
    }
    $imagick->setImageFormat('png');
    $mime = "image/png";
    $b64Src = "data:".$mime.";base64," . base64_encode($imagick->getimageblob());
     //echo  base64_encode($imagick->getimageblob());
 if($nourl==0){
   return  '<a target="_blank" href="'.$url.'?image_grid='.$_id.'&field_image='.$field.'"><img  class="caption"  src="'.$b64Src.'" alt="" /></a>';
  }else {
    return  '<img  class="caption"  src="'.$b64Src.'" alt="" />';

  }
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
     $image->writeImage(DOCUMENT_ROOT.'/tmp/'.$file_name);
    
     return '/tmp/'.$file_name;
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
}
 }
?>