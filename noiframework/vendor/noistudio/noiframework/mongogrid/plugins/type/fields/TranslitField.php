<?php
namespace noicms\mongogrid\plugins\type\fields;
 
use NoiCore;
use noicms\mongogrid\core\PluginField;
use noicms\mongogrid\system_core\MGQuery;
class TranslitField extends PluginField{
   private $length=200;
   private $check_format='';

  function __construct($field_name,$opt) {

      if(isset($opt['length']) and $opt['length']>0){
       $this->length=$opt['length'];
      }
      $this->check_format="/^[\a-zA-Zаеё-яАЕЁ-Я0-9_]{0,".$this->length."}$/";

      parent::__construct("translit",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  if($value==""){
  $value=$this->opt['default_value'];
  }
    if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }
  
  $template='<input '.$added.' name="'.$this->getNameField().'" type="text" maxlength="'.$this->length.'" value="'.$value.'">';
  return $template;
  }
  public function setInput($value="",$mg) {
if(!isset($_POST[$this->getNameField()])){

   return false;
}
   $yes="1";

  if (preg_match($this->check_format, $_POST[$this->getNameField()]) or $yes=="1") {

    if(strlen($_POST[$this->getNameField()])<=$this->length){
     $mg->fields->row[$this->field_name."_translit"]=$this->str2url($_POST[$this->getNameField()]);
     $count_title=  MGQuery::count($mg->collection,array($this->field_name=>$mg->fields->row[$this->field_name."_translit"]));
     if($count_title>0){
      $true=true;
      while($true){
       $mg->fields->row[$this->field_name."_translit"]=$mg->fields->row[$this->field_name."_translit"]."".rand(0,90099);
       $count_title=  MGQuery::count($mg->collection,array($this->field_name=>$mg->fields->row[$this->field_name."_translit"]));
       if($count_title==0){
       $true=false;
       }
      }
     }
       return $_POST[$this->getNameField()];
   }else {

       return false;
   }

        }
        else {

        return false;
        }

return false;;
  }
  public function renderValue($value,$mg) {

  return $value;
  }
  function rus2translit($string) {

    $converter = array(

        'а' => 'a',   'б' => 'b',   'в' => 'v',

        'г' => 'g',   'д' => 'd',   'е' => 'e',

        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',

        'и' => 'i',   'й' => 'y',   'к' => 'k',

        'л' => 'l',   'м' => 'm',   'н' => 'n',

        'о' => 'o',   'п' => 'p',   'р' => 'r',

        'с' => 's',   'т' => 't',   'у' => 'u',

        'ф' => 'f',   'х' => 'h',   'ц' => 'c',

        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',

        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',

        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',



        'А' => 'A',   'Б' => 'B',   'В' => 'V',

        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',

        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',

        'И' => 'I',   'Й' => 'Y',   'К' => 'K',

        'Л' => 'L',   'М' => 'M',   'Н' => 'N',

        'О' => 'O',   'П' => 'P',   'Р' => 'R',

        'С' => 'S',   'Т' => 'T',   'У' => 'U',

        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',

        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',

        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',

        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

    );

    return strtr($string, $converter);

}

function str2url($str) {

    // переводим в транслит

    $str = $this->rus2translit($str);

    // в нижний регистр

    $str = strtolower($str);

    // заменям все ненужное нам на "-"

    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);

    // удаляем начальные и конечные '-'

    $str = trim($str, "-");

    return $str;

}


}
?>