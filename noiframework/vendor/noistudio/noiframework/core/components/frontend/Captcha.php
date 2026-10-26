<?php
require_once PATH_TO_ENGINE."/extensions/captcha/autoload.php";
use Gregwar\Captcha\CaptchaBuilder;

class Captcha {
    public function get($key_captcha){
     if(!isset($key_captcha) or !is_string($key_captcha)){
        return "";
     }
     $builder = new CaptchaBuilder;
$builder->build();
NoiCore::app()->setSession($key_captcha,$builder->getPhrase());
return $builder->output();
    }
    public function check($key_captcha,$value){
        $result_captcha=false;
       $frase_test=NoiCore::app()->getSession($key_captcha);
 
      if(strlen($frase_test)>3 and isset($value) and $frase_test==$value){
       $result_captcha=true;
      }else {
       $result_captcha=false;
      }
      return $result_captcha;
    }
}

