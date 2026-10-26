  <section id="about-us">

        <div class="container">  <h2>Login</h2>
  <?
  if(isset($_GET['activate_email'])){
 ?>
      <p class="lead">To your email sent an email to complete your registration</p>
  <?
  }else {
  ?>
           <p class="lead">Use the form below, you can log on our website</p>
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
                 <td>Password</td>
                 <td><input type="text" name="password"></td>

             </tr>
             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit" value="Login"></td>
             </tr>
         </table>
     </form>
        </div></section>