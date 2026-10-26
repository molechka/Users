<?
$load=NoiCore::user()->load();
?>
<section id="about-us">

        <div class="container">
<h2>My profile</h2>
     <div class="row">

           <div class="col-md-4 center">
             
<img src="<?=$load['avatar'];?>">
         </div>
         <div class="col-md-8 center">


     <form action="<?=$controller->getRoute('profile/index')?>" method="POST" enctype="multipart/form-data" >
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
                 <td>Avatar</td>
                 <td><input type="file" name="avatar"></td>

             </tr>
             <tr>
                 <td>Name</td>
                 <td><input type="text" name="name" value="<?if(isset($load['name'])) { echo $load['name'];}?>"></td>

             </tr>


             <tr>
                 <td></td>
                 <td><input class="btn btn-danger" type="submit" name="act_profile_now" value="Save"></td>
             </tr>
         </table>
     </form>

               </div>
     </div>


        </div></section>