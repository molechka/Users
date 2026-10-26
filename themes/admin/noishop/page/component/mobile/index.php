<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
 
  <li class="active"><?php echo NoiCore::app()->lang('setup_mobile');?></li>
</ol>
<h2>Configuration for access from mobile application</h2>
<?
if(isset($mobile['status']) and $mobile['status']==1 and isset($mobile['secret_phras']) and strlen($mobile['secret_phras'])>0){
?>
<textarea rows="3" cols="100">
 &lt;?php
 $generate_password=hash("sha512","<?php echo $mobile['secret_phras'];?>openkey");
 $api_request=file_get_contents("http://<?php echo $_SERVER['HTTP_HOST'];?>/blog/index?hash=".$generate_password."&openkey=openkey");


</textarea>
<?
}

?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php echo NoiCore::app()->getRoute('mobile/index');?>"><?php echo NoiCore::app()->lang('mobile_configuration')?></a></li>
      <li ><a href="<?php echo NoiCore::app()->getRoute('mobile/logs');?>"><?php echo NoiCore::app()->lang('mobile_logs_used');?></a></li>
</ul>
<h4></h4>
<form method="POST" action="">
    <table class="table">
        <tr>
            <td><?php echo NoiCore::app()->lang('mobile_status');?></td>
            <td><select name="status">
                    <option <? if(isset($mobile['status']) and $mobile['status']=="0") { echo 'selected';} ?> value="0"><?php echo NoiCore::app()->lang('disabled');?></option>
                    <option <? if(isset($mobile['status']) and $mobile['status']=="1") { echo 'selected';} ?> value="1"><?php echo NoiCore::app()->lang('enabled');?></option>
                </select></td>
        </tr>
        <tr>
            <td><?php echo NoiCore::app()->lang('mobile_secretkey');?></td>
            <td><input type="text" name="secret_phras" value="<? if(isset($mobile['secret_phras'])) { echo $mobile['secret_phras'];}?>"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="btn btn-success" value="<?php echo NoiCore::app()->lang('mobile_save');?>"></td>
        </tr>
        
    </table>
</form>

