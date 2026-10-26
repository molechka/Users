<ol class="breadcrumb">
  <li><a href="/">Home</a></li>
  <li><a href="<?=$controller->getRoute('index');?>">Forum</a></li>
 
  <li class="active"><?=$category['title'];?></li>
</ol>
<section id="about-us">

        <div class="container">
<h2>List themes on category <?=$category['title'];?></h2>
<?
if($write==true){
?>
<p><a href="<?=$controller->getRoute('theme/create/'.$category['last_id']);?>">Create theme</a></p>
<?
}
?>
<table class="table">
<?
if(count($themes)>0){
foreach($themes as $theme){
 $last_message=end($theme['messages']);
?>
    <tr>
        <td><a href="<?=$controller->getRoute('theme/'.$theme['last_id']);?>"><?=$theme['title'];?></a></td>
        <td><?=count($theme['messages']);?> messages</td>
        <td><?=date("Y-m-d H:i",$last_message['date']->sec)?></td>
    </tr>
<?


}
}
?>
</table>
        </div></section>