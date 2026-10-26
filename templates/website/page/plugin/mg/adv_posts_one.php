<?
NoiCore::app()->setParam("image_url",array('url'=>'http://'.$_SERVER['HTTP_HOST']."".$document['image']));
?>
<section class="pagebg banner">
			<div class="page-header-top"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1><?=$collection['meta_title'];?></h1>
						 
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
				<div class="row">
					<div class="col-md-12 section-title text-center">
						<h1><?=$document['title'];?> </h1>
						
					</div><!-- end col -->
				</div><!-- end row -->

				<div id="sitewrapper" class="row">
					<div id="content" class="col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="blog-wrapper col-md-12">
								<article class="blog-wrap">
									<div class="entry blog-media">
										<img src="<?=$document['image'];?>" class="img-responsive" alt="">
										
									</div><!-- end blog media -->
				                    
				                     

									<div class="post-content">
									<?
                                                                        echo $document['content'];
                                                                        ?>
											 

				                        <!-- end post-meta -->
									</div><!-- post-content -->
				                </article><!-- end blog wrap -->
				            </div><!-- end col -->
				        </div><!-- end row -->

						 <!-- end row -->

					</div><!-- end col -->

					 <!-- end #sidebar -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section>