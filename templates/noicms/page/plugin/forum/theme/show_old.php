<h2><?=$theme['title'];?></h2>
<h4><?=count($theme['messages']);?> сообщений в теме</h4>
<table class="table">
   <?
   foreach($theme['messages'] as $key=>$message){
   ?>
    <tr>
        <td><?=$message['user']['name'];?></td>
        <td><?=$message['message'];?></td>
        <td><?=date('Y-m-d H:i',$message['date']->sec);?></td>

    </tr>
    <tr>
        <td>
        <?
        if(isset($message['user']['_id']) and $controller->user()->isLogin()){
        if($message['user']['_id']==$controller->user()->getLogged("_id")){
        ?>
            <a href="<?=$controller->getRoute('post/edit/'.$theme['last_id']."/".$key)?>">Редактировать</a>
         <?
        }
        }
        ?>
        </td>
        <td></td>
        <td>
          <?
        if(isset($message['user']['_id']) and $controller->user()->isLogin()){
        if($message['user']['_id']==$controller->user()->getLogged("_id")){
        ?>
            <a href="<?=$controller->getRoute('post/delete/'.$theme['last_id']."/".$key)?>">Удалить</a>
         <?
        }
        }
        ?>
        </td>

    </tr>
   <?
   }
   ?>
</table>
<?
if($write==true){
if(NoiCore::user()->isLogin()){
echo $controller->render("reply_form",array('theme'=>$theme));
}else {
echo $controller->render("reply_form_guest",array('theme'=>$theme));
}
}
?>

