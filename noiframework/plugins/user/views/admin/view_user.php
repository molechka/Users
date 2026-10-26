<h2>View User</h2>
<table class="table">

<?
if(isset($user) and count($user)>0 and isset($user['_id'])){
?>
  <tr>
        <td>USER ID</td>
        <td><?php echo $user['_id']->__toString();?></td>
    </tr>
<?
 foreach($user as $key_user=>$value_user){
if(is_string($value_user)){
 ?>
    <tr>
        <td><?php echo $key_user;?></td>
        <td><?php echo $value_user;?></td>
    </tr>
 <?

}
 }
}
?>
</table>
<h3>Change password</h3>
<form action="" method="POST" enctype="multipart/form-data">
<table>
    <tr>
        <td>New Password</td>
        <td>
         <?
         if(isset($password_field['obj'])){
          echo $password_field['obj']->getInput();
         }
         ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input  class="btn btn-danger" type="submit" name="act_changepw" value="Change Password"></td>
    </tr>
</table>
</form>
