<ol class="breadcrumb">
  <li><a href="/">Главная</a></li>


  <li class="active">Форум</li>
</ol>
<section id="about-us">

        <div class="container">
<h2><?=$title;?></h2>
<table class="table">
<?
foreach($category as $cat){
?>
    <tr>
        <td><?=$cat['title'];?>(<?=$cat['count']?> тем)</td>
        <td><a href="<?=$controller->getRoute('category/'.$cat['last_id']);?>">Посмотреть</a></td>
    </tr>
<?
}
?>
</table>

        </div></section>