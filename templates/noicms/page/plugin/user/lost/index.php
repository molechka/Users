<section id="about-us">

        <div class="container">        <h2>Забыли пароль</h2>

           <p class="lead">С помощью формы ниже,вы сможете авторизоваться на нашем ресурсе</p>
         <?
if($status_op==1){
?>
                    <p>Инструкции по восстановлению отправлены вам на почту.</p>
<?
}
?>
     <form action="" method="POST" >
         <table class="table center">
             <tr>
                 <td>Email</td>
                 <td><input type="text" name="lost_email"></td>

             </tr>

             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit"  name="act_lost_now" value="Прислать ссылку на изменение пароля"></td>
             </tr>
         </table>
     </form>
        </div></section>