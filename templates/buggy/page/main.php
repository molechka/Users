<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from files.portnine.com/bootstrap-themes/AwesomeAdmin/1.6/preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 16 May 2016 07:13:34 GMT -->
    <head>
        <meta charset="utf-8">
        <title>Users</title>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">





        <!-- For sample logo only-->
        <!--Remove if you no longer need this font-->
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Aguafina+Script">    <!--For sample logo only-->





        <link type="text/css" href="{THEME_PATH}/js/sug/css/suggestions.css">
        <link rel="stylesheet" type="text/css" href="{THEME_PATH}preview/lib/bootstrap3/dist/css/bootstrap.css">
        <script src="https://use.fontawesome.com/1648dcb27f.js"></script>
        <script src="{THEME_PATH}preview/lib/jquery-1.11.2.min.js" type="text/javascript"></script>
        <script src="{THEME_PATH}preview/javascripts/site.js" type="text/javascript"></script>
        <link  rel="stylesheet" type="text/css" href="{THEME_PATH}js/goal/goalProgress.css">
        <script src="{THEME_PATH}js/goal/goalProgress.js"></script>
        <link rel="stylesheet" type="text/css" href="{THEME_PATH}preview/stylesheets/theme.css">
        <link rel="stylesheet" type="text/css" href="{THEME_PATH}sorter/blue/style.css">

        <style>
            .select2-results,.select2-selection__choice{
                color: black !important;
            }
        </style>
        <?php
        if (\bugs\models\StatModel::get_user_browser() == "ie") {
            NoiCore::app()->redirect("/bugs/old.html");
            exit;
        }
        ?>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->


        <!--[if lt IE 9]>
            <link rel="stylesheet" href="/reject/reject.css" media="all" />
            <script type="text/javascript" src="/reject/reject.min.js" data-text="Unfortunately, the browser you use, outdated and can not properly display the site. Please download any of the following browsers:"></script>
    <![endif]-->
        <link rel="shortcut icon" href="../assets/ico/favicon.html">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{THEME_PATH}/assets/ico/apple-touch-icon-144-precomposed.html">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{THEME_PATH}/assets/ico/apple-touch-icon-114-precomposed.html">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{THEME_PATH}/assets/ico/apple-touch-icon-72-precomposed.html">
        <link rel="apple-touch-icon-precomposed" href="{THEME_PATH}/assets/ico/apple-touch-icon-57-precomposed.html">
    </head>
    <?php
    $url = "";
    $token = NoiCore::app()->plugin_values("user", "token");
    if (isset($token[0]['url'])) {
        $url = $token[0]['url'];
    }
    if (isset($token[0]['token'])) {
        $token = $token[0]['token'];
    } else {
        $token = "";
    }
    ?>
    <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
    <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
    <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
    <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!-->
    <body class="">
        <!--<![endif]-->
        <div class="navbar navbar-inverse navbar-fixed-top ">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-reorder"></span>
                </button>
                <p><ins><a href="http://users.bugred.ru/"><b>Users</b></a></ins>  —&nbsp;бесплатный тестовый проект с багами и методами SOAP / REST. <ins><a href="https://okiseleva.blogspot.com/2017/04/users-soap-rest.html" target="_blank">О проекте</a></ins> . <ins><a href="https://testbase.atlassian.net/wiki/spaces/USERS/overview" target="_blank">Полная документация</a></ins> </p>

            </div>
            <?php
            if (NoiCore::user()->isLogin()) {
                $user = NoiCore::user()->load();
                ?>

                <div class="hidden-xs">
                    <ul class="nav navbar-nav pull-right">



                        <li class="hidden-phone newlink"><a href="/tasks/notify/index.html" role="button"><i class="fa icon-envelope"></i>&nbsp;<?= \tasks\models\NotifyModel::count(); ?> </a></li>
                        <li class="hidden-phone newlink"><a href="/tasks/my/index.html" role="button"><?= \tasks\models\TaskModel::getCount(); ?> заданий</a></li>
                        <li id="fat-menu" class="dropdown newlink">
                            <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= $user['avatar'] ?>" style="width:15px;"><?= $user['name']; ?>
                                <i class="icon-caret-down"></i>
                            </a>

                            <ul class="dropdown-menu" style="background-color:#de4222 !important;">
                                <li class="newlink"><a  tabindex="-1" href="/user/profile/index.html">Личный кабинет</a></li>

                                <li class="divider newlink"></li>
                                <li class="newlink"><a tabindex="-1"  href="/user/logout.html">Выход</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.navbar-collapse -->
                <?php
            }
            ?>
        </div>
    </div>


    <div class="navbar-collapse collapse">
        <div id="main-menu">



            <ul class="nav nav-tabs hidden-xs">

                <li class="newlink" ><a href="/" > <span>Пользователи</span></a></li>
                <?php
                if (!NoiCore::user()->isLogin()) {
                    ?>
                    <li class="newlink" ><a href="/user/login/index.html" > <span>Войти</span></a></li>
                    <?php
                } else {
                    ?>

                    <li class="newlink" ><a href="/tasks/index.html" > <span>Задачи</span></a></li>
                    <li class="newlink" ><a href="/companys/index.html" > <span>Компании</span></a></li>
                    <?php
                }
                ?>

            </ul>
        </div>
    </div>


    <div class="content ">
        <?php
        if (!isset($plugin)) {
            $pages = NoiCore::p("AdminUserFCP")->actionIndex();
            echo $pages;
        } else {
            echo $plugin;
        }
        ?>


        <div class='notifications top-right'></div>
        <div class='notifications bottom-right'></div>
        <div class='notifications top-left'></div>
        <div class='notifications bottom-left'></div>
        <footer>

            <hr>

            <p class="text-center"> Проект разработан компанией noi.studio специально для Ольги Назиной (ранее Киселевой) и ее <ins><a href="http://testbase.ru/learn">курсов</a></ins> © 2018</p>

            <p  class="text-center">&nbsp;<?php echo date('d.m.Y H:i'); ?></p>



        </footer>
    </div>
    <script src="{THEME_PATH}preview/lib/bootstrap3/dist/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip({animation: false});
        $(function () {
            $('.demo-cancel-click').click(function () {
                return false;
            });
        });
    </script>
    <script type="text/javascript" src="{THEME_PATH}/js/main.js"></script>
    <link href="https://cdn.jsdelivr.net/jquery.suggestions/16.2.2/css/suggestions.css" type="text/css" rel="stylesheet" />

    <!--[if lt IE 10]>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="{THEME_PATH}js/sug.js"></script>
    <script>
        $(".name_tab_bank").suggestions({
            serviceUrl: "<?= $url; ?>",
            token: "<?= $token; ?>",
            type: "BANK",
            floating: "true",
            count: 5,
            /* Вызывается, когда пользователь выбирает одну из подсказок */
            onSelect: function (suggestion) {
                $(".bank_name").val(suggestion.data.name.full);


                $(".bank_bik").val(suggestion.data.bic);
                $(".bank_kor").val(suggestion.data.correspondent_account);
                $(".bank_reg").val(suggestion.data.registration_number);
                // $(".bank_date").val(suggestion.data.date_registr);
                console.log(suggestion);
            }
        });
        $(".name_tab_fio").suggestions({
            serviceUrl: "<?= $url; ?>",
            token: "<?= $token; ?>",
            type: "NAME",
            floating: "true",
            count: 5,
            /* Вызывается, когда пользователь выбирает одну из подсказок */
            onSelect: function (suggestion) {
                $(".fio_surname").val(suggestion.data.surname);
                $(".fio_name").val(suggestion.data.name);
                $(".fio_fathername").val(suggestion.data.patronymic);
                $(".fio_gender").val(suggestion.data.gender);

                console.log(suggestion);
            }
        });
        $(".name_tab_email").suggestions({
            serviceUrl: "<?= $url; ?>",
            token: "<?= $token; ?>",
            type: "EMAIL",
            floating: "true",
            count: 5,
            /* Вызывается, когда пользователь выбирает одну из подсказок */
            onSelect: function (suggestion) {
                $(".email_domain").val(suggestion.data.domain);
                $(".email_user").val(suggestion.data.local);


                console.log(suggestion);
            }
        });
    </script>
    <link href="{THEME_PATH}/preview/lib/bootstrap-notify/bootstrap-notify.css" rel="stylesheet">
    <link href="{THEME_PATH}/preview/lib/bootstrap-notify/alert-bangtidy.css" rel="stylesheet">
    <link href="{THEME_PATH}/preview/lib/bootstrap-notify/alert-blackgloss.css" rel="stylesheet">
    <script src="{THEME_PATH}/preview/lib/bootstrap-notify/bootstrap-notify.js" type="text/javascript"></script>

    <script  type="text/javascript" src="{THEME_PATH}/js/dropzone.js"></script>
    <script type="text/javascript" src="{THEME_PATH}sorter/jquery.metadata.js"></script>
    <script type="text/javascript" src="{THEME_PATH}sorter/jquery.tablesorter.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $('.select2').select2();
        $(".superup").dropzone({maxFilesize: 2, url: "/bugs/xls/index", "init": function () {
                this.removeAllFiles(true);
                this.on("success", function (file, resp) {
                    this.removeAllFiles(true);
                    var obj = JSON.parse(resp);

                    if (obj.redirect) {

                        document.location.href = obj.redirect;
                    } else {

                        console.log(obj.message);
                        $('.bottom-right').notify({
                            title: "Ошибка при обработке",
                            timer: 30000000,
                            delay: 8000000000000,
                            z_index: 9999999,
                            message: {text: obj.message},
                            type: 'danger',
                            newest_on_top: true
                        }).show();
                    }
                });

            }});
        $(".clickfile").on("click", function () {
            return $(".superup").click();
        });
        $(".superup > img").on("click", function () {

            return $(".superup").click();
        });
        if (document.location.hash)
        {

            $('a[href=' + location.hash + ']').click();

        }
        $(".toogle").on("click", function () {
            location.hash = $(this).attr("href");
            return true;
        });
        $(".startprogress").on("click", function () {
            $(".totalpage").hide();
            $(".superimg").show();
            $('#sample_goal').goalProgress({
                goalAmount: 200,
                currentAmount: 100,
                textBefore: '%',
                textAfter: ' выполнено',
                callback: function () {
                    var href = $(".startprogress").data("href");

                    document.location.href = href;
                }


            });
        });
        $(".checkjs").on("keyup", function () {
            var val = $(this).val();
            var maxlength = $(this).data("maxlength");
            if (maxlength != undefined) {
                if (val.length > maxlength) {
                    alert('Низя так много букаф писать');


                    val = val.slice(0, -1)
                    $(this).val(val);
                    return false;
                }
            }
        });
        $(".numberfilter3").on("keyup", function () {
            var val = $(this).val();


            var newval = val.replace(/\s/g, '');
            if (val != newval) {
                $(".formcontrol").attr("data-action", "javascript:return void();");
                console.error({
                    message: "ВОТ эта ОШИБОЧКА! Угадай почему она тут!!",
                    code: 403
                });
            }
        });
        $(".numberfilter4").on("keyup", function () {
            var field = $(this).parents("td").data("field");

            var val = $(this).val();
            var maxl = $(this).data("maxl");
            var max = $(this).data("max");


            if (val.length > max) {
                $(".formcontrol").attr("data-action", "javascript:return void();");
                console.error({
                    message: "ERROR! Too large for field " + field + ". Maximum - " + max,
                    code: 403
                });
            }
        });
        $(".field_need").on("keydown", function () {
            var element = this;
            var max = $(element).children("input").data("jsmax");

            if (max != undefined) {
                var field = $(element).data("field");
                if (max != undefined) {
                    var value = $(element).children("input").val();
                    if (value.length > max) {
                        console.error({
                            message: "ERROR! Too large for field " + field + ". Maximum - " + max,
                            code: 403
                        });

                    }
                }
            }
        })
        $(".formcontrol").on("submit", function () {
            var isresult = true;
            var action = $(this).data("action");
            $(".field_need  ").each(function (index, element) {
                var field = $(element).data("field");
                $("." + field + "_error").html(" ");
            });
            $(".field_need  ").each(function (index, element) {
                var max = $(element).children("input").data("max");
                var field = $(element).data("field");
                if (max != undefined) {
                    var value = $(element).children("input").val();
                    if (value.length > max) {
                        max = max - 1;
                        var message = "too large for field (actual: " + value.length + ", maximum: " + max + ")";
                        $("." + field + "_error").html(message);
                        isresult = false;
                    }
                }
            });
            if (isresult) {
                $(this).attr("action", action);
                return $(this).submit();
            }
        });
        $(".numberfilter").on("change", function () {
            var val = $(this).val();


            $(".number_" + $(this).data("myname")).val(val);

            val = val.replace(/\s/g, '');
            val = val.replace(/\d+/g, '');
            $(this).val(val);
        });
        $(".numberfilter2").on("keyup", function () {
            var val = $(this).val();


            val = val.replace(/\s/g, '');
            val = val.replace(/\d+/g, '');
            $(this).val(val);
        });

        {
            $(".table_for_sort").tablesorter();
        }
    </script>
    <link rel="stylesheet" href="/js/growl/jquery.jgrowl.css" type="text/css"/>
    <script type="text/javascript" src="/js/growl/jquery.jgrowl.js"></script>
    <?php
    if (NoiCore::user()->isLogin()) {
        \tasks\models\TaskModel::startnotify();
    }
    ?>





    <?php
    $result = NoiCore::notify()->getAll();
    if (isset($result)) {
        ?>
        <script>
    <?php
    foreach ($result as $key => $message) {
        ?>

            $('.bottom-right').notify({

                timer: 30000000,
                delay: 8000000000000,
                z_index: 9999999,
                message: {text: "<?php echo $message; ?>"},
                type: 'success',
                newest_on_top: true
            }).show();
    <?php }
    ?>
        </script>
        <?php
        NoiCore::notify()->removeAll();
    }
    ?>
    <script type="text/javascript" src="{THEME_PATH}/js/global.js"></script>
</body>

<!-- Mirrored from files.portnine.com/bootstrap-themes/AwesomeAdmin/1.6/preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 16 May 2016 07:13:49 GMT -->
</html>
