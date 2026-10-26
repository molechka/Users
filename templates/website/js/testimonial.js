/* ==============================================
TESTIMONIAL -->
=============================================== */
(function($) {
"use strict";
	$(document).ready(function() {
		var image_array = new Array();
			image_array = [
				{image: '/tmp/files/1.jpg', link_url: '/tmp/files/1big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Amanda', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
				{image: '/tmp/files/2.jpg', link_url: '/tmp/files/2big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Ben', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
				{image: '/tmp/files/3.jpg', link_url: '/tmp/files/3big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Giselle', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
			        {image: '/tmp/files/4.jpg', link_url: '/tmp/files/4big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Giselle', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
                                        {image: '/tmp/files/5.jpg', link_url: '/tmp/files/5big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Giselle', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
                                        {image: '/tmp/files/6.jpg', link_url: '/tmp/files/6big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Giselle', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
                                        {image: '/tmp/files/7.jpg', link_url: '/tmp/files/7big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Giselle', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
                                        {image: '/tmp/files/8.jpg', link_url: '/tmp/files/8big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Giselle', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'},
                                    {image: '/tmp/files/9.jpg', link_url: '/tmp/files/9big.jpg', link_rel: 'prettyPhoto',
					upper_text_label_show: 0, upper_text_label: '', upper_text_label_style: '', lower_text_label_show: 1, lower_text_label: 'Giselle', lower_text_label_style: 'text-shadow: 1px 1px 1px #cccccc;'}
									
            ];
                       
			$('#slider1').content_slider({		// bind plugin to div id="slider1"
				map : image_array,				// pointer to the image map
				max_shown_items: 9,			// number of visible circles
				hv_switch: 0,					// 0 = horizontal slider, 1 = vertical
				active_item: 0,					// layer that will be shown at start, 0=first, 1=second...
				big_pic_width:134,
				big_pic_height:134,
				border_color:'#80c435',
				big_border:6,
				hide_prettyPhoto:1,
				small_border:1,
				small_pic_width:74,
				small_pic_height:74,
				wrapper_text_max_height:300,	// height of widget, displayed in pixels
				middle_click: 1,				// when main circle is clicked: 1 = slider will go to the previous layer/circle, 2 = to the next
				under_600_max_height: 1200,		// if resolution is below 600 px, set max height of content
				border_radius:	-1,				// -1 = circle, 0 and other = radius
				automatic_height_resize: 1,
				border_on_off: 1,
				allow_shadow: 0
			});
	});

})(jQuery);