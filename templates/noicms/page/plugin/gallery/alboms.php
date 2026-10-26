  
   
            <div class="center">
                <h2><a href="<?=$controller->getRoute('alboms');?>">Проекты</a></h2>
               <p class="lead">сайты,которые используют NoiCMS</p>
            </div>


            <ul class="portfolio-filter text-center">
                <li><a class="btn btn-default active" href="#" data-filter="*">Все сайты</a></li>
             <?
             if(isset($alboms) and count($alboms)>0){
             foreach($alboms as $albom){
            ?>
           <li><a class="btn btn-default" href="#" data-filter=".<?=$albom['_id']->__toString()?>"><?=$albom['title'];?></a></li>
            <?
             }

             }
             ?>
                

            </ul><!--/#portfolio-filter-->

            <div class="row">
                <div class="portfolio-items">
                     <?
             if(isset($alboms) and count($alboms)>0){
             foreach($alboms as $albom){
               if(isset($albom['photos']) and count($albom['photos'])>0){
              foreach($albom['photos'] as $photo){
              if(isset($photo['photo']['600x455']) and isset($photo['photo']['290x220'])){
            ?>
            <div class="portfolio-item <?=$albom['_id']->__toString();?> col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap" >
                            <div style="height:220px;background:white;">
                                <img class="img-responsive" style=""  src="<?=$photo['photo']['290x220'];?>" alt=""></div>
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="<?=$controller->getRoute('show/'.$albom['title_translit'])?>"><?=$albom['title'];?></a></h3>
                                    <p><?=$photo['name'];?></p>
                                    <a class="preview" href="<?=$photo['photo']['600x455'];?>" rel="prettyPhoto"><i class="fa fa-eye"></i> Посмотреть</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->
            <?
              }
              }
               }
             }
             }
            ?>
                    












 
                </div>
            </div>
   

