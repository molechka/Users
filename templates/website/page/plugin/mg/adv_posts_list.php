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
				<?=$collection['description'];?>

				<div id="sitewrapper" class="row">
					<div id="content" class="col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="blog-wrapper col-md-12">
                                                         <?
                                                         if(count($all)>0){
                                                         foreach($all as $document){
                                                         ?>
                                                         <article class="blog-wrap">
									<div class="entry blog-media">
										<a href="<?=$url_document;?><?=$document['last_id'];?>.html"><img src="<?=$document['image'];?>" class="img-responsive" alt="">
										</a>
									</div><!-- end blog media -->
				                    
				                    

									<div class="post-content">
										<h2><a href="<?=$url_document;?><?=$document['last_id'];?>.html"><?=$document['title'];?></a></h2>
											<?=$document['short'];?>
				                         <!-- end post-meta -->
									</div><!-- post-content -->
				                </article>   
                                                         <?    
                                                         }    
                                                         }
                                                         ?>
                                                        
								 <!-- end blog wrap -->
							</div><!-- end blog-wrapper -->
						</div><!-- end row -->

						<div class="row">
							<div class="col-md-12">
								<?=$pages;?>
							</div><!-- end 12 -->
						</div><!-- end row -->
					</div><!-- end col -->
 
				</div><!-- end row -->
			</div><!-- end container -->
		</section>