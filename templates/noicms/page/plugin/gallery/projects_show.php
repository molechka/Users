
<ol class="breadcrumb">
    <li><a href="/">Главная</a></li>
 <li><a href="<?=$controller->getRoute('c/'.$category['_id']->__toString())?>"><?=$category['title'];?></a></li>
  <li class="active"><?=$albom['title'];?></li>
</ol>
 <section id="about-us">

        <div class="container">
            <div class="center">
               <h2><?=$albom['title'];?></h2>

            </div>




            <div class="row">
                <div class="center">
                     <?
               $alboms=array($albom);
             if(isset($alboms) and count($alboms)>0){
             foreach($alboms as $albom){
               if(isset($albom['photos']) and count($albom['photos'])>0){
              foreach($albom['photos'] as $photo){
              if(isset($photo['photo']['600x455']) and isset($photo['photo']['290x220'])){
            ?>
            <div class="portfolio-item <?=$albom['_id']->__toString();?> col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap" >
                            <div style="height:220px;background:white;">
                            <img class="img-responsive"    src="<?=$photo['photo']['290x220'];?>" alt="">
                            </div>
                            <div class="overlay">
                                <div class="recent-work-inner">
                                       <h3><a  class="preview" href="<?=$photo['photo']['600x455'];?>" rel="prettyPhoto"><?=$albom['title'];?></a></h3>
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
        </div></section>


