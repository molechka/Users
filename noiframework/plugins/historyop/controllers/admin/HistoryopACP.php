<?php
use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
class HistoryopACP  extends CoreAdminControllerPlugin{

 public function __construct($site) {
     parent::__construct('historyop',$site);
      
 }
 public function actionList(){
 $title="Транзакции";
 if(isset($_GET['pop']) and is_string($_GET['pop'])){
if(isset($_GET['pop']) and $_GET['pop']=="2000"){

$title="Пополнение баланса";
}
if(isset($_GET['pop']) and $_GET['pop']=="2001"){
$title="Списание средств";
}
if(isset($_GET['pop']) and $_GET['pop']=="3002"){
$title="Купленные пакеты бинар";
}
if(isset($_GET['pop']) and $_GET['pop']=="3001"){
$title="Купленные пакеты матрица";
}
if(isset($_GET['pop']) and $_GET['pop']=="4001"){
$title="Продажа пакетных билетов";
}

 }else {
 if(isset($_GET['pop']) and is_array($_GET['pop'])){
 $title="Выплаты";
 }
 }
 $current_url=$this->getUrl("list");
 if(isset($_GET['pop'])){
 $current_url=$current_url."&pop=".$_GET['pop'];
 }
  $grid=new MongoGrid("historyop_collection",10,0,"asd",$title,$current_url);
     $fields=new GridField();
if(isset($_GET['search_field']) and isset($_GET['search_value'])){
 $_POST['search_field']=$_GET['search_field'];
 $_POST['search_value']=$_GET['search_value'];

}

if(isset($_POST['search_field']) and isset($_POST['search_value'])){
  $url=$this->getUrl('list')."&search_field=".$_POST['search_field']."&search_value=".$_POST['search_value'];
  $grid=new MongoGrid("historyop_collection",10,0,"asd",$title,$url);
}
     
      $fields->setFields(array("amount"));
      $fields->setField("amount", "string", "", array(),"Сумма",true, false);


      $fields->showid=false;
      $grid->setFields($fields);
if(isset($_GET['pop']) and is_string($_GET['pop'])){
   $grid->condition['pop']=(int)$_GET['pop'];
}
if(isset($_GET['pop']) and is_array($_GET['pop'])){
if(count($_GET['pop'])>0){
 $grid->condition['$or']=array();
 foreach($_GET['pop'] as $val){
 $grid->condition['$or'][]=array('pop'=>(int)$val);
 }
}
}
      $operation=new GridOperation();
   $denied_access=array('update','delete','create');
      $available_access=array('list');

      $operation->denied_access=$denied_access;

      $operation->available=$available_access;


      $operation->default_operation='list';

      $grid->setOperations($operation);
      $grid->view->available['list']=  $this->getPluginPath("standart_list");
      $grid->view->available['update']=$this->getPluginPath("standart_update");
      $grid->view->available['delete']=$this->getPluginPath('standart_delete');
      $grid->view->available['create']= $this->getPluginPath('standart_create');

      $newdata=array('site'=>$this->site_data);

return $grid->render();
 }



}


