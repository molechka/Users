<section id="about-us">

    <div class="container">
<h2>Уведомления</h2>
<?
if(isset($notify) and count($notify)>0){
?>
<table class="table">
    <?
    foreach($notify as $not){
    $text="";
    if($not['type']=="message"){
    $text="Появилось новое сообщение в теме <a href='".$controller->getRoute('theme/'.$not['contain']['last_id'])."'>".$not['contain']['title']."</a>";
    }
    ?>
    <tr>
        <td><?=date('Y-m-d H:i',$not['date']->sec);?></td>
        <td><?=$text;?></td>
    </tr>
    <?
    }
    ?>
</table>
<?
}
?>
    </div></section>
