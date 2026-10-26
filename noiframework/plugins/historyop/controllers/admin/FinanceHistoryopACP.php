<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use historyop\models\Finance;
class FinanceHistoryopACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('historyop',$site);
     if(!NoiCore::admin()->haveAccess("p_historyop")){  
         exit;  
       }
 }
 
 public function actionUpdate($last_id){
 $result=NoiCore::app()->db()->query(array(),"historyop_collection",array('last_id'=>(int)$last_id),array('_id'=>-1));
 if(isset($result[0]['_id'])){
 $data=array();
 $data['his']=$result[0];
 return $this->render("update",$data);
 
 }
 }
 public function actionDoupd($last_id){
  $result=NoiCore::app()->db()->query(array(),"historyop_collection",array('last_id'=>(int)$last_id),array('_id'=>-1));
 if(isset($result[0]['_id']) and isset($_POST['comment'])){
 $array=array('comment'=>strip_tags($_POST['comment']));
 NoiCore::app()->db()->update($array,"historyop_collection",array('last_id'=>(int)$last_id));
 }
     NoiCore::app()->redirect(NoiCore::app()->getRoute("p_historyop/finance/index"));
     exit;;
 }
 public function actionIndex(){
   $condition=array();  
   $itogo=null;
   if(isset($_GET['date_start']) and strlen($_GET['date_end']) and strlen($_GET['date_start'])>1 and strlen($_GET['date_end'])>1){
     $start_time=strtotime($_GET['date_start']);
    $end_time=  strtotime($_GET['date_end']);
    $condition['date']=array('$gte'=>new MongoDate($start_time),'$lte'=>new MongoDate($end_time));    
     }
    if(isset($_GET['login_or_id']) and strlen($_GET['login_or_id'])>1){
      if(is_numeric($_GET['login_or_id'])){
          
      $condition['user.last_id']=(int)$_GET['login_or_id'];    
      }else {
      $condition['user.login']=$_GET['login_or_id'];    
      }    
      }
   if(isset($_GET['id_trans']) and is_numeric($_GET['id_trans'])){
   $condition['last_id']=(int)$_GET['id_trans'];    
   }   
   if(isset($_GET['type']) and $_GET['type']=="buyvouchers"){
   $condition['data.buyvaucher']=1;    
   }
   if(isset($_GET['type']) and $_GET['type']=="backoffice"){
   $condition['data.backoffice']=1;    
   }
   if(isset($_GET['type']) and $_GET['type']=="incomming"){
   $condition['op']="plus";     
   $condition['data.type']="payment";       
   }
    if(isset($_GET['type']) and $_GET['type']=="incomming2"){
   $condition['op']="minus";     
   $condition['data.type']="payment";       
   }
    if(isset($_GET['type']) and $_GET['type']=="minus"){
   $condition['op']="minus";     
      
   }
   if(isset($_GET['type']) and $_GET['type']=="leaderbonus" ){
   $condition['data.leaderbonus']=1;
   
   }
   if(isset($_GET['type']) and $_GET['type']=="linebonus"){
   $condition['data.linebonus']=1;
   
   }
   if(isset($_GET['type']) and $_GET['type']=="advbonus"){
   $condition['data.advbonus']=1;    
   }
   if(isset($_GET['type']) and $_GET['type']=="binarbonus"){
   $condition['data.binarbonus']=1;    
   } 
   if(isset($_GET['type']) and $_GET['type']=="ustr"){
   $condition['data.ustr']=1;    
   }
    if(isset($_GET['type']) and $_GET['type']=="usermoney"){
   $condition['data.usermoney']=1;    
   }
   if(isset($_GET['type']) and $_GET['type']=="vauchersumm"){
   $condition['data.vauchersumm']=1;     
   }
   if(isset($_GET['type']) and $_GET['type']!="all"){
   $condition['data.'.$_GET['type']]=1;    
   }
    if(isset($_GET['isxls']) and  (int)$_GET['isxls']===1){
      $this->toXls($condition);
      
      exit;
     }
   $itogo=Finance::getItogo($condition);
   $data=array();
   $data['itogo']=$itogo;
   $data['rows']=NoiCore::app()->db()->query(array(),"historyop_collection",$condition,array('_id'=>-1),25,NoiCore::c("ppaginator")->getOffset(25));
   $data['count']=NoiCore::app()->db()->count("historyop_collection",$condition);
   $data['pages']=NoiCore::c("ppaginator")->show($data['count'],25);
   return $this->render("index",$data);
 }
 public function getAll($condition,$count,$offset=0,$total_result=array()){
  $results=NoiCore::app()->db()->query(array(),'historyop_collection',$condition,array('_id'=>-1),100,$offset); 
 if(count($results)>0){
  $total_result=  array_merge($total_result,$results);
  $total_count=$offset+count($results);
 
 
  if($count>$total_count){
  return $this->getAll($condition, $count,$total_count,$total_result);    
  }
 }
 return $total_result;
 }
 public function toXls($condition=array()){
    
 
/** PHPExcel */
require_once PATH_TO_ENGINE.'/extensions/phpexcel/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
 $objPHPExcel->setActiveSheetIndex(0);						 
// Add some data

$objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'логин/id юзера');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Баланс');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Операция');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Сумма');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Всего');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Событие');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Дата');
 
