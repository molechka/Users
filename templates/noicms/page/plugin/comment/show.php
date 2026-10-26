<h2>Комментарии</h2>
<?
if(isset($comments) and  isset($comments[0]['_id'])){
foreach($comments as $comment){
?>
<table class="table">
    <tr>
        <td class="col-md-3"><?=$comment['user']['name']?></td>
        <td class="col-md-6"><?=date('Y-m-d H:i',$comment['date']->sec);?></td>
    </tr>
    <tr>
        <td class="col-md-3"><img src="<?=$comment['user']['avatar']?>" style="height:50px"></td>
        <td class="col-md-6"><?=$comment['comment'];?></td>
    </tr>
</table>
<?
}
}
?>
<?
if(NoiCore::user()->isLogin()){
?>
<h4>Оставить комментарий</h4>
<form action="<?=$controller->getRoute("add");?>" method="POST">
<table class="table">
      <tr>
        <td class="col-md-3"><?=NoiCore::user()->getLogged("name");?></td>
        <td class="col-md-6"> </td>
    </tr>
    <tr>
        <td class="col-md-3"><img src="<?=NoiCore::user()->getLogged("avatar");?>" style="height:50px;"></td>        <td class="col-md-6"><textarea name="comment" class="col-md-6" placeholder="Введите ваш комментарий тут"></textarea></td>
        
    </tr>
    <tr><td class="col-md-3">

        </td>
        <td class="col-md-6"><input type="hidden" name="url" value="<?=$url;?>"><input type="submit" class="btn btn-danger" name="act_add_comment" value="Комментировать"> </td></tr>
</table>
</form>
<?
}else {
 ?>
<p>Чтобы оставить комментарий вам нужно либо <a class="btn btn-danger" href="/user/login/index.html">авторизоваться</a> или <a class="btn btn-danger" href="/user/register/index.html">зарегистрироваться</a></p>
 <?
}
?>
