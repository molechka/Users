<?
use noicms\mongogrid\OneField;
foreach($users as $user){
?>
<div class="media">
                                <div class="pull-left">
                                    <img width="40" src="<?=$user['avatar'];?>" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted"><?=$user['email'];?></small><br>
                                    <p><a href="<?=NoiCore::app()->getRoute('p_user/users/edit/'.$user['last_id'])?>">Посмотреть пользователя</a></p>
                                   
                                </div>
                            </div>
<?
}
?>

