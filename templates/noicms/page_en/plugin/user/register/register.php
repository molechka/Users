<section id="about-us">

        <div class="container">
     <h2>Register</h2>
           <p class="lead">Use the form below, you can register on our website</p>
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
                 <td>Name</td>
                 <td><input type="text" name="name"></td>

             </tr>
              
              <tr>
                 <td>Email</td>
                 <td><input type="text" name="email"></td>

             </tr>
              <tr>
                 <td>Password</td>
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
                 <td><input class="btn btn-danger" type="submit" name="act_register_now" value="Register right now"></td>
             </tr>
         </table>
     </form>
        </div></section>

