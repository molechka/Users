     <ol class="breadcrumb">
  <li><a href="/">Home</a></li>
 
  <li class="active"><?=$category['title'];?></li>
</ol>
<div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">
	    		<div class="col-sm-12">
					<h2 class="title text-center"><?=$category['title'];?></h2>
                                        <ul class="list-group">
                                            <?
                                            foreach($all_posts as $post){
                                            ?>
                                            <li class="list-group-item"><a href="<?=$controller->getRoute('page/'.$post['_id']->__toString());?>"><?=$post['title'];?></a></li>
 <?
                                            }
 ?>
</ul>
<ul class="pagination">
 <?
              if(isset($paginate['pages']) and is_array($paginate['pages']) and count($paginate['pages'])>0){

             foreach($paginate['pages'] as $pages){
             $class="";
              if($current_page==$pages){
              $class="active";
              }
              ?>
              <li class="<?=$class;?>"><a href="<?=$url_paginator;?><?=$pages?>" title=""><?=$pages;?></a></li>

              <?
             }
              }

              ?>
</ul>
				</div>

			</div>
        </div>
 </div>

