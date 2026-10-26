<?
NoiCore::app()->setParam("type","news");

?>
<?
NoiCore::app()->setParam("pagelink","5_3");  
?>
 
					  <!-- .et_pb_section -->
				
				
					
					<div class=" et_pb_row et_pb_row_0" style="padding-top:0px;margin-top:0px;">
				
			 <div class="et_pb_column et_pb_column_4_4 et_pb_column_0">
				<div class="et_pb_blog_grid_wrapper">
                                    <div class="et_pb_blog_grid clearfix et_pb_module et_pb_bg_layout_light  et_pb_blog_0" data-columns="3">
                                <?
                                $arrays=array_chunk($all, 2);
                                if(count($arrays)>0){
                                foreach($arrays as $arr){
                               
                                    
                                  
                                ?>
                               <div class="column size-1of3">
                     <?
                      if(count($arr)>0){
                                foreach($arr as $document){
                     ?>
                    <article id="post-2835" class="et_pb_post post-2835 post type-post status-publish format-standard has-post-thumbnail hentry category-89">

			<div class="et_pb_image_container"><a href="<?=$url_document;?><?=$document['last_id'];?>.html">
								<img src="<?=$document['image'];?>" alt="<?=$document['title'];?>" width="400" height="250">							</a>
					</div> <!-- .et_pb_image_container -->
												<h2><a href="<?=$url_document;?><?=$document['last_id'];?>.html"><?=$document['title'];?></a></h2>
				
				 <?=$document['short'];?>
 <a href="<?=$url_document;?><?=$document['last_id'];?>.html" class="more-link"><?=NoiCore::app()->lang('news_readmore');?></a>			
			</article>
                                   <?
                                 }    
                                } 
                                   ?>
                            
                                        
                                        </div>         
                                <?        
                                }    
                                }
                                ?>
                                 
                                 
                                        
                             </div>
                                    <div class="et_pb_blog_grid clearfix et_pb_module et_pb_bg_layout_light  et_pb_blog_0" data-columns="3" >
                                 
                               
                                            
                                           
                                    
                                        
                                    </div> <!-- .et_pb_posts -->
                                    <div class="pagination clearfix">
	<?=$pages;?>
</div>
			</div>
			</div> <!-- .et_pb_column -->
					
			</div> <!-- .et_pb_row -->
				
			
 
                					 
