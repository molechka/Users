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

        <script src="/themes/admin/noishop/assets/js/jquery.min.js"></script>
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
      $prev_day=date('Y-m-d', strtotime('-1 day', strtotime($date)));
?>
            <div class="media-body">
                <div class="media" id="top-menu">
                    <div class="pull-left tm-icon">
                        <a data-drawer="messages" class="drawer-toggle" href="">
                            <i class="sa-top-message"></i>
                            <i class="n-count animated"><?php echo NoiCore::app()->db()->count("plugin_config_form",array('date'=>array('$gt'=>new MongoDate(strtotime($prev_day)))))?></i>
                            <span>Messages</span>
                        </a>
                    </div>
                    <div class="pull-left tm-icon">
                        <a data-drawer="notifications" class="drawer-toggle" href="">
                            <i class="sa-top-updates"></i>
                            <i class="n-count animated">9</i>
                            <span>Updates</span>
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
                        <input type="text" class="main-search">
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
                            <li><a href="">My Profile</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="">Messages</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="">Settings</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="<?php echo   NoiCore::app()->getRoute('logout');?>">Выход</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
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
                           News Feeds
                        </h2>

                        <div class="s-widget-body">
                            <div id="news-feed"></div>
                        </div>
                    </div>

                    <!-- Projects -->
                    <div class="s-widget m-b-25">
                        <h2 class="tile-title">
                            Projects on going
                        </h2>

                        <div class="s-widget-body">
                            <div class="side-border">
                                <small>Joomla Website</small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="progress-bar tooltips progress-bar-danger" style="width: 60%;" data-original-title="60%">
                                          <span class="sr-only">60% Complete</span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small>Opencart E-Commerce Website</small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-info" style="width: 43%;" data-original-title="43%">
                                          <span class="sr-only">43% Complete</span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small>Social Media API</small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-warning" style="width: 81%;" data-original-title="81%">
                                          <span class="sr-only">81% Complete</span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small>VB.Net Software Package</small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-success" style="width: 10%;" data-original-title="10%">
                                          <span class="sr-only">10% Complete</span>
                                     </a>
                                </div>
                            </div>
                            <div class="side-border">
                                <small>Chrome Extension</small>
                                <div class="progress progress-small">
                                     <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-success" style="width: 95%;" data-original-title="95%">
                                          <span class="sr-only">95% Complete</span>
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
                            <span class="menu-item">Dashboard</span>
                        </a>
                    </li>

                     <li class="<? if($current_page=="filemanager"){ echo "active";} ?>">
                        <a class="sa-side-folder" href="<?php echo NoiCore::app()->getRoute('filemanager/index');?>">
                            <span class="menu-item">Файловый менеджер</span>
                        </a>
                    </li>
                    <li class="dropdown <? if($current_page=="p_content"){ echo "active";} ?>">
                        <a class="sa-side-page" href="#">
                            <span class="menu-item">Страницы</span>
                        </a>
                        <?
                        $category_content=NoiCore::app()->db()->query2(array(),"user_content_category",array());
                        ?>
                        <ul class="list-unstyled menu-item">
                        <?
                        if(count($category_content)>0){
                        foreach($category_content as $cat_category){
                        ?>
                         <li><a href="<?php echo NoiCore::app()->getRoute("p_content/manage/show/".$cat_category['_id']->__toString());?>">Раздел  <?php echo $cat_category['title'];?></a></li>
                        <?
                        }
                        }
                        ?>
                            <li><a href="<?php echo NoiCore::app()->getRoute("p_content/category/show/");?>">Управление разделами</a></li>

                        </ul>
                    </li>
                      <li class="<? if($current_page=="p_blog"){ echo "active";} ?> dropdown">
                        <a class="sa-side-photos" href="">
                            <span class="menu-item">Галлерея</span>
                        </a>
                        <ul class="list-unstyled menu-item">
                        <li><a href="<?php echo NoiCore::app()->getRoute('p_gallery/config/size_default');?>">Настройки</a></li>
                         <li><a href="<?php echo NoiCore::app()->getRoute('p_gallery/alboms/index');?>">Альбомы</a></li>
                         <?
                         $alboms=NoiCore::app()->db()->query2(array(),"gallery_alboms",array());
                         if(isset($alboms) and count($alboms)>0){
                         foreach($alboms as $al){
                         ?>

                             <li><a href="<?php echo NoiCore::app()->getRoute('p_gallery/alboms/photo/'.$al['_id']->__toString());?>">Фотографии <?php echo $al['title'];?></a></li>
                         <?
                         }
                         }
                         ?>



                        </ul>
                    </li>
                    <li class="dropdown <? if($current_page=="p_blog"){ echo "active";} ?>">
                        <a class="sa-side-form" href="">
                            <span class="menu-item">Блог</span>
                        </a>
                        <ul class="list-unstyled menu-item">
                            <li><a  href="<?php echo NoiCore::app()->getRoute('p_blog/entry/index');?>">Записи</a></li>
                            <li><a href="<?php echo NoiCore::app()->getRoute('p_blog/category/index');?>">Категории</a></li>
                            <li><a href="<?php echo NoiCore::app()->getRoute('p_blog/config/config_blog');?>">Настройки</a></li>

                        </ul>
                    </li>
                    <li class=" <? if($current_page=="p_contact_form"){ echo "active";} ?>">
                        <a class="sa-side-table" href="<?php echo NoiCore::app()->getRoute('p_contact_form/config/main_conf');?>">
                            <span class="menu-item">Контакты</span>
                        </a>

                    </li>
                       <li class="dropdown">
                        <a class="sa-side-ui" href="#">
                            <span class="menu-item">Система</span>
                        </a>
                         <ul class="list-unstyled menu-item">
                            <li><a href="<?php echo NoiCore::app()->getRoute('about')?>"><?php echo NoiCore::app()->lang("links_about");?></a></li>
                            <li><a href="<?php echo NoiCore::app()->getRoute('setup')?>"><?php echo NoiCore::app()->lang("links_config");?></a></li>
                             <li><a href="<?php echo NoiCore::app()->getRoute('route')?>"><?php echo NoiCore::app()->lang("links_config_route");?></a></li>
        <li><a href="<?php echo NoiCore::app()->getRoute('template')?>"><?php echo NoiCore::app()->lang("links_config_template");?></a></li>
        <li><a href="<?php echo NoiCore::app()->getRoute('logs')?>"><?php echo NoiCore::app()->lang("links_config_logs")?></a></li>
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
               <!-- Messages Drawer -->
               <?
