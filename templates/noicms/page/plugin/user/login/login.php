  <section id="about-us">

        <div class="container">  <h2>Вход</h2>
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
                 <td><input type="text" name="password"></td>

             </tr>
             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit" value="Авторизоваться"></td>
             </tr>
         </table>
     </form>
        </div></section>