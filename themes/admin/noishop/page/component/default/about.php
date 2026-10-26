<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?=NoiCore::admin()->get("name");?></li>
</ol>
<?
echo NoiCore::admin()->get("about");
?>


