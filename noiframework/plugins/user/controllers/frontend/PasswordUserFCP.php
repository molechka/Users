<?php
use noicms\mongogrid\OneField;
class PasswordUserFCP extends CoreFrontendControllerPlugin {
public $password_field=array();
    public function __construct($route,&$cur) {
      parent::__construct("user",$cur,$route);
    if(!$this->user()->isLogin()){
       $this->redirect("/");
    }
    $fields=$this->get_value("fields");
    $main=$this->get_value();
    $field_login=array();
    $field_password=array();
    if(isset($fields) and count($fields)>0){
    foreach($fields as $field){
     if(isset($field['is_login']) and $field['is_login']==1){
     $field_login=$field;
     }
        if(isset($field['is_password']) and $field['is_password']==1){
     $this->password_field=$field;
     }
    }
    }
    }
    public function actionIndex(){
   
    

    }
     public function rand_passwd( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) {
    return substr( str_shuffle( $chars ), 0, $length );
}

 public function actionChangephone(){
    $user=NoiCore::user()->load();    
    if(!isset($_POST['newphone']) or !isset($_POST['newphone2'])){
$array=array('type'=>'error','message'=>"Вы не ввели новый телефон");
    echo json_encode($array);
    exit;
    
    }
    if(!isset($_POST['code'])){
    $array=array('type'=>'error','message'=>"Вы не ввели код подтверждения");
    echo json_encode($array);
    exit;
    }
    if(isset($_POST['code']) and strlen($_POST['code'])<=0){
  $array=array('type'=>'error','message'=>"Вы не ввели код подтверждения");
    echo json_encode($array);
    exit;
    }
    if(strlen($_POST['newphone'])<=2){
   $array=array('type'=>'error','message'=>"Вы не ввели новый телефон");
    echo json_encode($array);
    exit;
    }
    
    if($_POST['newphone']!=$_POST['newphone2']){
    $array=array('type'=>'error','message'=>"Телефоны не совпадают");
    echo json_encode($array);
    exit;
       
    }
    $email=  strtolower($_POST['newphone']);
    $count=NoiCore::app()->db()->count("cms_users",array('phone'=>$email));
    
    if($count==0){
     if(isset($user['code_check_phone']) and (int)$_POST['code']==$user['code_check_phone']){   
    $array_update=array();
    $array_update['phone']=$email;
    $array_update['code_check_phone']="";
    NoiCore::user()->update($array_update);
    $array=array('type'=>'success','message'=>"Телефон успешно обновлен");
    echo json_encode($array);
    exit;
     }else {
       $array=array('type'=>'error','message'=>"Код неправильный!");
    echo json_encode($array);
    exit;
     }
    }else {
 $array=array('type'=>'error','message'=>"Телефон уже существует в базе");
    echo json_encode($array);
    exit;   
    }
    exit;
    }
    public function actionChangemail(){
    $user=NoiCore::user()->load();    
    if(!isset($_POST['newemail']) or !isset($_POST['newemail2'])){
    $array=array('type'=>'error','message'=>"Вы не ввели новый email");
    echo json_encode($array);
    
    
     
    exit;
    
    }
    if(!isset($_POST['code'])){
      $array=array('type'=>'error','message'=>"Вы не ввели код подтверждения");
    echo json_encode($array);
    
    
     
    exit;   
    
    }
    if(isset($_POST['code']) and strlen($_POST['code'])<=0){
  $array=array('type'=>'error','message'=>"Вы не ввели код подтверждения");
    echo json_encode($array);
    exit;
    }
    if(!filter_var($_POST['newemail'],FILTER_VALIDATE_EMAIL)){
    $array=array('type'=>'error','message'=>"Вы не ввели новый email");
    echo json_encode($array);
    exit;
    }
    if(!filter_var($_POST['newemail'],FILTER_VALIDATE_EMAIL)){
   $array=array('type'=>'error','message'=>"Вы не ввели новый email");
    echo json_encode($array);
    exit;
    }
    if($_POST['newemail']!=$_POST['newemail2']){
   $array=array('type'=>'error','message'=>"Email не совпадает");
    echo json_encode($array);
    exit;
       
    }
    $email=  strtolower($_POST['newemail']);
    $count=NoiCore::app()->db()->count("cms_users",array('email'=>$email));
    
    if($count==0){
     if(isset($user['code_check_email']) and (int)$_POST['code']==$user['code_check_email']){   
    $array_update=array();
    $array_update['email']=$email;
    $array_update['code_check_email']="";
    NoiCore::user()->update($array_update);
   $array=array('type'=>'success','message'=>"Email успешно обновлен!");
    echo json_encode($array);
    exit;
     }else {
    $array=array('type'=>'error','message'=>"Код подтверждения неправильный!");
    echo json_encode($array);
    exit;
     }
    }else {
   $array=array('type'=>'error','message'=>"Email уже существует в базе");
    echo json_encode($array);
    exit;     
    }
    exit;
    }
    public function actionCodegen($field_name){
    $user=NoiCore::user()->load();    
    if(isset($field_name) and is_string($field_name) and strlen($field_name)){    
    $random_password=rand(10000,99999);
    $array_update=array('code_check_'.$field_name=>(int)$random_password);
    NoiCore::user()->update($array_update);
    NoiCore::app()->email($user['email'],"Код подтверждения","Ваш код подтверждения ".$random_password);
    echo "Код успешно отправлен! ".$random_password;
    
    
    }
    exit;
    }
    public function actionChange(){
        if(isset($_POST['password_old']) and isset($_POST['password_new'])){
        $load=$this->user()->load();
        $tmp_password=new OneField();
        $tmp_password->init("password",$this->password_field['type']);
       /// $_POST[$tmp_password->getName()]=$_POST['password_old'];
        $result=hash("sha512",$_POST['password_old']);
 
        if(isset($load[$this->password_field['name']]) and $load[$this->password_field['name']]==$result){
            
            $new_password=new OneField();
             $new_password->init("password",$this->password_field['type']);
             $_POST[$tmp_password->getName()]=$_POST['password_new'];
             $result_new=hash("sha512",$_POST['password_new']);
             
             if($result_new===FALSE){

             }else {
             if(isset($_POST['password_new2']) and $_POST['password_new2']==$_POST['password_new']){   
             $array_update=array();
             $array_update[$this->password_field['name']]=$result_new;
             $this->user()->update($array_update,$load['_id']->__toString());
                   $this->setNotify($this->lang('pass_change'));
             }else {
              $this->setNotify($this->lang('pass_eror1'));   
             }
             }


        } else {
        $this->setNotify($this->lang('pass_error2'));
        }
        }
  
        $this->redirect($this->getRoute('profile/index'));
    }
    public function actionFrestore(){
    $user=NoiCore::user()->load();
    $array_update=array();
    $password=$this->rand_passwd();
    
    $array_update['finance_password']=hash("sha512",$password);
    $this->user()->update($array_update,$user['_id']->__toString());
    $body=$this->lang('restore_finance_body');
    $body=str_replace("{password}",$password,$body);
    NoiCore::app()->email($user['email'],$this->lang('restore_finance'),$body);
    $this->setNotify($this->lang('fin_email'));
    NoiCore::app()->returnback();
    }
    public function actionChange2(){
        
      if(isset($_POST['finance_password']) and isset($_POST['finance_password_new'])){
       $load=$this->user()->load();
    
       if(isset($load['finance_password'])){
       if(hash("sha512",$_POST['finance_password'])==$load['finance_password']){
         $array_update=array();
         if(isset($_POST['finance_password_new2']) and $_POST['finance_password_new2']==$_POST['finance_password_new']){
         $array_update['finance_password']=hash("sha512",$_POST['finance_password_new']);
         $this->user()->update($array_update,$load['_id']->__toString());
         $this->setNotify($this->lang('fin_change'));
         }else {
          $this->setNotify($this->lang('fin_error'));    
         }
       }else {
        $this->setNotify($this->lang('fin_error2'));
       }
       }else {
         $array_update=array();
         $array_update['finance_password']=hash("sha512",$_POST['finance_password_new']);
         $this->user()->update($array_update,$load['_id']->__toString());
         $this->setNotify($this->lang('fin_change'));
       }
      }
         $this->redirect($this->getRoute('profile/index'));
    }
}
