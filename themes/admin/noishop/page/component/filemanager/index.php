
<h4 class="page-title"><?php echo NoiCore::app()->lang("main_filemanager");?></h4>

                <div id="fileManager"></div>
              
                 <script type="text/javascript">
            $(document).ready(function() {
                 $('#fileManager').elfinder({
                      resizable: false,
                      url : '<?php echo NoiCore::app()->getRoute('filemanager/setup')?>',  // connector URL (REQUIRED)
                      lang:'<?php echo NoiCore::app()->lang("filemanager_lang");?>',
                      uiOptions : {
                      toolbar : [
                              ['back', 'forward', 'home', 'reload'],
                              ['mkdir', 'mkfile', 'upload'],
                              ['view', 'sort','resize'],
                              ['search']
                      ]},
                      height: 500
                 });

                 $('.elfinder-cwd-wrapper, .elfinder-navbar').niceScroll();
            });
        </script>