<section class="pagebg banner">
			<div class="page-header-top"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?=$collection['description'];?>
						<ol class="breadcrumb">
						  <li><a href="/">Главная</a></li>
						  <li class="active"><?=$collection['meta_title'];?></li>
						</ol>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section>


<section class="section white">
			<div class="pagebefore"></div>
			<div class="container">
				 

				<div id="sitewrapper" class="row">
					<div id="content" class="col-md-12 col-sm-12 col-xs-12 pull-right">
						<div class="row hotel-list">
                                                 <?
                                                 if(count($all)>0){
                                                  foreach($all as $document){
                                                  ?>
                                                  <div class="col-md-4 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
								<div class="hotel-showcase">
									<div class="post-media">
                                                                            <a href='<?=$url_document;?><?=$document['last_id'];?>.html'><img src="<?=$document['image'];?>" alt="" class="img-responsive"></a>
									</div><!-- end media -->

									<div class="hotel-showcase-title text-center">
										 
										<h4><a href="<?=$url_document;?><?=$document['last_id'];?>.html" title=""><?=$document['title'];?></a></h4>
										 
									</div><!-- end title -->
								</div><!-- end hotel-showcase -->
							</div>  
                                                  <?   
                                                  }   
                                                 }
                                                 ?>
							 

							 <!-- end col -->
						</div><!-- end hotel-list -->
						<div class="row">
							<div class="col-md-12">
								<?=$pages;?>
							</div><!-- end 12 -->
						</div><!-- end row -->
					</div><!-- end col -->

					 <!-- end #sidebar -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section>