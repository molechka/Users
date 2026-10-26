 
                  <ul class="nav navbar-nav">

                 <?
                 $current_url=NoiCore::route()->get();

                 if(isset($value) and is_array($value) and count($value)>0){
                 foreach($value as $val){
                  if(isset($val['title']) and isset($val['link'])){
                  ?>
                  
<?

if(isset($val['sublinks']) and is_array($val['sublinks']) and count($val['sublinks'])){
 ?>
                   <li  class="dropdown <? if($val['link']==$current_url) echo 'active'?>"><a href="<?=$val['link'];?>" title="" class="dropdown-toggle" data-toggle="dropdown"><?=$val['title'];?><b class="caret"></b></a>
                       <ul class="dropdown-menu">


 <?
 foreach($val['sublinks'] as $link){
  if(isset($link['link']) and isset($link['title'])){
  ?>
                           <li><a href="<?=$link['link'];?>"><?=$link['title'];?></a></li>
  <?
  }
 }
 ?>
        </ul>
 <?
}else {
 ?>
                  <li  class="<? if($val['link']==$current_url) echo 'active'?>"><a href="<?=$val['link'];?>" title=""><?=$val['title'];?></a>
 <?
}
?>
                    </li>
                  <?
                  }
                 }
                 }
                 ?>
<?
if($controller->user()->isLogin()){
?>

                    <li><?=NoiCore::app()->get_plugin("forum",array('notify','show'))?></li>
                    <?
}
                    ?>
                     <li><a href="/?set_language=ru"><img src="/tmp/lang/rus.jpg"></a></li>
                  </ul>
