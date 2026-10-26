  <section id="partner">
        <div class="container">
            <div class="center wow fadeInDown">
                <h2><?=$albom['title'];?></h2>
             <?=$albom['description'];?>
            </div>

            <div class="partners">
                <ul>
                     <?
                           $startms=300;
                                 foreach($albom['photos'] as $key=>$photo){

                                 ?>
                     <li> <a href="<?=$photo['name']?>"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="<?=$startms?>ms" src="<?=$photo['photo']?>"></a></li>
                    <?
                    $startms+=300;
                                 }

                    ?>
                  
                </ul>
            </div>
        </div><!--/.container-->
    </section><!--/#partner-->