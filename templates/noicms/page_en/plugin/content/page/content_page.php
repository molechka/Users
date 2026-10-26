    <ol class="breadcrumb">
  <li><a href="/">Home</a></li>
  <li><a href="<?=$controller->getRoute('s/'.$category['_id']->__toString());?>"><?=$category['title'];?></a></li>
  <li class="active"><?=$page['title'];?></li>
</ol>
<section id="about-us">

        <div class="container">
			<div class="center wow fadeInDown">
				<h2><?=$page['title'];?></h2>
                                <p class="lead">Date <?=date('Y-m-d H:i',$page['date']->sec);?></p>
			</div>

			<!-- about us slider -->



			<!-- Our Skill -->


			<!-- our-team -->
		  <?=$page['content'];?>
		</div><!--/.container-->
    </section><!--/about-us-->

