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


<?
if(count($all)>0){
 foreach($all as $document){
 echo $document['content'];
 }   
}
?>


 
 
 