<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">



        <title><?=NoiCore::admin()->get('name');?></title>

        <!-- CSS -->
        <link href="/themes/admin/noishop/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/form.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/style.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/animate.css" rel="stylesheet">
        <link href="/themes/admin/noishop/assets/css/generics.css" rel="stylesheet">
    </head>
    <body id="<?php echo NoiCore::admin()->getAdminStyle();?>">
        <section id="login">
            <header>
                <h1><a target="_blank" href="http://noicms.com"><img src="<?=NoiCore::admin()->get('logo');?>"></a> <a href="<?php echo   NoiCore::app()->getRoute('index');?>?set_language=ru"><img src="/themes/admin/noicms/contain/lang/rus.jpg"></a>
                           <a href="<?php echo   NoiCore::app()->getRoute('index');?>?set_language=en"><img src="/themes/admin/noicms/contain/lang/eng.jpg"></a></h1>
         
<?=NoiCore::admin()->get("description");?>
            </header>

            <div class="clearfix"></div>

            <!-- Login -->
            <form class="box tile animated active" action="" method="POST" id="box-login">
                <h2 class="m-t-0 m-b-15"><?php echo NoiCore::app()->lang("login_title");?></h2>
                <input type="text"  name="username" class="login-control m-b-10" placeholder="<?php echo NoiCore::app()->lang('login_title_username');?> ">
                <input type="password" name="password" class="login-control" placeholder="<?php echo NoiCore::app()->lang('login_title_password');?>">
                <div class="checkbox m-b-20">
                    <label>
                        <input type="checkbox">
                        Remember Me
                    </label>
                </div>
                <button class="btn btn-sm m-r-5"><?php echo NoiCore::app()->lang("login_button");?></button>

                 
            </form>


        </section>

        <!-- Javascript Libraries -->
        <!-- jQuery -->
        <script src="/themes/admin/noishop/assets/js/jquery.min.js"></script> <!-- jQuery Library -->

        <!-- Bootstrap -->
        <script src="/themes/admin/noishop/assets/js/bootstrap.min.js"></script>

        <!--  Form Related -->
        <script src="/themes/admin/noishop/assets/js/icheck.js"></script> <!-- Custom Checkbox + Radio -->

        <!-- All JS functions -->
        <script src="/themes/admin/noishop/assets/js/functions.js"></script>
    </body>
</html>
