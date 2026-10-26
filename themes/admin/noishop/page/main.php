<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <meta charset="UTF-8">

    <meta name="description" content="Violate Responsive Admin Template">
    <meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

    <title><?= NoiCore::admin()->get('name'); ?></title>

    <!-- CSS -->
    <link href="/themes/admin/noishop/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/animate.min.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/file-manager.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/form.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/calendar.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/style.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/form.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/icons.css" rel="stylesheet">
    <link href="/themes/admin/noishop/assets/css/generics.css" rel="stylesheet">
    <link rel="stylesheet" href="/themes/admin/noishop/assets/js/elrte/css/elrte.min.css" type="text/css" media="screen" charset="utf-8">
    <script src="/themes/admin/noishop/assets/js/jquery.min.js"></script>
    <script src="/themes/admin/noishop/assets/js/jquery_migrate.js"></script>
    <link href="/themes/admin/noishop/assets/froala/css/froala_editor.min.css" rel="stylesheet" type="text/css">
    <link href="/themes/admin/noishop/assetsfroala/css/froala_style.min.css" rel="stylesheet" type="text/css">


    <script src="/themes/admin/noishop/assets/froala//js/froala_editor.min.js"></script>
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
        var admin_path_url = "<?php echo NoiCore::app()->getRoute(''); ?>";
        var global_storage = [];
        var memory_usage = "<?php echo NoiCore::app()->lang('memory_usage') ?>";
    </script>
