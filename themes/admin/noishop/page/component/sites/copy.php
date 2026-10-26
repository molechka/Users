<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
   <li><a href="<?php echo   NoiCore::app()->getRoute("sites/index");?>"><?php echo NoiCore::app()->lang('multisites');?></a></li>
  <li class="active">copy</li>

</ol>
<h2>copy</h2>
<form action="" method="POST">
<table class="table">
    <tr>
        <td>Domain</td>
        <td><input type="text" name="domain"></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" class="btn btn-danger"  value="Add copy"></td>
    </tr>
</table>
</form>

