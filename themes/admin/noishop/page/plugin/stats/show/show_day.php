<?
if(isset($result[0]['date'])){
?>
<h2><?php echo $result[0]['date'];?></h2>
<?
}
?>
<p>Hosts <?php echo $result[0]['hosts'];?></p>
<p>Views <?php echo $result[0]['views'];?></p>
<h3>Details</h3>
<?
if(isset($result[0]['history']) and is_array($result[0]['history']) and (count($result[0]['history'])>0)){
foreach($result[0]['history'] as $key=>$val){
$ip=str_replace("-",".",$key);
?>
<h4><?php echo $ip;?></h4>
<table>
<?
if(isset($val) and is_array($val) and count($val)>0){
 foreach($val as $subval){
?>
    <tr><td><a href="<?php echo $controller->getFrontendUrl($subval);?>"><?php echo $subval;?></a></td></tr>
<?
 }
}
?>
</table>
<?
}
}
?>
