 <section id="middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 wow fadeInDown">
                    <div class="skill">
                        <h2>Форум</h2>
                        <p>На форуме,вы можете задать любые вопросы,и пользователи вам ответят</p>
<?
$array_color=array('1','2','3','4');
if(isset($list_category) and count($list_category)>0){
 foreach($list_category as $category){
  $count_all=count($array_color)-1;
  $rand=rand(0,count($count_all));
 ?>
   <div class="progress-wrap">
       <h3> <a href="/forum/category/<?=$category['last_id'];?>.html"><?=$category['title'];?></a></h3><br>
                            <div class="progress">
                              <div class="progress-bar  color<?=$array_color[$rand];?>" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?=$category['percent'];?>%">
                                <span class="bar-width"><?=$category['count'];?> тем</span>
                              </div>

                            </div>
                        </div>

 <?
 }
}
?>

 
                    </div>

                </div><!--/.col-sm-6-->

                <div class="col-sm-6 wow fadeInDown">
                    <div class="accordion">
                        <h2>Последние темы</h2>
                        <div class="panel-group" id="accordion1">
                          <?
foreach($themes as $key=>$theme){
$active="";
if($key==0){
$active="active";
}
?>
 <div class="panel panel-default">
                            <div class="panel-heading <?=$active;?>">
                              <h3 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne<?=$key;?>">
                                  <?=$theme['title'];?>
                                  <i class="fa fa-angle-right pull-right"></i>
                                </a>
                              </h3>
                            </div>

                            <div id="collapseOne<?=$key;?>" class="panel-collapse collapse in">
                              <div class="panel-body">
                                  <div class="media accordion-inner">
                                        <div class="pull-left">
                                            <a href="/user/list/profile/<?=$theme['messages'][0]['user']['last_id'];?>.html"><img class="img-responsive" src="<?=$theme['messages'][0]['user']['avatar'];?>"></a>
                                        </div>
                                        <div class="media-body">
                                            <h4><a href="/forum/theme/<?=$theme['last_id'];?>.html"><?=$theme['messages'][0]['user']['name'];?></a></h4>
                                             <p><?=$theme['messages'][0]['message'];?></p>
                                        </div>
                                  </div>
                              </div>
                            </div>
                          </div>
<?
}
?>
                         





                          
                        </div><!--/#accordion1-->
                    </div>
                </div>

            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#middle-->