// Miscellaneous glyphs, UTF-8
 


$i=2;

 $counts=NoiCore::app()->db()->count("historyop_collection",$condition);;
  //$results=$this->getAll($condition,$counts);
 //$results=NoiCore::app()->db()->query2(array(),'historyop_collection',$condition,array('_id'=>-1));
 
 $results=NoiCore::app()->db()->all("historyop_collection",$condition);
 
 
 $itogo=Finance::getItogo($condition);
foreach($results as $row){  
 $his=$row;
  $type_op="Зачисление";
                                    if($his['op']=="minus"){
                                    $type_op="Списание";
                                    }   
                                     $igoto=0;
                                    if($his['op']=="plus"){
                                    $itogo=$his['user']['user_money']+$his['amount'];
                                    }else {
                                     $itogo=$his['user']['user_money']-$his['amount'];
                                    }
                                     $his['comment']=$this->lang($his['comment']);
                                    if(isset($his['data']['vauchers'])){
                                    $his['comment']=str_replace("{n}",$his['data']['vauchers'],$his['comment']);     
                                    }
                                    if(isset($his['data']['vauchers'])){
                                    $his['comment']=str_replace("{n}",$his['data']['vauchers'],$his['comment']);     
                                    } else if(isset($his['data']['linebonus']) and isset($his['data']['who'])){
                                     $his['comment']=str_replace("{n}",$his['data']['level'],$his['comment']);     
                                     $his['comment']=str_replace("{m}",$his['data']['who'],$his['comment']);    
                                    }else if(isset($his['data']['who']) and isset($his['data']['percent']) and isset($his['data']['qualification_name'])) {
                                     $his['comment']=str_replace("{n}",$his['data']['qualification_name'],$his['comment']);     
                                     $his['comment']=str_replace("{m}",$his['data']['percent'],$his['comment']);   
                                     $his['comment']=str_replace("{s}",$his['data']['who'],$his['comment']);   
                                    }else if((isset($his['data']['bustr']) or isset($his['data']['ustr'])) and isset($his['data']['who'])){
                                     $his['comment']=str_replace("{m}",$his['data']['who'],$his['comment']);    
                                    }else if(isset($his['data']['type']) and $his['data']['type']=="payment" and isset($his['data']['title2'])){
                                    $his['comment']=str_replace("{name}",$his['data']['title2'],$his['comment']);       
                                    }else if(isset($his['data']['type']) and $his['data']['type']=="payment" and isset($his['data']['title'])){
                                    $his['comment']=str_replace("{name}",$his['data']['title'],$his['comment']);       
                                    } 
                                    
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $row['last_id']);
 
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $row['user']['login']."/".$row['user']['last_id']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $row['user']['user_money']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $type_op);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $his['amount']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $itogo); 
  
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $his['comment']);   
 $objPHPExcel->getActiveSheet()->setCellValue("H".$i,date('Y/m/d',$his['date']->sec));
 
  
 $i++;   
}
  $objPHPExcel->getActiveSheet()->setCellValue("A".$i,"Всего операций - ");
 $objPHPExcel->getActiveSheet()->setCellValue("B".$i,$counts);
 $i++;
 if(isset($itogo) and !is_null($itogo)){
   $objPHPExcel->getActiveSheet()->setCellValue("A".$i,"Итого - ");
 $objPHPExcel->getActiveSheet()->setCellValue("B".$i,$itogo);
 }
        
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

    $sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    /** @var PHPExcel_Cell $cell */
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
}
// Rename sheet
 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
 
// Redirect output to a client’s web browser (Excel2007)
 

 
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
$objWriter->setOffice2003Compatibility(true);
if(file_exists(DOCUMENT_ROOT.'tmp/history.xls')){
     
 unlink(DOCUMENT_ROOT.'tmp/history.xls');   
}
$objWriter->save(DOCUMENT_ROOT.'tmp/history.xls');
 
 
 $file=DOCUMENT_ROOT.'tmp/history.xls';
 if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
 
exit;   
    }
 
}

