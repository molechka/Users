<section id="about-us">

    <div class="container">       <h2>Изменение пароля</h2>

           <p class="lead">С помощью формы ниже,вы сможете изменить пароль</p>
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
                 <td>Пароль</td>
                 <td><input type="text" name="restore_password"></td>

             </tr>

             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit"  name="act_lost_now" value="Изменить пароль"></td>
             </tr>
         </table>
     </form>
    </div></section>