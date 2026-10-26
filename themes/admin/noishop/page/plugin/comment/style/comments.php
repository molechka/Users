<?
foreach($comments as $comment){
?>
<div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted"><?php echo $comment['user']['name'];?> <?php echo date('Y-m-d H:i',$comment['date']->sec);?></small><br>
                                    <a target="_blank" class="t-overflow" href="<?php echo NoiCore::admin()->getPreview($comment['url']);?>"><?php echo $comment['comment'];?></a>
                                </div>
                            </div>
<?
}
?>
