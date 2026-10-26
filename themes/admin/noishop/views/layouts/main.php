<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">

        <meta name="description" content="Violate Responsive Admin Template">
        <meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

        <title>NoiCMS Admin</title>

        <!-- CSS -->
        <link href="/themes/admin/noishop/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/animate.min.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/form.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/calendar.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/style.css" rel="stylesheet">
         <link href="/themes/admin/noishop/assets/css/form.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/icons.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/generics.css" rel="stylesheet">
<link rel="stylesheet" href="/themes/admin/noishop/assets/js/elrte/css/elrte.min.css" type="text/css" media="screen" charset="utf-8">
        <script src="/themes/admin/noishop/assets/js/jquery.min.js"></script>
        <script src="/themes/admin/noishop/assets/js/jquery_migrate.js"></script>
        <style>
            .ui-widget{
            z-index: 9999999;;
            }
        </style>
	<link rel="stylesheet" href="/themes/admin/noishop/assets/js/elrte/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" charset="utf-8">

	<!-- elRTE -->
	
	<link rel="stylesheet" href="/themes/admin/noishop/assets/js/elrte/css/elrte.min.css" type="text/css" media="screen" charset="utf-8">
  <script src="/themes/admin/noishop/assets/js/file-manager/elfinder.min.js"></script>
  <script src="/themes/admin/noishop/assets/js/file-manager/i18n/elfinder.ru.js" type="text/javascript" charset="utf-8"></script>

  <link href="/themes/admin/noishop/assets/css/file-manager.css" rel="stylesheet">
        <script>
        var admin_path_url="<?php echo   NoiCore::app()->getRoute('');?>";
        </script>
    </head>
    <body id="skin-blur-kiwi">

        <header id="header" class="media">
            <a href="" id="menu-toggle"></a>
            <a class="logo pull-left" href="<?php echo NoiCore::app()->getRoute('index')?>">NoiCMS Shop</a>
<?
$current_page=Yii::$app->params['current_page'];
 
if(NoiCore::admin()->isLogin()){
  $date=date('Y-m-d');
      $prev_day=date('Y-m-d 23:59', strtotime('-1 day', strtotime($date)));
?>
            <div class="media-body">
                <div class="media" id="top-menu">
                    <div class="pull-left tm-icon">
                        <a data-drawer="messages" class="drawer-toggle" href="">
                            <i class="sa-top-message"></i>
                            <i class="n-count animated"><?php echo NoiCore::app()->db()->count("plugin_form_messages",array('date'=>array('$gt'=>new MongoDate(strtotime($prev_day)))))?></i>
                            <span><?php echo NoiCore::app()->lang("h_messages");?></span>
                           
                        </a>
                    </div>
                    <div class="pull-left tm-icon">
                        <a data-drawer="notifications" class="drawer-toggle" href="">
                            <i class="sa-top-updates"></i>
                            <i class="n-count animated"><?php echo NoiCore::app()->db()->count("comments_list",array('date'=>array('$gt'=>new MongoDate(strtotime($prev_day)))))?></i>
                            <span><?php echo NoiCore::app()->lang("h_comments");?></span>
                        </a>
                     
                    </div>
                 




                    <div id="time" class="pull-right">
                        <span id="hours"></span>
                        :
                        <span id="min"></span>
                        :
                        <span id="sec"></span>
                    </div>

                    <div class="media-body">
                         <a href="<?php echo   NoiCore::app()->getRoute('index');?>?set_language=ru"><img src="/themes/admin/noicms/contain/lang/rus.jpg"></a>
                           <a href="<?php echo   NoiCore::app()->getRoute('index');?>?set_language=en"><img src="/themes/admin/noicms/contain/lang/eng.jpg"></a>
                    </div>
                </div>
            </div>
            <?
}
            ?>
        </header>

        <div class="clearfix"></div>

        <section id="main" class="p-relative" role="main">
      
