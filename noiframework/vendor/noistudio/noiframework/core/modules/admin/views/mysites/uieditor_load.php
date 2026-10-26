 <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
 <script src="/js/ckeditor_new/ckeditor.js"></script>
<script src="/js/ckeditor_new/adapters/jquery.js"></script>
<div class='loader_ui'>
    <p> <textarea cols="80" id="editor1" name="editor1" rows="10"> <?php echo $new_page_content;?></textarea>

		</p>


 <link href="/js/ckeditor_new/samples/sample.css" rel="stylesheet">


  <a href='#'   id='save_tpl_file' >Save Web-page</a>
  <script>
  var current_call_object="any";
  var current_object_edit="div.editable_content";
  var site_id="<?php echo $site['_id']->__toString()?>";
 var page_id="<?php echo $page_id;?>";
$( '#editor1' ).ckeditor({
  
   filebrowserBrowseUrl: '<?php echo ShoutPlugin::getRoute2();?>widget/mysites_components/settings/<?php echo $site['_id']->__toString()?>?newsetting=elfinder_show',
});

$('#editor1').ckeditor().editor.config.allowedContent = true;;
$("#editor1").ckeditor().editor.config.templates_files = [ '<?php echo ShoutPlugin::getRoute2();?>widget/mysites_components/uieditor/<?php echo $site['_id']->__toString()?>?templatejs='+page_id ];
 
 



  function my_page_save(){
   $("#save_tpl_file").click();
  }
  function reinit_editor(){
     $(function(){

         });
  }
   


 $("#save_tpl_file").on("click",function(){

 var html_current=$("#editor1").val();
 
html_current="<ajax>"+html_current+"</ajax>";
 $.post( "<?php echo ShoutPlugin::getRoute2();?>widget/mysites_components/uieditor/<?php echo $site['_id']->__toString()?>?iframe_act=save_page", { element:current_object_edit, page: page_id,content:html_current })
  .done(function( data ) {
 alert("Success full save");

  // window.location.reload();

  });

 });




  </script>
</div>