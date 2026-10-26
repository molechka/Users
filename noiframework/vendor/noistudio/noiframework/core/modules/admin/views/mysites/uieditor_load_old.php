<div class='loader_ui'>
    <div class="editable_content" style="width:100%; border: 4px double red;" height="700px">
        <ajax><?php echo $new_page_content;?></ajax>
    </div>
<link href="/js/froala/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="/js/froala/css/froala_editor.min.css" rel="stylesheet" type="text/css">
 <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="/js/froala/js/froala_editor.min.js"></script>
  <a href='#'   id='save_tpl_file' >Save Web-page</a>
  <script>
 
  var current_call_object="any";
  var current_object_edit="div.editable_content";
  var site_id="<?php echo $site['_id']->__toString()?>";
 var page_id="<?php echo $page_id;?>";
 
  

  function my_page_save(){
   $("#save_tpl_file").click();
  }
  function reinit_editor(){
     $(function(){

         });
  }
  $( current_object_edit ).on( "savepage", function( event  ) {

  });
  $( current_object_edit ).on( "reinit", function( event  ) {


  $(current_object_edit).editable({autosave:false,inlineMode: true, // Set the image upload parameter.
            imageUploadParam: 'assocreat_img',
             // Set the image upload URL.
            imageUploadURL: '<?php echo ShoutPlugin::getRoute2();?>widget/mysites_components/settings/<?php echo $site['_id']->__toString()?>?newsetting=image&path_grid_content_imageasdasdasdasd=/create/1&editor_load=1',

            // CORS. Only if needed.
            crossDomain: false,
            saveURL:'<?php echo ShoutPlugin::getRoute2()?>widget/mysites_components/uieditor/<?php echo $site['_id']->__toString();?>?iframe_act=save_page&page='+page_id+'&element='+current_object_edit,
            // Set the image error callback.
            imageErrorCallback: function (data) {
                // Bad link.
                if (data.errorCode == 1) {

                }

                // No link in upload response.
                else if (data.errorCode == 2) {

                }

                // Error during file upload.
                else if (data.errorCode == 3) {

                }
            }});
      return true;
});


 $("#save_tpl_file").on("click",function(){

//$(current_object_edit).editable("destroy");
//$(current_object_edit).editable("sync");
//$(current_object_edit).editable("save");
$(current_object_edit).editable("save");
//var html_current=$(current_object_edit).editable("getHTML");;


// $.post( "<?php echo ShoutPlugin::getRoute2();?>widget/mysites_components/uieditor/<?php echo $site['_id']->__toString()?>?iframe_act=save_page", { element:current_object_edit, page: page_id,content:html_current })
//  .done(function( data ) {
// //alert("Success full save");
//      alert(data);
//     $( current_object_edit).trigger( "reinit" );
//  // window.location.reload();
//
//  });

 });

          //

      $(function() {

 $( current_object_edit).trigger( "reinit" );

        $('.selector').editable({
            // Set the image upload parameter.
            imageUploadParam: 'assocreat_img',inlineMode: true,

            // Set the image upload URL.
            imageUploadURL: '<?php echo ShoutPlugin::getRoute2();?>widget/mysites_components/settings/<?php echo $site['_id']->__toString()?>?newsetting=image',

            // CORS. Only if needed.
            crossDomain: false,

            // Set the image error callback.
            imageErrorCallback: function (data) {
                // Bad link.
                if (data.errorCode == 1) {

                }

                // No link in upload response.
                else if (data.errorCode == 2) {

                }

                // Error during file upload.
                else if (data.errorCode == 3) {

                }
            }
        })
    });


  </script>
</div>