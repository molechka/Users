<?php
/*
 * Типы Mysql:
 * TINYINT Очень маленькое целое число
 * SMALLINT Маленькое целое число
 * MEDIUMINT Среднее целое число
 * INT или INTEGER  Целое число
 * BIGINT  Большое целое число
 * FLOAT Малое (одинарной точности) число с плавающей запятой. Не может быть числом без знака
 * DOUBLE,
DOUBLE PRECISION,
REAL Нормальное (двойной точности) число с плавающей запятой. Не может быть числом без знака
 * DECIMAL,
NUMERIC Распакованное число с плавающей запятой
 * DATE  Дата
 * DATETIME Дата и время
 * TIMESTAMP Дата и время
 * TIME Время
 *  YEAR  Год в 2- или 4- хцифровом виде (4 цифры по-умолчанию)
 * CHAR Строка фиксированной длины, которая справа дополняются пробелами до указанной длины, при хранении
 * VARCHAR  Строка переменной длины. Примечание: конечные пробелы удаляются при сохранении (в отличие от спецификации ANSI SQL).
 * TINYBLOB,
TINYTEXT BLOB или ТЕХТ с максимальной длиной 255 (2^8 - 1) символов.
 * BLOB,
TEXT     BLOB или ТЕХТ с максимальной длиной 65535 (2^16 - 1) символов.
 * MEDIUMBLOB,
MEDIUMTEXT BLOB или ТЕХТ с максимальной длиной 16777215 (2^24 - 1) символов.
 * LONGBLOB,
LONGTEXT BLOB или ТЕХТ с максимальной длиной 4294967295 (2^32 - 1) символов.
 * ENUM Перечисление
 * SET  Набор
 */
class MysqlQuery{
    static public function execute($select,$collection,$condition=array(),$sort=array('_id'=>-1),$limit=25,$offset=0){
    $sql_command="SELECT ".MysqlQuery::fromArraytoString($select)." from ".$collection." ".MysqlQuery::fromConditiontoString($condition)."";

    }
    static public function fromConditiontoString($condition){
    if(isset($condition) and is_array($condition)){
    if(count($condition)>0){
    $sql="where ";
    $i_n=0;
    foreach($condition as $key=>$value){
    $tmp_field=str_replace("$","",$key);
    if($key==$tmp_field and !is_array($value)){
    $sql.=" ".$key."=".$value."";
    if($i_n>0){
    $sql.=" and ".$key."=".$value."";
    }else {
    $sql.=" ".$key."=".$value."";
    }
    $i_n++;

    }
    }
    return $sql;
    }
    }else {
    return "";
    }
    }
    static public function createTable($table_name,$array){

$sql = "CREATE TABLE `".$table_name."` ( ";
if(isset($array) and count($array)>0){
foreach ($array as $field_name=>$field) {
    $type=  MysqlQuery::getMysqlType($field);
    $sql .= "`{$field_name}` {$type},";
}
$sql .= ");";
}
    }
    static public function getMysqlType($var){
   if(is_numeric($var)){
   return  "int";
   }else if(is_array($var)){
   return   "blob";
   }else if(strlen($var)<100){
   return "varchar 100";
   }else {
   return "text";
   }


    }
    static public function fromArraytoString($select){
    $text_field="";
    if(isset($select) and is_array($select)){
   if(count($select)>0)    {
    foreach($select as $key=>$field){
    $next_key=$key+1;
    if(!isset($select[$next_key])){
    $text_field=$text_field."".$field;

    }else {
    $text_field=$text_field."".$field.",";
    }

    }
   }else {
    $text_field="*";
   }
   return $text_field;
    }
    }
}
?>