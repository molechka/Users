<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<? if(isset($site['description'])) { echo $site['description'];}?>">
     <meta name="keywords" content=" <? if(isset($site['keywords'])) { echo $site['keywords'];}?>">
    <meta name="author" content="">
    <title><?=$site['title'];?> </title>

	 
        <link href="{THEME_PATH}contain/css/bootstrap.min.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/font-awesome.min.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/animate.min.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/prettyPhoto.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/main.css" rel="stylesheet">
    <link href="{THEME_PATH}contain/css/responsive.css" rel="stylesheet">
  
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/favicon.ico">
       <script src="{THEME_PATH}contain/js/jquery.js"></script>
     
</head>

<body class="homepage">

    <header id="header">
       

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

                        <div class="top-number"><p><a class="btn btn-active" target="_blank" href="https://vk.com/noicms"><i class="fa fa-vk"></i></a><i class="fa fa-skype">noi.studio</i></p></div>
                    
            </div>
        </nav>

    </header>










<?

if(isset($plugin)){
echo $plugin;
}else {
?>
 <widget position="main_page_en">
     %%widget%%</widget>
<widget position="partners_en">%%widget%%</widget>
<?
}
?>


    





    
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
                    &copy; 2014 <a target="_blank" href="http://noicms.com/" title="NoiCMS">NoiCMS</a>.
                </div>
                <div class="col-sm-8">
                 <script>

document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t11.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24"+
" часа, посетителей за 24 часа и за сегодня' "+
"border='0' width='88' height='31'><\/a>");


                 </script>
                 <script>
(function(){
var widget_id = 761824;
_shcp =[{widget_id : widget_id}];
var lang =(navigator.language || navigator.systemLanguage
|| navigator.userLanguage ||"en")
.substr(0,2).toLowerCase();
var url ="widget.siteheart.com/widget/sh/"+ widget_id +"/"+ lang +"/widget.js";
var hcc = document.createElement("script");
hcc.type ="text/javascript";
hcc.async =true;
hcc.src =("https:"== document.location.protocol ?"https":"http")
+"://"+ url;
var s = document.getElementsByTagName("script")[0];
s.parentNode.insertBefore(hcc, s.nextSibling);
})();
</script>
                </div>
            </div>
        </div>
    </footer>

 
    <script src="{THEME_PATH}contain/js/bootstrap.min.js"></script>
    <script src="{THEME_PATH}contain/js/jquery.prettyPhoto.js"></script>
    <script src="{THEME_PATH}contain/js/jquery.isotope.min.js"></script>
    <script src="{THEME_PATH}contain/js/main.js"></script>
    <script src="{THEME_PATH}contain/js/wow.min.js"></script>

</body>
</html>