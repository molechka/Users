<?
  $name_file=str_replace($_SERVER['DOCUMENT_ROOT'],"",$file);
?>
<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
 <li><a href="<?php echo   NoiCore::app()->getRoute("template");?>"><?php echo NoiCore::app()->lang("links_config_template");?></a></li>
  <li class="active"><?php echo $name_file;?></li>
</ol>
<h2><a href="<?php echo   NoiCore::app()->getRoute("template");?>"><?php echo NoiCore::app()->lang("links_config_template");?></a></h2>
<h4><?php echo $name_file;?></h4>
<form action="" method="POST">
<div class="row">
    
    <textarea name="content" class="col-md-10" rows="20"><?php echo $content;?></textarea>
    
    
</div>
<p><input type="submit" class="btn btn-submit"  value="<?php echo NoiCore::app()->lang("template_list_save");?>"></p>
</form>
