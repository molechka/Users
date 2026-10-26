<ol class="breadcrumb">
  <li><a href="/">Home</a></li>


  <li class="active">Forum</li>
</ol>
<section id="about-us">

        <div class="container">
<h2><?=$title;?></h2>
<table class="table">
<?
foreach($category as $cat){
?>
    <tr>
        <td><?=$cat['title'];?>(<?=$cat['count']?> themes)</td>
        <td><a href="<?=$controller->getRoute('category/'.$cat['last_id']);?>">Explore</a></td>
    </tr>
<?
}
?>
</table>

        </div></section>