<?php
namespace noicms\mongogrid\system_core;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GridStr {
  static function encode($str,$passw){
      return base64_encode(GridStr::code($str, $passw));
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

   return  GridStr::code(base64_decode($str),$passw);
}
}

?>