<?php
 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 namespace noicms\core;

class StrInput {
  static function encode($str,$passw){
      return base64_encode(StrInput::code($str, $passw));
  }
  static function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}
 static  function is_Id($id=null)
    {
     if(DB_TYPE=="mongolite" and strlen($id)>4){
      return true;
     }
     $mongoid=new Validate_MongoId($id);
     if($mongoid->isValid()){
         return true;
     }else {
         return false;
     }
    }

 static  function code($str, $passw="")
{
   $salt = "Dn8*#2n!9j";
   $len = strlen($str);
   $gamma = '';
   $n = $len>100 ? 8 : 2;
   while( strlen($gamma)<$len )
   {
      $gamma .= substr(pack('H*', sha1($passw.$gamma.$salt)), 0, $n);
   }
   return $str^$gamma;
}
static function decode($str,$passw){

   return  StrInput::code(base64_decode($str),$passw);
}
}

?>
