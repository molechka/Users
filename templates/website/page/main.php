<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->


 <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?
$image_type=NoiCore::app()->getParam("image_url");
if(is_array($image_type) and isset($image_type['url'])){
?>
 <meta property="og:image" content="<?=$image_type['url'];?>" />	     
<?     
}
?>
	<meta name="keywords" content="">

	<title><?=$site['title'];?></title>

     

	<link rel="stylesheet" type="text/css" href="{THEME_PATH}fonts/font-awesome-4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/stroke.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/animate.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/flexslider.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/carousel.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}rs-plugin/css/settings.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/content_slider_style.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}style.css">
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/bootstrap-spinner.css">

	<!-- COLORS -->
	<link rel="stylesheet" type="text/css" href="{THEME_PATH}css/custom.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
		
</head>
<body>

	<div id="loader">
	    <div class="loader-container">
	        <h3 class="loader-back-text"><img src="{THEME_PATH}images/loader.gif" alt="" class="loader"></h3>
	    </div>
	</div>
	
	<div id="wrapper">
		<header class="header">
			<nav class="navbar navbar-inverse" role="navigation">
				<div class="container">
				    <!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topbarnav">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
						</button>
				    </div>
				    <!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="topbarnav">
						<ul class="nav navbar-nav " style='margin-left:13%;'>
                                                    <widget position='menu_left'>
                                                     %%widget%%  
                                                    </widget>    
		                              
						</ul>
						<ul class="nav navbar-nav navbar-right" style='margin-left:11%;float:left !important;'>
                                                  <widget position='menu_right'>
                                                     %%widget%%  
                                                    </widget>    
                                               
                                                </ul>
					        
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>

			<div class="clearfix"></div>

			<nav class="yamm navbar navbar-default" role="navigation">
				<div class="container">
				    <!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
						</button>
						<div class="navbar-brand navbar-brand-centered">
                                                    <a style='color:white;' href='/'>Главная</a> <br> <a href="/"><img src="{THEME_PATH}images/logo.png" alt=""></a>
                                                
						</div>
				    </div>
				    <!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="navbar-brand-centered">
						<ul class="nav navbar-nav navbar-left" style='margin-left:13%;'>
						<li class="dropdown yamm-fw">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle" tabindex="0">Россия </a>
								<ul class="dropdown-menu">
					                <li>
										<div class="yamm-content">
						 
										</div>
									</li>
								</ul>
							</li>	
                                                        <li class="dropdown yamm-fw">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle" tabindex="0">Казахстан </a>
								<ul class="dropdown-menu">
					                <li>
										<div class="yamm-content">
						 
										</div>
									</li>
								</ul>
							</li>
                                                        <li class="dropdown yamm-fw">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle" tabindex="0">Кыргызстан </a>
								<ul class="dropdown-menu">
					                <li>
										<div class="yamm-content">
						 
										</div>
									</li>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right" style='margin-left:18%;float:left !important;'>
							 
							  <li class="dropdown yamm-fw">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle" tabindex="0">Турция </a>
								<ul class="dropdown-menu">
					                <li>
										<div class="yamm-content">
						 
										</div>
									</li>
								</ul>
							</li>
                                                         <li class="dropdown yamm-fw">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle" tabindex="0">ОАЭ </a>
								<ul class="dropdown-menu">
					                <li>
										<div class="yamm-content">
						 
										</div>
									</li>
								</ul>
							</li>
                                                        
                                                        <li class="dropdown yamm-fw">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle" tabindex="0">Испания </a>
								<ul class="dropdown-menu">
					                <li>
										<div class="yamm-content">
						 
										</div>
									</li>
								</ul>
							</li>
						</ul>
                                            <div class='pull-right'>
                                                <ul class="nav nav-pills nav-stacked">
                                                    <?
   if(!NoiCore::user()->isLogin()){
   ?>  
                                                    <li><a href='/user/login/index.html' class='btn btn-danger'>ВХОД</a></li>
   <?
   }else {
     ?>
                 <li><a href='/voucher/profile/index.html' class='btn btn-danger'>Вернуться</a></li>
                                              
     <?                                               
   }
   ?>
                                                   <?
    $get_session=NoiCore::app()->getSession("from_user");
   
    if(is_array($get_session) and isset($get_session['user']) and !NoiCore::user()->isLogin()){
    ?>  
                                                    <li><a href='/user/register/index.html?id=<?=$get_session['user']?>' class='btn btn-success'>Регистрация</a></li>
                                             <?
    }
                                             ?>
                                                </ul>
                                            
                                            </div>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