if(NoiCore::admin()->isLogin()){
?>
                <div id="messages" class="tile drawer animated">
                    <div class="listview narrow">

                        <div class="overflow" id="message_container" style="height: 254px">


                        </div>
                        <div class="media text-center whiter l-100">
                            <a href="<?php echo NoiCore::app()->getRoute('p_contact_form/messages');?>"><small>Посмотреть все</small></a>
                        </div>
                    </div>
                </div>

                <!-- Notification Drawer -->
                <div id="notifications" class="tile drawer animated">
                    <div class="listview narrow">
                        <div class="media">
                            <a href="">Notification Settings</a>
                            <span class="drawer-close">&times;</span>
                        </div>
                        <div class="overflow" style="height: 254px">
                            <div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">Nadin Jackson - 2 Hours ago</small><br>
                                    <a class="t-overflow" href="">Mauris consectetur urna nec tempor adipiscing. Proin sit amet nisi ligula. Sed eu adipiscing lectus</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/2.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">David Villa - 5 Hours ago</small><br>
                                    <a class="t-overflow" href="">Suspendisse in purus ut nibh placerat Cras pulvinar euismod nunc quis gravida. Suspendisse pharetra</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/3.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">Harris worgon - On 15/12/2013</small><br>
                                    <a class="t-overflow" href="">Maecenas venenatis enim condimentum ultrices fringilla. Nulla eget libero rhoncus, bibendum diam eleifend, vulputate mi. Fusce non nibh pulvinar, ornare turpis id</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/4.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">Mitch Bradberry - On 14/12/2013</small><br>
                                    <a class="t-overflow" href="">Phasellus interdum felis enim, eu bibendum ipsum tristique vitae. Phasellus feugiat massa orci, sed viverra felis aliquet quis. Curabitur vel blandit odio. Vestibulum sagittis quis sem sit amet tristique.</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">Nadin Jackson - On 15/12/2013</small><br>
                                    <a class="t-overflow" href="">Ipsum wintoo consectetur urna nec tempor adipiscing. Proin sit amet nisi ligula. Sed eu adipiscing lectus</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/2.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">David Villa - On 16/12/2013</small><br>
                                    <a class="t-overflow" href="">Suspendisse in purus ut nibh placerat Cras pulvinar euismod nunc quis gravida. Suspendisse pharetra</a>
                                </div>
                            </div>
                        </div>
                        <div class="media text-center whiter l-100">
                            <a href=""><small>VIEW ALL</small></a>
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
         $(function(){
          $.get( "<?php echo NoiCore::app()->getRoute('p_contact_form/style/messages')?>", function( data ) {

  $( "#message_container" ).html( data );

});
          return false;
         })
        </script>

 <script type="text/javascript" src="/themes/admin/noishop/assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
      plugins: "image advlist anchor autolink   charmap code colorpicker contextmenu directionality emoticons fullpage fullscreen hr importcss insertdatetime link lists media spellchecker tabfocus table textcolor",
    image_list: "<?php echo NoiCore::app()->getRoute("filemanager/list");?>",
    image_advtab: true,
    selector: ".editore"
 });
</script>


    </body>
</html>
