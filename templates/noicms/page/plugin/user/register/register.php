<section id="about-us">

        <div class="container">
     <h2>Регистрация</h2>
           <p class="lead">С помощью формы ниже,вы сможете зарегистрироваться на нашем ресурсе</p>
     <form action="<?=$controller->getRoute('register/index')?>" method="POST" >
     <?
if($iserror==1){

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
                 <td><input type="text" name="name"></td>

             </tr>
              
              <tr>
                 <td>Email</td>
                 <td><input type="text" name="email"></td>

             </tr>
              <tr>
                 <td>Пароль</td>
                 <td><input type="text" name="password"></td>

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
                 <td><input class="btn btn-danger" type="submit" name="act_register_now" value="Авторизоваться"></td>
             </tr>
         </table>
     </form>
        </div></section>

