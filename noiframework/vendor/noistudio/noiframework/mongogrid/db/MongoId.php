<?php
class MongoId{
  public $id=null;
  function __construct($id="") {

  if($id==""){
   $id=$this->randomGenerator();
  }

  $this->id=$id;

  }
  public function __toString() {
  return $this->id;

  }
  public function randomGenerator(){
  $array_words=array("q","w","e","r","t","y","u","i","o","p","a","s","d","f","g","h","j","k","l","z","x","c","v","b","n","m","0","1","2","3","4","5","6","7","8","9");
  $type_id="53073438951d9b8c61000003";
  $string="";
  $i=0;
  $count_len=count($array_words);
  $count_len--;
  while($i!=24){
  $string.=$array_words[rand(0, count($count_len))];
  $i++;
  }
return $string;
  }
   public static function __set_state($an_array) // С PHP 5.1.0
    {

       if(isset($an_array['id'])){
        $obj = new MongoId($an_array['id']);

       }else {
       $obj = new MongoLite\MongoId;
       }
        return $obj;
    }
}

