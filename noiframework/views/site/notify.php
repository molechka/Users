<link rel="stylesheet" href="/js/growl/jquery.jgrowl.css" type="text/css"/>
<script type="text/javascript" src="/js/growl/jquery.jgrowl.js"></script>
    <?
if(NoiCoreSet::isExists()){
$result=  NoiCore::notify()->getAll();
if(isset($result)){
?>
<script>
<?
  foreach($result as $key=>$message){
?>
$.jGrowl("<?php echo $message;?>");
<?
  }
?>
</script>
<?

}
}
?>