<?
if(!isset($plugin)){
?>
            <widget position='mainpage'>%%widget%%</widget>
<?
}else {
 echo $plugin;   
}
?>

		<footer class="footer text-center">
			<div class="footerbefore"></div>
			<div class="container">
				<div class="row">
				    

				    <div class="col-md-15 col-sm-3">
				    	<div class="widget">
				    		<div class="widget-title">
				    			<h4>Меню</h4>
				    			<hr>
				    		</div><!-- end widget-title -->
							<ul>
								  <widget position='menu_left'>
                                                     %%widget%%  
                                                    </widget>  
								  <widget position='menu_right'>
                                                     %%widget%%  
                                                    </widget>  
							</ul>
				    	</div><!-- end widget -->
				    </div><!-- end col -->

				    <div class="col-md-15 col-sm-3">
				    	<div class="widget">
				    		<div class="widget-title">
				    			<h4>Последние новости</h4>
				    			<hr>
                                                        <?
                                                        $news=NoiCore::app()->db()->query(array(),"news",array(),array('_id'=>-1),6);
                                                          
                                                        ?>
				    		</div><!-- end widget-title -->
							<ul>
                                                            <?
                                                            if(count($news)>0){
                                                             foreach($news as $new){
                                                              ?>
                                                            <li><a href="/mg/4/<?=$new['last_id'];?>"><?=$new['title'];?></a></li>
                                                              <?
                                                             }   
                                                            }
                                                            ?>
								
								 
							</ul>
				    	</div><!-- end widget -->
				    </div><!-- end col -->

				    <div class="col-md-15 col-sm-3">
				    	<div class="widget">
				    		<div class="widget-title">
				    			<h4>Юридические аспекты</h4>
				    			<hr>
				    		</div><!-- end widget-title -->
							<ul>
								<li><a href="/mg/7/1.html">Политика конфеденциальности</a></li>
								<li><a href="/mg/7/2.html">Пользовательское соглашение</a></li>
								 
							</ul>
				    	</div><!-- end widget -->
				    </div><!-- end col -->

				    <div class="col-md-15 col-sm-3">
				    	<div class="widget">
                                            <widget position='contact'>%%widget%%</widget>
				    	</div><!-- end widget -->
				    </div><!-- end col -->
				</div><!-- ebd row -->
			</div><!-- end container -->
		</footer><!-- end footer -->

		<div class="copyrights">
			<div class="container">	
				<div class="row clearfix">
                                    <?
                                    if(isset($_GET['isnoi'])){
                                     NoiCore::app()->setSession("isnoi",true);
                                    }
                                    $isnoi=NoiCore::app()->getSession("isnoi");
                                    ?>
                                  
                                    
                                    
                                  
					<div class="col-md-6">
                                            <?
                                            if($isnoi===true){
                                            ?>
						<p>Веб-сайт разработан  © <a target="_blank" href="http://noibiz.com">Веб-студией NOI</a>. Все права защищены</p>
					    <?
                                            }
                                            ?>
                                            
                                            
                                        </div>
					<div class="col-md-6">
						<img src="{THEME_PATH}images/copyrights.png" alt="" class="img-responsive">
					</div>
				</div><!-- end row -->
			</div><!-- end container -->
		</div>

	</div><!-- end wrapper -->