<?
if(NoiCore::admin()->isLogin()){ 
?>
            <!-- Sidebar -->
            <aside id="sidebar">

                <!-- Sidbar Widgets -->
                <div class="side-widgets overflow">
                    <!-- Profile Menu -->
                    <div class="text-center s-widget m-b-25 dropdown" id="profile-menu">
                        <a href="<?php echo NoiCore::app()->getRoute('index')?>" data-toggle="dropdown">
                            <img class="profile-pic animated" src="/themes/admin/noicms//contain/logo_cms.png" alt="">
                        </a>
                         
                        <ul class="dropdown-menu profile-menu">


                            <li><a href="<?php echo NoiCore::app()->getRoute('setup')?>"><?php echo NoiCore::app()->lang("links_config");?></a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="<?php echo   NoiCore::app()->getRoute('logout');?>"><?php echo NoiCore::app()->lang('btn_logout');?></a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                        </ul>
                        <h4 class="m-0">Noi Studio</h4>
                        <i class="fa fa-skype"></i>noi.studio
                    </div>

                    <!-- Calendar -->
                    <div class="s-widget m-b-25">
                        <div id="sidebar-calendar"></div>
                    </div>

                    <!-- Feeds -->
                    <div class="s-widget m-b-25">
                        <h2 class="tile-title">
                           <?php echo NoiCore::app()->lang("news_noicms");?>
                        </h2>

                        <div class="s-widget-body">
                            <div id="news-feed"></div>
                        </div>
                    </div>

                    <!-- Projects -->
                    <div class="s-widget m-b-25">
                        <h2 class="tile-title">
                            <?php echo NoiCore::app()->lang("content_statistics");?>
                        </h2>

                        <div class="s-widget-body">
                        <?
                        $count_alboms=NoiCore::app()->db()->count("gallery_alboms",array());
                        $count_page=NoiCore::app()->db()->count("user_content",array());
                        $count_post=NoiCore::app()->db()->count("user_blog",array());
                        $count_message=NoiCore::app()->db()->count("plugin_config_form",array());
                        $count_comments=NoiCore::app()->db()->count("comments_list",array());
                        $count_items=NoiCore::app()->db()->count("user_shop",array());
                        $all_percent=$count_alboms+$count_page+$count_post+$count_message+$count_comments+$count_items;
                        $percent_alboms=$count_alboms*100/$all_percent;
                        $percent_page=$count_page*100/$all_percent;
                        $percent_post=$count_post*100/$all_percent;
                        $percent_message=$count_message*100/$all_percent;
                        $percent_comments=$count_comments*100/$all_percent;
                        $percent_items=$count_items*100/$all_percent;
                        ?>

                            <div class="side-border">
                                <small><?php echo NoiCore::app()->lang("alboms");?></small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="progress-bar tooltips progress-bar-danger" style="width: <?php echo (int)$percent_alboms;?>%;" data-original-title="<?php echo (int)$percent_alboms;?>%">
                                         <span class="sr-only"><?php echo (int)$percent_alboms;?>;% Complete</span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small><?php echo NoiCore::app()->lang("pages");?></small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-info" style="width: <?php echo (int)$percent_page;?>%;" data-original-title="<?php echo (int)$percent_page;?>%">
                                          <span class="sr-only"><?php echo (int)$percent_page;?>% Complete</span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small><?php echo NoiCore::app()->lang("posts");?></small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-warning" style="width: <?php echo (int)$percent_post;?>%;" data-original-title="<?php echo (int)$percent_post;?>%">
                                          <span class="sr-only"><?php echo (int)$percent_post;?>% </span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small><?php echo NoiCore::app()->lang("messages");?></small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-success" style="width: <?php echo (int)$percent_message;?>%;" data-original-title="<?php echo (int)$percent_message;?>%">
                                          <span class="sr-only"><?php echo (int)$percent_message;?>% </span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small><?php echo NoiCore::app()->lang("comments");?></small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-success" style="width: <?php echo (int)$percent_comments;?>%;" data-original-title="<?php echo (int)$percent_comments;?>%">
                                          <span class="sr-only"><?php echo (int)$percent_comments;?>% </span>
                                     </a>
                                </div>
                            </div>
                             <div class="side-border">
                                <small><?php echo NoiCore::app()->lang("items");?></small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-success" style="width: <?php echo (int)$percent_items;?>%;" data-original-title="<?php echo (int)$percent_items;?>%">
                                          <span class="sr-only"><?php echo (int)$percent_items;?>% </span>
                                     </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Side Menu -->
                <ul class="list-unstyled side-menu">
                    <li class="<? if($current_page=="default"){ echo "active";} ?>">
                        <a class="sa-side-home" href="<?php echo NoiCore::app()->getRoute('index');?>">
                            <span class="menu-item"><?php echo NoiCore::app()->lang("dashboard");?></span>
                        </a>
                    </li>

                     <li class="<? if($current_page=="filemanager"){ echo "active";} ?>">
                        <a class="sa-side-folder" href="<?php echo NoiCore::app()->getRoute('filemanager/index');?>">
                            <span class="menu-item"><?php echo NoiCore::app()->lang("main_filemanager");?></span>
                        </a>
                    </li>
                  
                      
                    
                    
                       <li class="dropdown">
                        <a class="sa-side-ui" href="#">
                            <span class="menu-item"><?php echo NoiCore::app()->lang("main_system");?></span>
                        </a>
                         <ul class="list-unstyled menu-item">
                            <li><a href="<?php echo NoiCore::app()->getRoute('about')?>"><?php echo NoiCore::app()->lang("links_about");?></a></li>
                            <li><a href="<?php echo NoiCore::app()->getRoute('setup')?>"><?php echo NoiCore::app()->lang("links_config");?></a></li>
                             <li><a href="<?php echo NoiCore::app()->getRoute('route')?>"><?php echo NoiCore::app()->lang("links_config_route");?></a></li>
        <li><a href="<?php echo NoiCore::app()->getRoute('template')?>"><?php echo NoiCore::app()->lang("links_config_template");?></a></li>
        <li><a href="<?php echo NoiCore::app()->getRoute('logs')?>"><?php echo NoiCore::app()->lang("links_config_logs")?></a></li>
          <li><a href="<?php echo NoiCore::app()->getRoute('sessions/index')?>">Текущие сессии</a></li>
        <li><a href="<?php echo NoiCore::app()->getRoute('db/index')?>"><?php echo NoiCore::app()->lang("links_config_db")?></a></li>
        <li><a href="<?php echo NoiCore::app()->getRoute('admins')?>"><?php echo NoiCore::app()->lang("links_config_admins")?></a></li>
         <li><a href="<?php echo   NoiCore::app()->getRoute("plugins")?>"><?php echo NoiCore::app()->lang("links_plugins_manage");?></a></li>
            <li><a href="<?php echo   NoiCore::app()->getRoute("wi/all")?>"><?php echo NoiCore::app()->lang("links_widgets_manage");?></a></li>
                      <li><a href="<?php echo   NoiCore::app()->getRoute("wi/positions")?>"><?php echo NoiCore::app()->lang("links_widgets_manage_positions");?></a></li>
                        </ul>

                    </li>
                </ul>

            </aside>
<?
}
?>
            <!-- Content -->
            <section id="content" class="container">
                       <a id="elfinder_button" href="#">Кнопке</a> 
               <!-- Messages Drawer -->
               <?
