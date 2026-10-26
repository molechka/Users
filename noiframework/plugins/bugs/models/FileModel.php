<?php

namespace bugs\models;
use NoiCore;
use ZipArchive;
use PHPExcel_Settings;
use MongoDate;
class FileModel{
static function getTotalMoney($document){
  $document['totalmoney']=count($document['results'])*$document['price'];
  return $document;
}
static function preParse($result){
$newarray=array();    
$thead=array();
if(count($result)>0){
  if(count($result[0])>0){
  foreach($result[0] as $value){
  $thead[]=$value;
  
  }    
  }  
}
 
if(count($thead)>0){
  $tmp_array=array();      
 foreach($thead as $val){
 
 $tmp_array[]="Исходное ".$val;
 $tmp_array[]="Результат ".$val;
 $tmp_array[]="Качество кода ".$val;
 
 

 
 }
  $newarray[]=$tmp_array;
}
 

$i=1;
 
while(isset($result[$i])){
$row=$result[$i];
if(count($row)){
  
 $tmp_array=array();   
 foreach($row as $val){
 $datemodel=  new DateModel();
 
 $isdate=$datemodel->isCorrectDate($val);
 
 if($isdate){
  $category=$datemodel->getCategory($val);   
  $tmp_array[]=$val;
  $tmp_array[]=$category;
  $tmp_array[]="Все ок,мы ничего не меняли";
  
 }else {
  $fiomodel=new FioModel();
  $fiomodel->start($val);
  $status=$fiomodel->getStatus();
  $tmp_array[]=$val;
  $tmp_array[]=$fiomodel->getFio();
  if($val===$fiomodel->getFio()){
   $tmp_array[]="Мы ничего не делали";   
  }else {
   $tmp_array[]="Мы удалили мусор";   
  }
 }
 
 }  
 if(count($tmp_array)>0){
 $newarray[]=$tmp_array;    
 }
}

$i++;    
}
 
return $newarray;
}
    static function generateFromArr($result){
      
 $result['results']=  FileModel::preParse($result['results']); 
   
  $doc = new \PHPExcel();
  $doc->setActiveSheetIndex(0);

  $doc->getActiveSheet()->fromArray($result['results'], null, 'A1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="your_name.xls"');
header('Cache-Control: max-age=0');
 
  // Do your stuff here
  $writer = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');

$writer->save('php://output'); 
 
 
    }
    static function isPay($array){
    $price=0;
    $elements=count($array);
    if($elements>0 and $elements<1000){
    $price=0.10;    
    }else if($elements>1000  and $elements<3000){
    $price=0.09;    
    }else if($elements>3000 and $elements<5000){
    $price=0.08;    
    }else if($elements>5000 and $elements<8000){
    $price=0.07;    
    }else if($elements>8000 and $elements<10000){
    $price=0.06;     
    }else if($elements>10000){
    $price=0.05;    
    }
   
    if($price>0.00){
//     $user=NoiCore::user()->load();   
//     $money=  \user\models\MManager::minus($user['_id']->__toString(), $price, 'оплата за обработку '.$elements." строк", 1,array());   
//      if($money){
//      $array_insert=array();
//      $array_insert['date']=new MongoDate;
//      $array_insert['count']=$elements;
//      $array_insert['user']=$user;
//      $array_insert['price']=$price;
//      NoiCore::app()->db()->insert($array_insert,"stats_pay");
//      }
//      return $money;
$uploaddir =DOCUMENT_ROOT."/tmp/files/";
$uploadfile = $uploaddir . basename($_FILES['file']['name']);

 
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    $document=array();
        $document['user']=NoiCore::user()->load();
        $document['results']=$array;
        $document['file']="/tmp/files/".basename($_FILES['file']['name']);
        $document['price']=$price;
        $document['ispay']=false;
        $document=NoiCore::app()->db()->insert($document,"documents_filtered",true);
        return $document;
} else {
 return false;
}
       
     
    }else {
      return false;  
    }
    }
   
    static function doArray($file){
        
 $tmp=pathinfo($file['name'], PATHINFO_EXTENSION);
 
 $file['extension']=$tmp;
 
 $result=false;
try
{   
     
    \PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
   
    if($file['extension']=='csv')
    {
        //use different reader for csv files
        $reader = \PHPExcel_IOFactory::createReader('CSV')
            ->setDelimiter(',')
            ->setEnclosure('"')
            ->setLineEnding("\n")
            ->setSheetIndex(0)
            ->load($file['tmp_name']); 
    }
    else if($file['extension']!="xls"  and $file['extension']!="xlsx"){
        
       return false; 
    }else 
    {
         
        $reader = \PHPExcel_IOFactory::load($file['tmp_name']);
        
    }
 
    $objWorksheet = $reader->setActiveSheetIndex(0);
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
    $result=array();
    
    //read from file
    for ($row = 1; $row <= $highestRow; ++$row)
    {
        $file_data = array();
        for ($col = 0; $col <= $highestColumnIndex; ++$col)
        {  
            
            $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue(); 
          if(strlen($value)>0){
            
            $file_data[$col]=trim($value);
            }
            
            
        }
        $result[] = $file_data;
    }
   
}
catch (Exception $e) {
 
  $result=false;
}
 
return $result;
    }
}
