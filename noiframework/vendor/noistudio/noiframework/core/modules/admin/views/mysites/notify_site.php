<link rel="stylesheet" href="/themes/site/kube/growl/jquery.jgrowl.css" type="text/css"/>
<script type="text/javascript" src="/themes/site/kube/growl/jquery.jgrowl.js"></script>
    <?
$result=  ShoutCore::getNotify();
if(isset($result)){
?>
<script>

<?
  foreach($result as $key=>$message){
?>
jQuery.jGrowl("<?php echo $message;?>");
<?
  }
?>
</script>
<?


}
?>