if(NoiCore::admin()->isLogin()){
?>
                <div id="messages" class="tile drawer animated">
                    <div class="listview narrow">

                        <div class="overflow" id="message_container" style="height: 254px">
                            
                          
                        </div>
                        <div class="media text-center whiter l-100">
                            <a href="<?php echo NoiCore::app()->getRoute('p_form/messages/index');?>"><small><?php echo NoiCore::app()->lang('w_all_messages');?></small></a>
                        </div>
                    </div>
                </div>

                <!-- Notification Drawer -->
                <div id="notifications" class="tile drawer animated">
                    <div class="listview narrow">
                        <div class="media">
                            <a href=""><?php echo NoiCore::app()->lang('comment');?></a>
                            <span class="drawer-close">&times;</span>
                        </div>
                        <div class="overflow" id="comments_container" style="height: 254px">
                          
                      
                        </div>
                        <div class="media text-center whiter l-100">
                            <a href="<?php echo NoiCore::app()->getRoute('p_comment/admin');?>"><small><?php echo NoiCore::app()->lang('w_all_messages');?></small></a>
                        </div>
                    </div>
                </div>
<?
}
?>
                <!-- Breadcrumb -->
                 
            <?
            echo $content;
            ?>
            </section>

            <!-- Older IE Message -->
            <!--[if lt IE 9]>
                <div class="ie-block">
                    <h1 class="Ops">Ooops!</h1>
                    <p>You are using an outdated version of Internet Explorer, upgrade to any of the following web browser in order to access the maximum functionality of this website. </p>
                    <ul class="browsers">
                        <li>
                            <a href="https://www.google.com/intl/en/chrome/browser/">
                                <img src="/themes/admin/noishop/assets/img/browsers/chrome.png" alt="">
                                <div>Google Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mozilla.org/en-US/firefox/new/">
                                <img src="/themes/admin/noishop/assets/img/browsers/firefox.png" alt="">
                                <div>Mozilla Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com/computer/windows">
                                <img src="/themes/admin/noishop/assets/img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://safari.en.softonic.com/">
                                <img src="/themes/admin/noishop/assets/img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/downloads/ie-10/worldwide-languages">
                                <img src="/themes/admin/noishop/assets/img/browsers/ie.png" alt="">
                                <div>Internet Explorer(New)</div>
                            </a>
                        </li>
                    </ul>
                    <p>Upgrade your browser for a Safer and Faster web experience. <br/>Thank you for your patience...</p>
                </div>
            <![endif]-->
        </section>

        <!-- Javascript Libraries -->
        <!-- jQuery -->
         <!-- jQuery Library -->
        <script src="/themes/admin/noishop/assets/js/jquery-ui.min.js"></script> <!-- jQuery UI -->
        <script src="/themes/admin/noishop/assets/js/jquery.easing.1.3.js"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->

        <!-- Bootstrap -->
        <script src="/themes/admin/noishop/assets/js/bootstrap.min.js"></script>

        <!-- Charts -->
        <script src="/themes/admin/noishop/assets/js/charts/jquery.flot.js"></script> <!-- Flot Main -->
        <script src="/themes/admin/noishop/assets/js/charts/jquery.flot.time.js"></script> <!-- Flot sub -->
        <script src="/themes/admin/noishop/assets/js/charts/jquery.flot.animator.min.js"></script> <!-- Flot sub -->
        <script src="/themes/admin/noishop/assets/js/charts/jquery.flot.resize.min.js"></script> <!-- Flot sub - for repaint when resizing the screen -->

        <script src="/themes/admin/noishop/assets/js/sparkline.min.js"></script> <!-- Sparkline - Tiny charts -->
        <script src="/themes/admin/noishop/assets/js/easypiechart.js"></script> <!-- EasyPieChart - Animated Pie Charts -->
        <script src="/themes/admin/noishop/assets/js/charts.js"></script> <!-- All the above chart related functions -->

        <!-- Map -->
        <script src="/themes/admin/noishop/assets/js/maps/jvectormap.min.js"></script> <!-- jVectorMap main library -->
        <script src="/themes/admin/noishop/assets/js/maps/usa.js"></script> <!-- USA Map for jVectorMap -->
        <script src="/themes/admin/noishop/assets/js/maps/world.js"></script>

        <!--  Form Related -->
        <script src="/themes/admin/noishop/assets/js/icheck.js"></script> <!-- Custom Checkbox + Radio -->

        <!-- UX -->
        <script src="/themes/admin/noishop/assets/js/scroll.min.js"></script> <!-- Custom Scrollbar -->

        <!-- Other -->
        <script src="/themes/admin/noishop/assets/js/calendar.min.js"></script> <!-- Calendar -->
        <script src="/themes/admin/noishop/assets/js/feeds.min.js"></script> <!-- News Feeds -->

           <script src="/themes/admin/noishop/assets/js/select.min.js"></script> <!-- Custom Select -->
     

        <!-- Text Editor -->
        <script src="/themes/admin/noishop/assets/js/editor.min.js"></script> <!-- WYSIWYG Editor -->
