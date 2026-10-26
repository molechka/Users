(function($) {
"use strict";

/* ==============================================
ANIMATION -->
=============================================== */

    new WOW({
	    boxClass:     'wow',      // default
	    animateClass: 'animated', // default
	    offset:       0,          // default
	    mobile:       true,       // default
	    live:         true        // default
    }).init();

/* ==============================================
LOADER -->
=============================================== */
		
	$(window).load(function() {
		$('#loader').delay(300).fadeOut('slow');
		$('#loader-container').delay(200).fadeOut('slow');
		$('body').delay(300).css({'overflow':'visible'});
	})

$(".sendnow").on("click",function(e){
 var form = $('.contactform'); // contact form
  var submit = $(this);  // submit button
  var alert = $('.alert'); // alert div for show alert message
 e.preventDefault(); 

    $.ajax({
      url:form.attr("action"), // form action url
      type: 'POST', // form submit method get/post
      dataType: 'html', // request type html/json/xml
      data: form.serialize(), // serialize form data 
      beforeSend: function() {
        alert.fadeOut();
        submit.html('Идет Отправка....'); // change submit button text
      },
      success: function(data) {
       console.log(data);
       var  obj = JSON.parse(data);
       if(obj.type=="error"){
       $(".notifyc").html('<div class="col-sm-12  alert alert-danger">'+obj.message+'</div>');    
       }else {
        $(".notifyc").html('<div class="col-sm-12  alert alert-success">'+obj.message+'</div>');    
       form.trigger('reset');
       }
        $(".notifyc").show();
         // reset form
        submit.html('Отправить сейчас'); // reset submit button text
      },
      error: function(e) {
        console.log(e)
      }
    });
    return false;
})
/* ==============================================
MENU HOVER -->
=============================================== */

	$('.dropdown').hover(function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
		}, function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
	});

/* ==============================================
FLEXSLIDER -->
=============================================== */

	$(window).load(function() {
	  $('.flexslider').flexslider({
	    animation: "slide",
	    controlNav: "thumbnails"
	  });
	});

/* ==============================================
ACCORDION -->
=============================================== */

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('fa-minus fa-plus');
    }
    $('.accordion').bind('hidden.bs.collapse', toggleChevron);
    $('.accordion').bind('shown.bs.collapse', toggleChevron);

/* ==============================================
FUN -->
=============================================== */

	function count($this){
		var current = parseInt($this.html(), 10);
		current = current + 10;
			$this.html(++current);
			if(current > $this.data('count')){
			$this.html($this.data('count'));
			} 
			else {    
			setTimeout(function(){count($this)}, 80);
			}
			}        
			$(".stat-count").each(function() {
			$(this).data('count', parseInt($(this).html(), 10));
			$(this).html('0');
		count($(this));
	});

})(jQuery);