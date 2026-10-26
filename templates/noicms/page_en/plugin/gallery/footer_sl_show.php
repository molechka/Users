           <?
                                 foreach($albom['photos'] as $key=>$photo){
                                 ?>
<div class="col-sm-3">
                                                  <div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
	        <?
                                                                if(isset($photo['photo']) and count($photo['photo'])>0){
                               foreach($photo['photo'] as $ph){
                               ?>									<img src="<?=$ph;?>" alt="" />
                               <?
                               }
                                                                }
                               ?>
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								 <?
                                                                 echo $photo['description'];
                                                                 ?>
							</div>


						</div>
<?
                                 }
?>







                                            
