<section class="pagebg banner">
			<div class="page-header-top"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?=$collection['description'];?>
						<ol class="breadcrumb">
						  <li><a href="#">Главная</a></li>
                                                  <li><a href="/mg/<?=$collection['last_id'];?>.html"><?=$collection['meta_title']?></a></li>
						  <li class="active"><?=$document['title'];?></li>
						</ol>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section>

	<section class="section white">
			<div class="pagebefore"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12 section-title text-center">
						<h1><?=$document['title'];?></h1>
						 
					</div><!-- end col -->
				</div><!-- end row -->

				<div id="sitewrapper" class="row">
					<div id="content" class="col-md-12 col-sm-12 col-xs-12">
						<div class="postmedia">
							<div class="slider">
								<div class="flexslider">
									<ul class="slides">
                                                                            
							            <li data-thumb="<?=$document['image'];?>">
											<img src="<?=$document['image'];?>" alt="">
										</li>
							             
									</ul>
								</div>
							</div>
                                                    <?
                                                    echo $document['content'];
                                                    ?>
						</div><!-- end media -->

						 
					</div><!-- end col -->

					 <!-- end #sidebar -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section>