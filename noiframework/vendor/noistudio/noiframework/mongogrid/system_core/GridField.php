<?php
namespace noicms\mongogrid\system_core;
use noicms\mongogrid\GridConf;

use noicms\mongogrid\plugins\type\fields as import;
 

class GridField{
 
    public $array_fields;
    public $array_type;
    public $not_show;
    public $list_type=array();
    public $render;
    public $collection;
    public $page_item=25;
    public $offset=0;
    public $model;
    public $mg;
    public $showid=false;
    public $row=array();
    private $plugins=array();
    public $field_start_name="field_";
    public function __construct() {
   
    $this->model=new MGQuery();
    $dir    = PATH_TO_ENGINE.'/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/';
    $plugins = scandir($dir);

    $i=0;
    while(isset($plugins[$i])){
     if(strlen($plugins[$i])>2){
         $newname=  str_replace("Field.php", "", $plugins[$i]);
         $newname=mb_strtolower($newname);
         $this->plugins[count($this->plugins)]=$newname;
     }
     $i++;
    }
    
   $conf=new GridConf();

   $this->field_start_name=$conf->name_field;
    }

    public function setFields($array){
   
     if(is_array($array)){
     $this->array_fields=$array;
     }
    }
    public function clearTrash(){
      if(is_array($this->mg->status->old_result) and isset($this->mg->status->old_result)){

      }
    }
    /*
     * included_array
     * array('collection'=>'name_collection','select'=>array(_id'),condition'=array('_id'=>new MongoId('123213213213')),
     */
    public function setField($name,$type,$default_value="",$included_opt=array(),$label=null,$required=false,$unique=false){
    if(in_array($type, $this->list_type) or in_array($type, $this->plugins)){
    
        if($label==null){
    $label=$name;
    }

    if(in_array($type,$this->plugins)){
    $classname= "\\noicms\\mongogrid\\plugins\\type\\fields\\".ucfirst($type)."Field";
 
//    include $_SERVER['DOCUMENT_ROOT'].NOIPRODUCT_FOLDER."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/".$classname.".php";
  
    /*
     *   $plugin_opt=$included_opt;
     $plugin_opt['label']=$label;
    $plugin_opt['required']=$required;
    $plugin_opt['unique']=$unique;
     */
    $plugin_opt=array('label'=>$label,"required"=>$required,"unique"=>$unique,'default_value'=>$default_value);
    if(isset($included_opt)){
     foreach($included_opt as $key => $value){
       $plugin_opt[$key]=$value;
     }
    }
    $plugin_opt['post_name_field']=$this->field_start_name;
    $included_opt['plugin']=new $classname($name,$plugin_opt);
    }
    $this->array_type[$name]=array('type'=>$type,'default'=>$default_value,'opt'=>$included_opt,'label'=>$label,'unique'=>$unique,'required'=>$required);
    

    }
    }
    public function renderInput(){
       
      $result=array();
     
     foreach($this->array_fields as $field){
      $result[$field]="";
     }
     $this->generateInput($result);
    }
     public function generateInput($result){
        if(isset($result)){
           foreach($result as $name=>$value){
            
             $opt_array=$this->array_type[$name]['opt'];
         if(isset($opt_array['plugin'])){
         if(isset($this->mg->result[0][$name]) and $this->mg->operations->default_operation=="update"){
         $value=$this->mg->result[0][$name];
         }else if(isset($_POST[$opt_array['plugin']->getNameField()])){
           $value=$_POST[$opt_array['plugin']->getNameField()];

         }else {
         $value="";
         }
   
   
         $input=$opt_array['plugin']->getInput($value,$this->mg);
         $this->render[$name]=$input;
         }
           }
        }
     }
     public function generateInput2($result){


        foreach($result as $name=>$value){

        if(isset($this->mg->result[0][$name]) and $this->mg->operations->default_operation=="update"){
         $value=$this->mg->result[0][$name];
        }else {
         $value="";
        }
        if(!isset($value) and isset($this->array_type[$name]['default']) and $this->array_type[$name]['type']=="hidden"){

        $value=$this->array_type[$name]['default'];
        }
        if($name!="_id"){

         $isrequired=false;
        if(isset($this->array_type[$name]['required']) and $this->array_type[$name]['required']==true){
        $isrequired=true;
        }
        $htmlrequired=" ";
        if($isrequired==true){
        $htmlrequired=" required='required'";
        }
        $type="string";
        if(isset($this->array_type[$name]['type'])){
        $type=$this->array_type[$name]['type'];
        }
 
        if($type=="int"){
        $input="<input type='number' name='field_".$name."' ".$htmlrequired." value='".$value."'>";
        }else if($type=="select"){
        $select_data=$this->array_type[$name]['opt'];
        $value="";
         if(isset($this->mg->result[0][$name]) and $this->mg->operations->default_operation=="update"){
         $value=$this->mg->result[0][$name];
        }
        $input="<select name='field_".$name."' ".$htmlrequired.">";
        foreach($select_data as $row){
        $selected="";
        if($value==$row['value']){
        $selected="selected='selected'";
        }
        $input.="<option ".$selected." value='".$row['value']."'>".$row['title']."</option>";
        }
        $input.="</select>";
        }else if($type=="data"){
           $result=$this->model->getList($this->array_type[$name]['opt']['select'], $this->array_type[$name]['opt']['collection'],$this->array_type[$name]['opt']['condition']);
          $value="";
         if(isset($this->mg->result[0][$name]) and $this->mg->operations->default_operation=="update"){
         $value=$this->mg->result[0][$name];
        }
 
         $input="<select name='field_".$name."'>";
        foreach($result as $row){
        $selected="";
         if($row['_id']->__toString()==$value){
          
        $selected="selected='selected'";
         }
        
        $tmp_option="<option ".$selected." value='".$row['_id']->__toString()."'>".$row[$this->array_type[$name]['opt']['select'][0]]."</option>";
        $input.=$tmp_option;
        }
         $input.="</select>";
        }else if($type=="string" or  $type=="username"){
        $input="<input type='text' name='field_".$name."' ".$htmlrequired." value='".$value."'>";
        }else if($type=="textarea" or $type=="encrypt"){
        if($type=="encrypt"){
        $key_forps=$this->array_type[$name]['opt']['key'];
        if(isset($this->array_type[$name]['opt']['field']) and $this->array_type[$name]['opt']['field']==1){
         $key_forps=$this->array_type[$key_forps]['default'];
        }
       if($this->mg->operations->default_operation=="update"){
        $tmp= GridStr::decode($value, $key_forps);
        $value=$tmp;
       }
        } 
        $input=Yii::app()->getController()->widget('ext.markitup.EMarkitupWidget',array(
    'name'=>'field_'.$name,
    'value'=>$value,
    // Redactor options
    'options'=>array(),
),true);
       $input=$input."
        <script>$(document).ready(function()	{
	$('#bbcode').markItUp(mySettings);

	$('#emoticons a').click(function() {
		emoticon = $(this).attr('title');
		$.markItUp( { replaceWith:emoticon } );
		return false;
	});

	 
});</script>";
     $cs=Yii::app()->clientScript;
     $assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.markitup.assets.sets.markdown'));
     $cs->registerCSSFile($assetUrl.'/style.css');
     $cs->registerScriptFile($assetUrl.'/set.js');
       // $input="<textarea cols='90' rows='4' name='field_".$name."'  ".$htmlrequired." >".$value."</textarea>";
        }else if($type=="image"){
        $input="<input type='file' name='field_".$name."'".$htmlrequired.">";
        }else if($type=="email"){
         $input="<input type='email' name='field_".$name."'".$htmlrequired." value='".$value."'>";
        }else if($type=="password"){
        $input="<input type='password' name='field_".$name."'".$htmlrequired." >";
        $input.="<input type='password' name='field_".$name."_2'".$htmlrequired.">";
        }else if($type=="hidden"){
         $input="";
        }else {
         $opt_array=$this->array_type[$name]['opt'];
         if(isset($opt_array['plugin'])){
       
         $input=$opt_array['plugin']->getInput($value,$this->mg);

         }
        }

        $this->render[$name]=$input;



        }
        }

      

}
public function getArrayQuery($validate=false,$isupdate=false){
   
   $array_insert=array();
  if(isset($this->array_fields)){
      foreach($this->array_fields as $kkk=>$field){
          
       
      $field_data=$this->array_type[$field]['opt'];

       if(isset($field_data['plugin'])){
        $this->row=$array_insert;
       if(!isset($value)){
        $value="";
       }
     

       // $result_operation_plugin=$field_data['plugin']->setInput($value,$this->mg);
       $result_operation_plugin=$field_data['plugin']->setInput("",$this->mg);
       
       $array_insert=$this->row;

        if($result_operation_plugin===false and !is_string($result_operation_plugin)  and $this->array_type[$field]['required']==true){
         if($validate==true){

         $result_validate['status']=false;
         $result_validate['message_notify']="Неверно заполнено поле  -".$this->array_type[$field]['label'];
         $result_validate['route']="";
        
         return $result_validate;
         }
         $value="";
         if(isset($this->array_type[$field]['default'])){
         $value=$this->array_type[$field]['default'];
         }
         if(isset($this->mg->status->old_result[$field])){
         $value=$this->mg->status->old_result[$field];
         }

        }else {
 if($result_operation_plugin===false and $isupdate==true){
     
 }else {
      $value=$result_operation_plugin;
            if($field=="password"){

         }
         
         $array_insert[$field]=$value;
         $this->row=$array_insert;   
 }
     
        }
        }else {
         if($validate==true){

         $result_validate['status']=false;
         $result_validate['message_notify']="Неверно заполнено поле  -".$this->array_type[$field]['label'];
         $result_validate['route']="";

         return $result_validate;
         }
        }
     
        if(isset($this->array_type[$field]['unique']) and $this->array_type[$field]['unique']==1){

     $condition=array($field=>$_POST[$this->field_start_name."".$field]);
     $fields=array("_id",$field);


  //   $result=$this->model->getList($fields, $this->mg->collection,$condition,$this->mg->page_item,$this->mg->offset);
 
     $result=  MGQuery::execute($fields, $this->mg->collection, $condition, array('_id'=>-1),1,0);

     if(isset($result[0]['_id'])   and count($result)>0){
         if($this->mg->operations->default_operation=="update"  and $result[0]['_id']->__toString()==$this->mg->status->old_result['_id']->__toString()){

         }else {
        $result_validate['status']=false;

         $result_validate['message_notify']="Ошибка:поле  ".$this->array_type[$field]['label']." уже есть в базе!";
         $result_validate['route']="";
         return $result_validate;
         }
     }

        }
      }
      return $array_insert;
  }
}
public function getArrayQuery2($validate=false){
     $result_validate=array('status'=>true,'message_notify'=>"",'route'=>"");
     $array_insert=array();

       foreach($this->array_fields as $field){
       if(isset($this->array_type[$field]['type']) and $this->array_type[$field]['type']=="hidden"){

       $array_insert[$field]=$this->array_type[$field]['default'];
       }else {
        if($field=="to_username"){
         if(isset($this->array_type[$field]['opt']) and isset($_POST['field_'.$field])){
         $opt=$this->array_type[$field]['opt'];  
         if(isset($opt['exist']) and $opt['exist']==0 and isset($opt['data']['check'])){
         $check_data=$opt['data']['check'];
         if(isset($check_data['select']) and isset($check_data['collection']))
         $check_data['condition']=array($check_data['select'][0]=>$_POST['field_'.$field]);
          $result=$this->model->getList($check_data['select'], $check_data['collection'],$check_data['condition']);
         if(isset($result[0][$check_data['select'][0]])){

         }else {
         if($validate==true){
            
         $result_validate['status']=false;
         $result_validate['message_notify']="Неверное значение поля -".$this->array_type[$field]['label'];
         $result_validate['route']="";
         return $result_validate;
         }
         }

         }
         }

     
        }
        $name_field=$field;
        $type="string";
        if(isset($this->array_type[$field]['type'])){
         $type=$this->array_type[$field]['type'];
        }
        $value="";
        if($type=="int"){
        $value=0;
        }

        $field_data=$this->array_type[$field]['opt'];
        if(isset($field_data['plugin'])){
        $this->row=$array_insert;
      
        $result_operation_plugin=$field_data['plugin']->setInput($value,$this->mg);
        $array_insert=$this->row;
       
        if($result_operation_plugin===false and !is_string($result_operation_plugin)  and $this->array_type[$field]['required']==true){
         if($validate==true){
         
         $result_validate['status']=false;
         $result_validate['message_notify']="Неверно заполнено поле  -".$this->array_type[$field]['label'];
         $result_validate['route']="";
         
         return $result_validate;
         }
         $value="";
         if(isset($this->array_type[$field]['default'])){
         $value=$this->array_type[$field]['default'];
         }
         if(isset($this->mg->status->old_result[$field])){
         $value=$this->mg->status->old_result[$field];
         }
         
        }else {

         $value=$result_operation_plugin;
            if($field=="password"){
         
         }
         $array_insert[$field]=$value;
         $this->row=$array_insert;
        }
        }

        if(isset($_POST['field_'.$field])){
        $value=$_POST['field_'.$field];
       // echo "{".$type."}";
      
        if($type=="int"){
        $value=(int)$value;
        }
        }else if($validate==true) {
         if(isset($this->array_type[$field]['required']) and  $this->array_type[$field]['required']==1){
         $field_data=$this->array_type[$field]['opt'];

         if(!isset($this->row[$field])){
         
         $result_validate['status']=false;
         $result_validate['message_notify']="Вы не заполнили обязательное поле -".$this->array_type[$field]['label'];
         $result_validate['route']="";
         return $result_validate;
         }
         }

        }
        if($type=="image"){
        $image=new GridImage();
        
        $value=$image->getBlob('field_'.$field,$this->array_type[$field]['opt']['type']);
        if(strlen($value)==0 and isset($this->array_type[$field]['default'])){
        $value=$this->array_type[$field]['default'];
        }
        }else if($type=="hidden"){
        $value=$this->array_type[$field]['default'];
        }else if($type=='select'){
        $validate=true;

        foreach($this->array_type[$field]['opt'] as $roo){


        if(isset($_POST['field_'.$field]) and $_POST['field_'.$field]==$roo['value']){

        $validate=false;
        break;
        }

        }
       
         if($validate==true){
            $result_validate['status']=false;
         $result_validate['message_notify']="Неверное значение Поля ".$this->array_type[$field]['label']."";
         $result_validate['route']="";
         return $result_validate;
        }

        }else if($type=="encrypt"){
        $key_forstr=$this->array_type[$field]['opt']['key'];
        if(isset($this->array_type[$field]['opt']['key']) and $this->array_type[$field]['opt']['field']==1){
        $key_forstr=$array_insert[$this->array_type[$field]['opt']['key']];
        }
      
        $tmp=  GridStr::encode($_POST['field_'.$field], $key_forstr);
        $value=$tmp;
        }else if($type=="array"){
        $tmp=explode(",",$_POST['field_'.$field]);
        $value=$tmp;
        }else if($type=="password"){

        if(!isset($_POST['field_'.$field]) or !isset($_POST['field_'.$field.'_2']) or ($_POST['field_'.$field]!=$_POST['field_'.$field."_2"])){
        if($validate==true){
            $result_validate['status']=false;
         $result_validate['message_notify']="Поля ".$this->array_type[$field]['label']." и ".$this->array_type[$field]['label']."-2 не совпадают";
         $result_validate['route']="";
         return $result_validate;
        }
        }else {
        $value=hash('sha512',$_POST['field_'.$field]);
        }
        }else if($type=="email"){

         if((filter_var($_POST['field_'.$field], FILTER_VALIDATE_EMAIL))){
         $validate=false;
         }else {
         $validate=true;
         if($validate==true){
         $result_validate['status']=false;
         $result_validate['message_notify']="Поле ".$this->array_type[$field]['label']." введено не верно";
         $result_validate['route']="";
         return $result_validate;
         }
         }
        }else if($type=="username"){
          $allowed = array(".", "-", "_");

  if ( ctype_alnum( str_replace($allowed, '', $_POST['field_'.$field] ) ) ) {
 
  } else {
    $result_validate['status']=false;
    $result_validate['message_notify']="Поле ".$this->array_type[$field]['label']." введено не верно";
    $result_validate['route']="";
    return $result_validate;
  }
        }else if($type=="textarea"){
            $parser=new CMarkdownParser;
            $value = $parser->safeTransform($_POST['field_'.$field]);
          
        }

        if(isset($this->array_type[$field]['unique']) and $this->array_type[$field]['unique']==1){
     
     $condition=array($field=>$_POST['field_'.$field]);
     $fields=array("_id",$field);

  
  //   $result=$this->model->getList($fields, $this->mg->collection,$condition,$this->mg->page_item,$this->mg->offset);
     $result=  MGQuery::execute($fields, $this->mg->collection, $condition, array('_id'=>-1),1,0);
   
     if(isset($result[0]['_id'])   and count($result)>0){
         if($this->mg->operations->default_operation=="update"  and $result[0]['_id']->__toString()==$this->mg->status->old_result['_id']->__toString()){

         }else {
        $result_validate['status']=false;

         $result_validate['message_notify']="Ошибка:поле  ".$this->array_type[$field]['label']." уже есть в базе!";
         $result_validate['route']="";
         return $result_validate;
         }
     }
     
        }
         $array_data_field=array();
      if(isset($this->array_type[$field]['type']) and  $this->array_type[$field]['type']=="data"){
      $tmp=$this->array_type[$field]['opt'];

      $tmp['condition']=array('_id'=>new MongoId($_POST['field_'.$field]));
      $result=$this->model->getList($tmp['select'], $tmp['collection'],$tmp['condition']);
      if(isset($result[0][$tmp['select'][0]])){
      $array_insert[$field."_title"]=$result[0][$tmp['select'][0]];
      }

     }
       if(!isset($this->array_type[$field]['opt']['plugin'])){
        $array_insert[$field]=$this->mg->xss->purify($value);
       }
       }
       }


       
       if($validate==true){
         if(strlen($result_validate['route'])==0 and strlen($result_validate['message_notify'])==0){
          return $array_insert;
         }else {
          return $result_validate;
         }
       }
       $this->row=$array_insert;
   
       return $array_insert;
     }
     function clearAfter(){
         foreach($this->array_type as $field){
          if(isset($field['opt']['plugin'])){
              $field['opt']['plugin']->afterEvent($this->mg);
          }
         }
     }
}
?>