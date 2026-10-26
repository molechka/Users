<div class="alert alert-success">
  <?
  if(!$controller->user()->isLogin()){
  ?>
    <h4>Вход</h4>
    <form action="/user/login/index.html" method="POST">
        <table class="table center">
             <tr>
                 <td>Логин</td>
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
    <p><a href="/user/register/index.html">Создать аккаунт</a></p>
     <p><a href="/user/lost/index.html">Забыл пароль</a></p>
  <?
  }else {
?>
     <h4>Пульт управления</h4>
 <ul class="nav-list">
     <li class="list-group-item"><img style="width:25px;" src="<?=$controller->user()->getLogged("avatar");?>"/><a href="/user/profile/index.html">Настройки</a></li>
     <li class="list-group-item"><a href="/payeercom/index.html">Баланс <?=$controller->user()->getLogged("user_money");?>$</a></li>
<?
if($controller->user()->isRole("developer")){
?>
     <li class="list-group-item"><a href="/nmarket/developer/index.html">Мои плагины</a></li>
<?
}
?>
     <li class="list-group-item"><a href="/user/logout.html">Выход</a></li>

</ul>
<?
  }
  ?>

</div>

