<section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">
            <?
              if(isset($albom['photos']) and count($albom['photos'])>1){
               foreach($albom['photos'] as $key_p=>$photo){
                $active="";
                if($key_p==0){
                 $active="active";
                }
                ?>
                 <li data-target="#main-slider" data-slide-to="<?=$key_p;?>" class="<?=$active?>"></li>
                <?
               }
              }
            ?>
               
              
            </ol>
            <div class="carousel-inner">
  <?
              if(isset($albom['photos']) and count($albom['photos'])>0){
               foreach($albom['photos'] as $key_p=>$photo){
                $active="";
                if($key_p==0){
                 $active="active";
                }
               ?>
                  <div class="item <?=$active;?>" style="background-image: url(<?=$photo['photo'];?>)">
                    <div class="container">
                        <div class="row slide-margin">
                        <?
                        echo $photo['description'];
                        ?>

                        </div>
                    </div>
                </div><!--/.item-->
               <?
               }
              }
              ?>

             




            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <?
        if(count($albom['photos'])>1){
        ?>
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
        <?
        }
        ?>
    </section><!--/#main-slider-->