<?
if(!isset($plugin)){
?>
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="{THEME_PATH}js/jquery.min.js"></script>
	<script src="{THEME_PATH}js/bootstrap.min.js"></script>
	<script src="{THEME_PATH}js/retina.js"></script>
	<script src="{THEME_PATH}js/wow.js"></script>
	<script src="{THEME_PATH}js/parallax.js"></script>
	<script src="{THEME_PATH}js/flexslider.js"></script>
	<script src="{THEME_PATH}js/custom.js"></script>
	<script src="{THEME_PATH}js/jquery.spinner.js"></script>
	<script src="{THEME_PATH}js/carousel.js"></script>
         
	<script src="{THEME_PATH}js/owl-script.js"></script>
  	<!-- PORTFOLIO -->
    <script src="{THEME_PATH}js/isotope.js"></script>
    <script src="{THEME_PATH}js/imagesloaded.pkgd.js"></script>
    <script src="{THEME_PATH}js/masonry-home.js"></script> 
  	<!-- TESTIMONIALS -->
	<script src="{THEME_PATH}js/jquery.content_slider.min.js" type="text/javascript"></script>
	<script src="{THEME_PATH}js/jquery.mousewheel.js" type="text/javascript"></script>
	<script src="{THEME_PATH}js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
    <script src="{THEME_PATH}js/testimonial.js"></script>
  	<!-- SLIDER REV -->
	<script src="{THEME_PATH}rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script src="{THEME_PATH}rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <script>
	jQuery(document).ready(function() {
		jQuery('.tp-banner').show().revolution(
			{
			dottedOverlay:"none",
			delay:16000,
			startwidth:1170,
			startheight:720,
			hideThumbs:200,     
			thumbWidth:100,
			thumbHeight:50,
			thumbAmount:5,  
			navigationType:"none",
			navigationArrows:"solo",
			navigationStyle:"preview3",  
			touchenabled:"on",
			onHoverStop:"on",
			swipe_velocity: 0.7,
			swipe_min_touches: 1,
			swipe_max_touches: 1,
			drag_block_vertical: false,          
			parallax:"mouse",
			parallaxBgFreeze:"on",
			parallaxLevels:[10,7,4,3,2,5,4,3,2,1],
			parallaxDisableOnMobile:"off",           
			keyboardNavigation:"off",   
			navigationHAlign:"center",
			navigationVAlign:"bottom",
			navigationHOffset:0,
			navigationVOffset:20,
			soloArrowLeftHalign:"left",
			soloArrowLeftValign:"center",
			soloArrowLeftHOffset:20,
			soloArrowLeftVOffset:0,
			soloArrowRightHalign:"right",
			soloArrowRightValign:"center",
			soloArrowRightHOffset:20,
			soloArrowRightVOffset:0,  
			shadow:0,
			fullWidth:"on",
			fullScreen:"off",
			spinner:"spinner4",  
			stopLoop:"off",
			stopAfterLoops:-1,
			stopAtSlide:-1,
			shuffle:"off",  
			autoHeight:"off",           
			forceFullWidth:"off",                         
			hideThumbsOnMobile:"off",
			hideNavDelayOnMobile:1500,            
			hideBulletsOnMobile:"off",
			hideArrowsOnMobile:"off",
			hideThumbsUnderResolution:0,
			hideSliderAtLimit:0,
			hideCaptionAtLimit:0,
			hideAllCaptionAtLilmit:0,
			startWithSlide:0,
			fullScreenOffsetContainer: ""  
			}); 
		});
	</script>
<?
}else {
    ?>
    <script src="{THEME_PATH}js/jquery.min.js"></script>
	<script src="{THEME_PATH}js/bootstrap.min.js"></script>
	<script src="{THEME_PATH}js/retina.js"></script>
	<script src="{THEME_PATH}js/wow.js"></script>
	<script src="{THEME_PATH}js/parallax.js"></script>
	<script src="{THEME_PATH}js/flexslider.js"></script>
	<script src="{THEME_PATH}js/custom.js"></script>
	<script src="{THEME_PATH}js/jquery.spinner.js"></script>    
    <?    
}
?>
        <?
        if(NoiCore::app()->getParam("ismap")===true){
         ?>
        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
		(function($) {
		  "use strict";
			var locations = [
			['<div class="infobox"><h3 class="title"><a href="#">OUR USA OFFICE</a></h3><span>NEW YORK CITY 2045 / 65</span><br>+90 555 666 77 88</p></div></div></div>', 52.953824, -1.148319, 2]
			];
		
			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 10,
				scrollwheel: false,
				navigationControl: true,
				mapTypeControl: false,
				scaleControl: false,
				draggable: true,
				
				center: new google.maps.LatLng(52.953824, -1.148319),
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			});
		
			var infowindow = new google.maps.InfoWindow();
		
			var marker, i;
		
			for (i = 0; i < locations.length; i++) {  
		  
				marker = new google.maps.Marker({ 
				position: new google.maps.LatLng(locations[i][1], locations[i][2]), 
				map: map ,
				icon: 'images/marker.png'
				});
		
		
			  google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  infowindow.setContent(locations[i][0]);
				  infowindow.open(map, marker);
				}
			  })(marker, i));
			}
		})(jQuery);
	  </script> 
         <?
        }
        ?> 
</body>

 </html>