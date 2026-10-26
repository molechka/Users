<section id="about-us">

    <div class="container">       <h2>Change password</h2>


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
                 <td>Password</td>
                 <td><input type="text" name="restore_password"></td>

             </tr>

             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit"  name="act_lost_now" value="Change my password plz"></td>
             </tr>
         </table>
     </form>
    </div></section>