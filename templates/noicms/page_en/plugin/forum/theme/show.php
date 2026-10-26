 <ol class="breadcrumb">
  <li><a href="/">Home</a></li>
  <li><a href="<?=$controller->getRoute('index');?>">Forum</a></li>
    <li><a href="<?=$controller->getRoute('category/'.$category['last_id']);?>"><?=$category['title'];?></a></li>
  <li class="active"><?=$theme['title'];?></li>
</ol>
<section id="about-us">

    <div class="container">

     <h1 id="comments_title"><?=$theme['title'];?></h1>
 <h2><?=count($theme['messages']);?> messages on theme</h2>
   <?
   foreach($theme['messages'] as $key=>$message){
   ?>
   <div class="media comment_section">
                            <div class="pull-left post_comments">
                                <a href="/user/list/profile/<?=$message['user']['last_id'];?>.html"><img src="<?=$message['user']['avatar'];?>" class="img-circle" alt="" /></a>
                            </div>
                            <div class="media-body post_reply_comments">
                                <h3><?=$message['user']['name'];?></h3>
                                <h4><?=date('Y-m-d H:i',$message['date']->sec);?></h4>
                                <p><?=$message['message'];?></p>
                               <?
        if(isset($message['user']['_id']) and $controller->user()->isLogin()){
        if($message['user']['_id']==$controller->user()->getLogged("_id")){
        ?>
                             <a href="<?=$controller->getRoute('post/edit/'.$theme['last_id']."/".$key)?>">Edit</a>
       <?
        }
        }
       ?>
                            </div>
                        </div>
 <?
   }
 ?>
 <?
if($write==true){
if(NoiCore::user()->isLogin()){
echo $controller->render("reply_form",array('theme'=>$theme));
}else {
echo $controller->render("reply_form_guest",array('theme'=>$theme));
}
}
?>
    </div></section>
                         