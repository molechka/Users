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
<section>
  
    <div class='container'>
   
        <div id='sitewrapper' class='row'>
          <div class="panel-group" id="accordion">
              <?
              if(count($all)>0){
               foreach($all as $document){
               ?>
             <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$document['last_id'];?>"><?=$document['title'];?></a></h4>
                                        </div>
                                        <div id="collapse<?=$document['last_id'];?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <?=$document['content'];?>
                                            </div>
                                        </div>
                                    </div> 
               <?
               }   
              }
              ?>
                                    

                                     
                                </div>  
        </div>
    </div>
</section>
