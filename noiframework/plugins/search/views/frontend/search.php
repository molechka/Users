<br><br>
<br><br><br><br><br><br>
<p>поиск по запросу:<?php echo $phrase;?></p>
<?
if(count($result)>0){
foreach($result as $row){
?>
<p><a href="<?php echo $row['url'];?>"><?php echo $row['title'];?></a></p>
<?
}
}
echo $paginator;
?>

