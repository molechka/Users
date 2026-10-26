

        <div class="row"> 
         <div class="col-md-6">   
            <h2>Вход</h2>
  <?
  if(isset($_GET['activate_email'])){
 ?>
      <p class="lead">На ваш email выслано письмо для завершения регистрации</p>
  <?
  }else {
  ?>
           <p class="lead">С помощью формы ниже,вы сможете авторизоваться на нашем ресурсе</p>
  <?
  }
  ?>
     <form action="<?=$controller->getRoute('login/index')?>" method="POST" >
         <table class="table center">
             <tr>
                 <td>Email</td>
                 <td><input type="text" name="login"></td>

             </tr>
              <tr>
                 <td>Пароль</td>
                 <td><input type="password" name="password"></td>

             </tr>
             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit" value="Авторизоваться"></td>
             </tr>
         </table>
     </form>
         </div><div class="col-md-6">
              
             <h2>Регистрация</h2>
             <?
             $ulogin=new ulogin\models\UModel();
           echo  $ulogin->getWidget();
             ?>
              <form action="<?=$controller->getRoute('register/index')?>" method="POST" >
     <?
if(isset($iserror) and $iserror==1){

if(isset($_POST['main_form_error'])){
 ?>
   <p><?=$_POST['main_form_error'];?></p>
  <?
}else {
if(isset($_POST['error_message'])){
 if(isset($_POST['error_key'])){
 $_POST['error_'.$_POST['error_key']]=1;
 }
?>

     <p><?=$_POST['error_message'];?> (<?=$_POST['error_key'];?>)</p>
<?
}
}
?>
<?
}
?>
         <table class="table center">
             <tr>
                 <td>Имя</td>
                 <td><input required   type="text" name="name"></td>

             </tr>
              
              <tr>
                 <td>Email</td>
                 <td><input required  type="text" name="email"></td>

             </tr>
              <tr>
                 <td>Пароль</td>
                 <td><input required type="password" name="password"></td>

             </tr>
           
             <?
             $referal="";
             if(isset($_POST['referal'])){
               $referal=$_POST['referal'];
             }else if(isset($_GET['referal'])){
              $referal=$_GET['referal'];
             }


             ?>

             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit" name="act_register_now" value="Зарегистрироваться"></td>
             </tr>
         </table>
     </form>  
         </div>
        </div>