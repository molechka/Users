<section id="about-us">

        <div class="container">        <h2>Lost password</h2>


         <?
if($status_op==1){
?>
                    <p>Instruction send on your email</p>
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
                 <td><input class="btn btn-danger" type="submit"  name="act_lost_now" value="Send me link plz"></td>
             </tr>
         </table>
     </form>
        </div></section>