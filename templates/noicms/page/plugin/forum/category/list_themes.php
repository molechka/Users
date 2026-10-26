<ol class="breadcrumb">
  <li><a href="/">Главная</a></li>
  <li><a href="<?=$controller->getRoute('index');?>">Форум</a></li>
 
  <li class="active"><?=$category['title'];?></li>
</ol>
<section id="about-us">

        <div class="container">
<h2>Список тем в категории <?=$category['title'];?></h2>
<?
if($write==true){
?>
<p><a href="<?=$controller->getRoute('theme/create/'.$category['last_id']);?>">Создать тему</a></p>
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
        <td><?=count($theme['messages']);?> сообщений</td>
        <td><?=date("Y-m-d H:i",$last_message['date']->sec)?></td>
    </tr>
<?


}
}
?>
</table>
        </div></section>