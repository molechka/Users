<?php
/*
 * класс для работы с Email;
 */

class EmailGrid{
    public  $collection;
    public  $field_email;
    public  $field_title;
    public  $field_text;
    public function __construct($collection,$field_email,$field_title,$field_text) {
     $this->collection=$collection;
     $this->field_email=$field_email;
     $this->field_text=$field_text;
     $this->field_title=$field_title;
    }
    public function execute(){
        
    }

}

