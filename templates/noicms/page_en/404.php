<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>404 | <?=$site['title'];?></title>
    <link href="{THEME_PATH}contain/css/bootstrap.min.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/font-awesome.min.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/prettyPhoto.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/animate.min.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/main.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{THEME_PATH}contain/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{THEME_PATH}contain/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{THEME_PATH}contain/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{THEME_PATH}contain/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="{THEME_PATH}contain/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<body>

     <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-4">
                        <div class="top-number"><p><a class="btn btn-active" target="_blank" href="https://vk.com/noicms"><i class="fa fa-vk"></i></a><i class="fa fa-skype">noi.studio</i></p></div>
                    </div>
                    <div class="col-sm-6 col-xs-8">

                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="{THEME_PATH}contain/images/logo_cms.png" style="height:54px;" alt="logo"></a>
                </div>

                <div class="collapse navbar-collapse navbar-right">
                    <widget position="top_nav_en">%%widget%%</widget>

                </div>
            </div>
        </nav>

    </header>

    <section id="error" class="container text-center">
        <h1>404,not found</h1>
        <p>You input wrong adress</p>
        <a class="btn btn-primary" href="/">Return to main</a>
    </section><!--/#error-->

   <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <widget position="bottom_en">
                    <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        %%widget%%
                    </div>
                </div><!--/.col-md-3-->
                </widget>

            </div>
        </div>
    </section><!--/#bottom-->

   <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    &copy; 2014 <a target="_blank" href="http://noicms.com/" title="NoiCMS">NoiCMS</a>. <script src="/js/counter.js"></script>
                </div>
                <div class="col-sm-8">

                </div>
            </div>
        </div>
    </footer>

    <script src="{THEME_PATH}contain/js/jquery.js"></script>
    <script src="{THEME_PATH}contain/js/bootstrap.min.js"></script>
    <script src="{THEME_PATH}contain/js/jquery.prettyPhoto.js"></script>
    <script src="{THEME_PATH}contain/js/jquery.isotope.min.js"></script>
    <script src="{THEME_PATH}contain/js/main.js"></script>
    <script src="{THEME_PATH}contain/js/wow.min.js"></script>
</body>
</html>