<script src="/themes/admin/noishop/assets/js/autosize.min.js"></script>
        <!-- All JS functions -->
        <script src="/themes/admin/noishop/assets/js/functions.js"></script>
        <script>
         $(".delete").on("click",function(){
         return confirm('Вы правда хотите удалить?');
         });
         $(function(){
          $.get( "<?php echo NoiCore::app()->getRoute('p_form/style/messages')?>", function( data ) {
            
  $( "#message_container" ).html( data );
 
});
          return false;
         })
            $(function(){
          $.get( "<?php echo NoiCore::app()->getRoute('p_comment/style/comments')?>", function( data ) {

  $( "#comments_container" ).html( data );

});
          return false;
         })
        </script>

  <script src="/themes/admin/noishop/assets/js/elrte/elrte.min.js" type="text/javascript" charset="utf-8"></script>
	<!-- elRTE translation messages -->
	<script src="/themes/admin/noishop/assets/js/elrte/i18n/elrte.ru.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    
   
		$(document).ready(function() {
              $('#elfinder_button').live('click', function() {
            $('<div id="editor" />').dialogelfinder({
                url : '{{ path('ef_connect') }}',
                getFileCallback: function(file) {
                    $('#editor').dialogelfinder('close');
                    $('#editor').closest('.elfinder').val(file.path);
                    console.log($('#editor').closest('.elfinder-input'));
                    console.log(file.url);
                }
            });
        });
                $(".savelink").on("click",function(){
                  var normal_link=$(this).attr("data-normal");
                  var seo_link=$(".seo_link").val();
                $.post( "<?php echo NoiCore::app()->getRoute('ajroute');?>", { seo: seo_link, normal: normal_link })
  .done(function( data ) {
   // alert( "Data Loaded: " + data );
  });
                 return false;
                })
			var opts = {
				cssClass : 'el-rte',
				 lang     : '<?php echo NoiCore::app()->lang("filemanager_lang");?>',
				height   : 450,
				toolbar  : 'complete',
				cssfiles : ['css/elrte-inner.css'],
                                fmAllow:true,
                                 fmOpen : function(callback) {

    $('<div />').dialogelfinder({
      url: '<?php echo NoiCore::app()->getRoute('filemanager/setup');?>',
      commandsOptions: {
        getfile: {
          oncomplete: 'destroy' // destroy elFinder after file selection
        }
      },
     getFileCallback: function(file) { callback(file.url); }
    });
  }
			}
			$('.editore').elrte(opts);
		})
                $().ready(function() {
  $('#elrte').elrte({    
});
});
            
	</script>
        <link rel="stylesheet" href="/themes/admin/noishop/assets/js/growl/jquery.jgrowl.css" type="text/css"/>
<script type="text/javascript" src="/themes/admin/noishop/assets/js/growl/jquery.jgrowl.js"></script>
    <?
$result=  NoiCore::app()->getNotify();
var_dump($result);
if(isset($result)){
?>
<script>
<?
  foreach($result as $key=>$message){
?>
$.jGrowl("<?php echo $message;?>");
<?
  }
?>
</script>
<?


}
?>
 
    </body>
</html>
