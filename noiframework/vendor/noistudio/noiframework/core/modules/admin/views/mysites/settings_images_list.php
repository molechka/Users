<link rel="stylesheet" type="text/css" media="screen" href="/js/elfinder/css/elfinder.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" media="screen" href="/js/elfinder/css/theme.css">
 
		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="/js/elfinder/js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="/js/elfinder/js/i18n/elfinder.ru.js"></script>
<?
if(isset($site['_id'])){
?>
                	<div id="elfinder"></div>
 
                <script type="text/javascript" charset="utf-8">
    // Helper function to get parameters from the query string.
    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
        var match = window.location.search.match(reParam) ;

        return (match && match.length > 1) ? match[1] : '' ;
    }

    $().ready(function() {
        var funcNum = getUrlParam('CKEditorFuncNum');

        var elf = $('#elfinder').elfinder({
            url : '<?php echo ShoutPlugin::getRoute2();?>widget/mysites_components/settings/<?php echo $site['_id']->__toString();?>?newsetting=elfinder',
            getFileCallback : function(file) {
                window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                window.close();
            },
            resizable: false
        }).elfinder('instance');
    });
</script>
<?
}
?>
