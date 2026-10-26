<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("links_market");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("market_setup");?></h2>

<?
$status=NoiCore::app()->getSession("market_status");
if(isset($status) and $status==1){
?>
<p class="lead"><?php echo NoiCore::app()->lang("market_temporary_save");?></p>
<?
}else {
?>
<p class="lead"><?php echo NoiCore::app()->lang("market_howto");?> </p>
<?
}
?>
<form action="" method="POST">
<table class="table">
    <tr>
        <td><?php echo NoiCore::app()->lang("market_login");?></td>
        <td><input type="text" name="market_login"></td>
    </tr>
     <tr>
        <td><?php echo NoiCore::app()->lang("market_password");?></td>
        <td><input type="text" name="market_password"></td>
    </tr>
    <tr>
        <td></td>
        <td><input class="btn btn-submit" type="submit" name="act_save" value="<?php echo NoiCore::app()->lang("market_btn_tmp");?>"></td>
    </tr>
</table>
</form>

