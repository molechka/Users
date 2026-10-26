<?
NoiCore::app()->setParam("pagelink","5_3");  
NoiCore::app()->setParam("image_url",array('url'=>'http://'.$_SERVER['HTTP_HOST']."".$document['image']));
?>
<div class="container">
		 

<div id="content-area" class="clearfix">
			<div id="left-area">
							
				<article id="post-2835" class="et_pb_post post-2835 post type-post status-publish format-standard has-post-thumbnail hentry category-89">
											<div class="et_post_meta_wrapper">
							<h1><?=$document['title'];?></h1>

						
												</div> <!-- .et_post_meta_wrapper -->
				
					<div class="entry-content">
					<div class="et_pb_section  et_pb_section_0 et_section_regular">
				
				
					
					<div class=" et_pb_row et_pb_row_0">
				
				<div class="et_pb_column et_pb_column_4_4 et_pb_column_0">
				<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
				
<?=$document['content'];?>

			</div> <!-- .et_pb_text -->
			</div> <!-- .et_pb_column -->
					
			</div> <!-- .et_pb_row -->
				
			</div> <!-- .et_pb_section -->
 
                 					</div> <!-- .entry-content -->
					<div class="et_post_meta_wrapper">
					
										</div> <!-- .et_post_meta_wrapper -->
				</article> <!-- .et_pb_post -->

										</div> <!-- #left-area -->

				<div id="sidebar">
				<div id="recent-posts-2" class="et_pb_widget widget_recent_entries">		<h4 class="widgettitle">Свежие записи</h4>		
                                    <ul>
                                    <?
                                    $news=NoiCore::app()->db()->query(array(),"adv_posts",array('_id'=>array('$ne'=>$document['_id'])),array('_id'=>-1),5);
                                    if(count($news)>0){
                                    $news= \mg\models\Documents::parse($news, $collection);    
                                    foreach($news as $new){
                                    ?>
                                    <li>
				<a href="/mg/8/<?=$new['last_id'];?>.html"><?=$new['title'];?></a>
						</li>    
                                    <?    
                                    }    
                                    }
                                    ?>
					
					 
					 
				 
					 
				</ul>
		</div> <!-- end .et_pb_widget -->	</div> <!-- end #sidebar -->
		</div>

	</div>