</head>
<?
$admin_style = NoiCore::admin()->getAdminStyle();
?>
<body id="<?php echo $admin_style; ?>">

    <header id="header" class="media">
        <a href="" id="menu-toggle"></a>
        <a class="logo pull-left" href="<?php echo NoiCore::app()->getRoute('index') ?>"><?= NoiCore::admin()->get('name'); ?></a>
        <?
        $current_page = Yii::$app->params['current_page'];

        if (NoiCore::admin()->isLogin()) {
            $date = date('Y-m-d');
            $prev_day = date('Y-m-d 23:59', strtotime('-1 day', strtotime($date)));
            ?>
            <div class="media-body">
                <div class="media" id="top-menu">
                    <?
                    $counts = NoiCore::admin()->getAll("head/count");
                    if (isset($counts) > 0) {
                        foreach ($counts as $c) {
                            echo $c;
                        }
                    }
                    ?>







                    <div id="time" class="pull-right">
                        <span id="hours"></span>
                        :
                        <span id="min"></span>
                        :
                        <span id="sec"></span>
                    </div>

                    <div class="media-body">
                        <a href="<?php echo NoiCore::app()->getRoute('index'); ?>?set_language=ru"><img src="/themes/admin/noicms/contain/lang/rus.jpg"></a>
                        <a href="<?php echo NoiCore::app()->getRoute('index'); ?>?set_language=en"><img src="/themes/admin/noicms/contain/lang/eng.jpg"></a>
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
        if (NoiCore::admin()->isLogin()) {
            ?>
            <!-- Sidebar -->
            <aside id="sidebar">

                <!-- Sidbar Widgets -->
                <div class="side-widgets overflow">
                    <!-- Profile Menu -->
                    <div class="text-center s-widget m-b-25 dropdown" id="profile-menu">
                        <a href="<?php echo NoiCore::app()->getRoute('index') ?>" data-toggle="dropdown">
                            <img class="profile-pic animated" src="<?= NoiCore::admin()->get('logo'); ?>" alt="">
                        </a>

                        <ul class="dropdown-menu profile-menu">


                            <li><a href="<?php echo NoiCore::app()->getRoute('setup') ?>"><?php echo NoiCore::app()->lang("links_config"); ?></a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="<?php echo NoiCore::app()->getRoute('logout'); ?>"><?php echo NoiCore::app()->lang('btn_logout'); ?></a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                        </ul>

                        <h4 class="m-0"><form id="themeform" action="" method="POST"><select id="supertheme" name="admin_style">
                                    <option <?
                                    if ($admin_style == "skin-blur-violate") {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="skin-blur-violate">Blur Violate</option>
                                    <option <?
                                    if ($admin_style == "skin-blur-blue") {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="skin-blur-blue">Blur Blue</option>
                                    <option <?
                                        if ($admin_style == "skin-blur-chrome") {
                                            echo 'selected="selected"';
                                        }
                                        ?>  value="skin-blur-chrome">Blur Chrome</option>
                                    <option <?
                                    if ($admin_style == "skin-blur-city") {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="skin-blur-city">Blur City</option>
                                    <option <?
                                    if ($admin_style == "skin-blur-greenish") {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="skin-blur-greenish">Blur Greenish</option>
                                    <option <?
                                        if ($admin_style == "skin-blur-kiwi") {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="skin-blur-kiwi">Blur Kiwi</option>
                                    <option <?
                                    if ($admin_style == "skin-blur-lights") {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="skin-blur-lights">Blur Lights</option>
                                    <option <?
                                    if ($admin_style == "skin-blur-night") {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="skin-blur-night">Blur Night</option>
                                    <option <?
                                        if ($admin_style == "skin-blur-ocean") {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="skin-blur-ocean">Blur Ocean</option>
                                    <option <?
                                        if ($admin_style == "skin-blur-sunny") {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="skin-blur-sunny">Blur Sunny</option>
                                    <option <?
                                        if ($admin_style == "skin-blur-sunset") {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="skin-blur-sunset">Blur Sunset</option>
                                    <option <?
                                        if ($admin_style == "skin-blur-yellow") {
                                            echo 'selected="selected"';
                                        }
                                        ?>  value="skin-blur-yellow">Blur Yellow</option>
                                    <option <?
                    if ($admin_style == "skin-cloth") {
                        echo 'selected="selected"';
                    }
                    ?> value="skin-cloth">Cloth</option>
                                    <option <?
                    if ($admin_style == "skin-blur-tectile") {
                        echo 'selected="selected"';
                    }
                    ?> value="skin-tectile">Tectile</option>

                                </select></form></h4>
                    </div>

                    <!-- Calendar -->
                    <div class="s-widget m-b-25">
                        <div id="sidebar-calendar"></div>
                    </div>

                    <!-- Feeds -->


                    <!-- Projects -->

                </div>

                <!-- Side Menu -->
                <ul class="list-unstyled side-menu">
                    <li class="<?
                    if ($current_page == "default") {
                        echo "active";
                    }
                    ?>">
                        <a class="sa-side2-home" href="<?php echo NoiCore::app()->getRoute('index'); ?>">
                            <span class="menu-item"><?php echo NoiCore::app()->lang("dashboard"); ?></span>
                        </a>
                    </li>

                    <li class="<?
                    if ($current_page == "filemanager") {
                        echo "active";
                    }
                    ?>">
                        <a class="sa-side2-filemanager" href="<?php echo NoiCore::app()->getRoute('filemanager/index'); ?>">
                            <span class="menu-item"><?php echo NoiCore::app()->lang("main_filemanager"); ?></span>
                        </a>
                    </li>
                    <li class="<?
                               if ($current_page == "trash") {
                                   echo "active";
                               }
                    ?>">
                        <a class="sa-side2-trash" href="<?php echo NoiCore::app()->getRoute('trash/index'); ?>">
                            <span class="menu-item"><?php echo NoiCore::app()->lang('trash_title'); ?>(<?php echo NoiCore::admin()->getCountTrash(); ?>)</span>
                        </a>
                    </li>
                                   <?
                                   $nav_main = NoiCore::admin()->getAll("nav/index");
                                   ?>
                                   <?
                                   if (count($nav_main) > 0) {
                                       foreach ($nav_main as $nav) {
                                           echo $nav;
                                       }
                                   }
                                   ?>
                    <li class="dropdown <?
                                if ($current_page == "about" or $current_page == "setup" or $current_page == "mobile" or $current_page == "route" or $current_page == "template" or $current_page == "sites" or $current_page == "sessions" or $current_page == "db" or $current_page == "admins" or $current_page == "plugins" or $current_page == "wi_all" or $current_page == "wi_positions" or $current_page == "logs" or $current_page == "language") {
                                    echo "active";
                                }
                                ?>">
                        <a class="sa-side2-system" href="#">
                            <span class="menu-item"><?php echo NoiCore::app()->lang("main_system"); ?></span>
                        </a>
                        <ul class="list-unstyled menu-item">
                            <li ><a class="<?
                                if ($current_page == "about") {
                                    echo 'active';
                                }
                                ?>" href="<?php echo NoiCore::app()->getRoute('about') ?>"><?php echo NoiCore::admin()->get('name'); ?></a></li>
                            <li><a class="<?
                            if ($current_page == "setup") {
                                echo 'active';
                            }
                            ?>" href="<?php echo NoiCore::app()->getRoute('setup') ?>"><?php echo NoiCore::app()->lang("links_config"); ?></a></li>
                            <li><a class="<?
                            if ($current_page == "language") {
                                echo 'active';
                            }
                                ?>" href="<?php echo NoiCore::app()->getRoute('language/index') ?>"><?php echo NoiCore::app()->lang('manage_language'); ?></a></li>
                            <li><a class="<?
        if ($current_page == "mobile") {
            echo 'active';
        }
        ?>" href="<?php echo NoiCore::app()->getRoute('mobile/index') ?>"><?php echo NoiCore::app()->lang('setup_mobile'); ?></a></li>
                            <li><a class="<?
                    if ($current_page == "route") {
                        echo 'active';
                    }
                    ?>" href="<?php echo NoiCore::app()->getRoute('route') ?>"><?php echo NoiCore::app()->lang("links_config_route"); ?></a></li>
                            <li><a class="<?
                    if ($current_page == "template") {
                        echo 'active';
                    }
                    ?>" href="<?php echo NoiCore::app()->getRoute('template') ?>"><?php echo NoiCore::app()->lang("links_config_template"); ?></a></li>
                            <li><a class="<?
                if ($current_page == "logs") {
                    echo 'active';
                }
                ?>" href="<?php echo NoiCore::app()->getRoute('logs') ?>"><?php echo NoiCore::app()->lang("links_config_logs") ?></a></li>
                            <li><a class="<?
                if ($current_page == "sites") {
                    echo 'active';
                }
                ?>" href="<?php echo NoiCore::app()->getRoute('sites/index') ?>"><?php echo NoiCore::app()->lang('multisites'); ?></a></li>
                            <li><a class="<?
                if ($current_page == "sessions") {
                    echo 'active';
                }
                ?>" href="<?php echo NoiCore::app()->getRoute('sessions/index') ?>"><?php echo NoiCore::app()->lang('sessions'); ?></a></li>
                            <li><a class="<?
                if ($current_page == "db") {
                    echo 'active';
                }
                ?>" href="<?php echo NoiCore::app()->getRoute('db/index') ?>"><?php echo NoiCore::app()->lang("links_config_db") ?></a></li>
                            <li><a class="<?
            if ($current_page == "admins") {
                echo 'active';
            }
                ?>" href="<?php echo NoiCore::app()->getRoute('admins') ?>"><?php echo NoiCore::app()->lang("links_config_admins") ?></a></li>
                            <li><a  class="<?
            if ($current_page == "plugins") {
                echo 'active';
            }
            ?>" href="<?php echo NoiCore::app()->getRoute("plugins") ?>"><?php echo NoiCore::app()->lang("links_plugins_manage"); ?></a></li>
                            <li><a class="<?
            if ($current_page == "wi_all") {
                echo 'active';
            }
            ?>" href="<?php echo NoiCore::app()->getRoute("wi/all") ?>"><?php echo NoiCore::app()->lang("links_widgets_manage"); ?></a></li>
                            <li><a class="<?
            if ($current_page == "wi_positions") {
                echo 'active';
            }
            ?>" href="<?php echo NoiCore::app()->getRoute("wi/positions") ?>"><?php echo NoiCore::app()->lang("links_widgets_manage_positions"); ?></a></li>
                        </ul>

                    </li>
                </ul>

            </aside>
    <?
}
?>
        <!-- Content -->
        <section id="content" class="container" style="height:100%;">
            <ul class="nav nav-tabs">



<?
$top_main = NoiCore::admin()->getAll("top/index");
?>
<?
if (count($top_main) > 0) {
    foreach ($top_main as $top) {
        echo $top;
    }
}
?>  

            </ul>
            <!-- Messages Drawer -->
<?
if (NoiCore::admin()->isLogin()) {
    $head_message = NoiCore::admin()->getAll('head/contain');
    if (count($head_message) > 0) {
        foreach ($head_message as $hm) {
            echo $hm;
        }
    }
    ?>


                <!-- Notification Drawer -->

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
        $(".delete").on("click", function () {
            return confirm('Вы правда хотите удалить?');
        });


    </script>
<?
$css_arrays = NoiCore::admin()->getCssArray();
$json_css = json_encode($css_arrays);
?>
    <script src="/themes/admin/noishop/assets/js/elrte/elrte.full_1.js" type="text/javascript" charset="utf-8"></script>
    <!-- elRTE translation messages -->
    <script src="/themes/admin/noishop/assets/js/elrte/i18n/elrte.ru.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        $().ready(function () {
            $('.froala').editable({inlineMode: false});
            $('.fupload').live('click', function () {

                var name = $(this).data("name");

                $('<div id="editor" />').dialogelfinder({
                    url: '<?php echo NoiCore::app()->getRoute('filemanager/setup') ?>',
                    commandsOptions: {
                        getfile: {
                            oncomplete: 'destroy'
                        }
                    },
                    getFileCallback: function (file) {
                        $("#fupload_" + name).show();
                        $("#fupload_" + name).attr("src", file.url);
                        $("#var_fupload_" + name).val(file.url);
                        jQuery('a.ui-dialog-titlebar-close[role="button"]').click();
                        //$('#editor').closest('.elfinder').val(file.path);



                    }
                });
                return false;
            });
            $(".savelink").on("click", function () {
                var normal_link = $(this).attr("data-normal");
                var seo_link = $(".seo_link").val();
                $.post("<?php echo NoiCore::app()->getRoute('ajroute'); ?>", {seo: seo_link, normal: normal_link})
                        .done(function (data) {
                            // alert( "Data Loaded: " + data );
                        });
                return false;
            })
            var opts = {
                cssClass: 'el-rte',
                lang: '<?php echo NoiCore::app()->lang("filemanager_lang"); ?>',
                height: 450,
                toolbar: 'complete',
                cssfiles: <?php echo $json_css; ?>,
                fmAllow: true,
                fmOpen: function (callback) {

                    $('<div />').dialogelfinder({
                        resizable: false,
                        url: '<?php echo NoiCore::app()->getRoute('filemanager/setup') ?>', // connector URL (REQUIRED)
                        lang: '<?php echo NoiCore::app()->lang("filemanager_lang"); ?>',
                        uiOptions: {
                            toolbar: [
                                ['back', 'forward', 'home', 'reload'],
                                ['mkdir', 'mkfile', 'upload'],
                                ['view', 'sort'],
                                ['search'], ['resize']
                            ]},
                        height: 500,
                        commandsOptions: {
                            getfile: {
                                oncomplete: 'destroy' // destroy elFinder after file selection
                            }
                        },
                        getFileCallback: function (file) {
                            callback(file.url);
                        }
                    });
                }
            }
            $('.editore').elrte(opts);

        })
        $().ready(function () {
            $('#elrte').elrte({
            });
        });
        $('#supertheme').change(function () {
            $('#themeform').submit();
        });

    </script>
    <link rel="stylesheet" href="/themes/admin/noishop/assets/js/growl/jquery.jgrowl.css" type="text/css"/>
    <script type="text/javascript" src="/themes/admin/noishop/assets/js/growl/jquery.jgrowl.js"></script>
<?
$result = NoiCore::app()->getNotify();

if (isset($result)) {
    ?>
        <script>
    <?
    foreach ($result as $key => $message) {
        ?>
            $.jGrowl("<?php echo $message; ?>");
        <?
    }
    ?>
        </script>
    <?
}
?>
    <script src='https://noiproject.com/project/widget/wUGAirad.js'></script>
</body>
</html>
