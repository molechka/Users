<?
NoiCore::app()->setParam("pagelink","faq");  
?>
<article id="post-2406" class="post-2406 page type-page status-publish hentry">

				
					<div class="entry-content">
					<div class="et_pb_section et_pb_section_parallax  et_pb_section_0 et_pb_with_background et_section_regular">
				<div class="et_parallax_bg et_pb_parallax_css et_pb_inner_shadow" style="background-image: url({THEME_PATH}/wp-content/uploads/2015/05/bg-faq1.jpg);"></div>
				
					
					<div class=" et_pb_row et_pb_row_0">
				
				<div class="et_pb_column et_pb_column_1_2 et_pb_column_0">
				<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_0">
				
<h1><?=$form['title'];?></h1>
 <?=$before;?>

			</div> <!-- .et_pb_text -->
			</div> <!-- .et_pb_column --><div class="et_pb_column et_pb_column_1_2 et_pb_column_1">
				
			<div id="et_pb_contact_form_0" class="et_pb_module et_pb_contact_form_container clearfix  et_pb_contact_form_0">
				<?=$after;?>
				
				
				<div class="et_pb_contact">
					<div class="et-pb-contact-message"></div>

					<form class="et_pb_contact_form clearfix" method="post" action="/form/ajax/<?=$form['_id']->__toString();?>.html">
						<div class="et_pb_contact_left">
							<p class="clearfix">
								<label for="et_pb_contact_name_0" class="et_pb_contact_form_label"><?=NoiCore::app()->lang('form_field_name');?></label>
								<input type="text" id="et_pb_contact_name_0" class="input et_pb_contact_name" value="Имя" name="field_name">
							</p>
							<p class="clearfix">
								<label for="et_pb_contact_email_0" class="et_pb_contact_form_label">Email</label>
								<input type="text" id="et_pb_contact_email_0" class="input et_pb_contact_email" value="Email" name="field_email">
							</p>
						</div> <!-- .et_pb_contact_left -->

						<div class="clear"></div>
						<p class="clearfix">
							<label for="et_pb_contact_message_0" class="et_pb_contact_form_label"><?=NoiCore::app()->lang('form_field_message');?></label>
							<textarea name="field_message" id="et_pb_contact_message_0" class="et_pb_contact_message input"><?=NoiCore::app()->lang('form_field_message');?></textarea>
						</p>

						<input type="hidden" value="et_contact_proccess" name="et_pb_contactform_submit">
<div class="et_pb_contact_right">
				<p class="clearfix">
					<img src="data:image/jpg;base64,<?=base64_encode($captcha );?>" alt="Image verification"/> = <input class="input et_pb_contact_captcha"  id="verify" name="noicms_captcha"  type="text" placeholder="<?=NoiCore::app()->lang('form_field_captcha');?>" style="max-width:50%;">	</p>
			</div> <!-- .et_pb_contact_right -->
						<button type="submit" class="et_pb_contact_submit et_pb_button"><?=NoiCore::app()->lang('form_field_send');?></button>

						
			

						<input type="hidden" id="_wpnonce-et-pb-contact-form-submitted" name="_wpnonce-et-pb-contact-form-submitted" value="599c46966e"><input type="hidden" name="_wp_http_referer" value="/ru/%d0%b2%d0%be%d0%bf%d1%80%d0%be%d1%81%d1%8b/">
					</form>
				</div> <!-- .et_pb_contact -->
			</div> <!-- .et_pb_contact_form_container -->
			
			</div> <!-- .et_pb_column -->
					
			</div> <!-- .et_pb_row --><div class=" et_pb_row et_pb_row_1">
				
				<div class="et_pb_column et_pb_column_4_4 et_pb_column_2">
				<hr class="et_pb_module et_pb_space et_pb_divider_0 et-hide-mobile">
			</div> <!-- .et_pb_column -->
					
			</div> <!-- .et_pb_row -->
				
			</div> <!-- .et_pb_section -->
<script data-cfasync="false" type="text/javascript">
var addthis_config = {"data_ga_property":"UA-64729295-1","data_ga_social":true,"ui_atversion":300,"data_track_clickback":true,"data_track_addressbar":true,"ignore_server_config":true};
var addthis_share = {};
</script>
                <!-- AddThis Settings Begin -->
                <script data-cfasync="false" type="text/javascript">
                    var addthis_product = "wpp-5.1.1";
                    var wp_product_version = "wpp-5.1.1";
                    var wp_blog_version = "4.3";
                    var addthis_plugin_info = {"info_status":"enabled","cms_name":"WordPress","cms_version":"4.3","plugin_name":"AddThis Sharing Buttons","plugin_version":"5.1.1","anonymous_profile_id":"wp-45d585e72112db8256c946720f616e0f","select_prefs":{"addthis_per_post_enabled":true,"addthis_above_enabled":false,"addthis_below_enabled":true,"addthis_sidebar_enabled":false,"addthis_above_showon_home":false,"addthis_above_showon_posts":false,"addthis_above_showon_pages":false,"addthis_above_showon_archives":false,"addthis_above_showon_categories":false,"addthis_above_showon_excerpts":false,"addthis_below_showon_home":false,"addthis_below_showon_posts":true,"addthis_below_showon_pages":false,"addthis_below_showon_archives":false,"addthis_below_showon_categories":false,"addthis_below_showon_excerpts":false,"addthis_sidebar_showon_home":false,"addthis_sidebar_showon_posts":false,"addthis_sidebar_showon_pages":false,"addthis_sidebar_showon_archives":false,"addthis_sidebar_showon_categories":false,"sharing_enabled_on_post_via_metabox":true},"page_info":{"template":"pages","post_type":""}};
                    if (typeof(addthis_config) == "undefined") {
                        var addthis_config = {"data_ga_property":"UA-64729295-1","data_ga_social":true,"ui_atversion":300,"data_track_clickback":true,"data_track_addressbar":true,"ignore_server_config":true};
                    }
                    if (typeof(addthis_share) == "undefined") {
                        var addthis_share = {};
                    }
                    if (typeof(addthis_layers) == "undefined") {
                        var addthis_layers = {};
                    }
                </script>
                <script data-cfasync="false" type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55a6bde2aebf273a " async="async">
                </script>
                <script data-cfasync="false" type="text/javascript">
                    (function() {
                        var at_interval = setInterval(function () {
                            if(window.addthis) {
                                clearInterval(at_interval);
                                addthis.layers(addthis_layers);
                            }
                        },1000)
                    }());
                </script>
                					</div> <!-- .entry-content -->

				
				</article>

