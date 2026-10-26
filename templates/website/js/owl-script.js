(function($) {
"use strict";
/* ==============================================
CAROUSEL -->
=============================================== */

   	$('#owl-client').owlCarousel({
		loop:true,
		margin:0,
		nav:false,
	    loop:true,
	    autoplay:true,
	    autoplayTimeout:2500,
	    autoplayHoverPause:true,
		dots:false,
		responsive:{
		0:{
		items:1
		},
		600:{
		items:3
		},
		1000:{
		items:5
		}
	}
	})
})(jQuery);