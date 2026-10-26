<?
$newdata=array('site'=>$site);
echo SiteComponent::render_setup("editsite_bar",$newdata);
?>
<p><a href='<?php echo   ShoutPlugin::getRoute2()?>widget/mysites_components/uieditor/<?php echo $site['_id']->__toString();?>?operation=manage'>Return to Manage Page</a></p>
<form action='' class="bg-gray-alt" method='POST'> 
    <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Layout:
                    </label>
                </div>
                <div class="form-input col-md-10">

                    <select data-placeholder="Select Page" name='pageview'class="chosen-select">

    <?
    if(isset($all_files) and is_array($all_files) and count($all_files)){
     foreach($all_files as $file){
     $selected="";
     if($file==$current_page){
     $selected="selected";
     }
     ?>
        <option  <?php echo $selected;?> value='<?php echo $file?>'><?php echo $file;?></option>
     <?
     }
    }
    ?>
                    </select></div></div> <input type='submit' class="btn medium primary-bg" name='act_execute' value='Show page'>
</form>
 
<?
if(isset($current_page)){
?>
<iframe name='editorarea' id='editor_area' width='100%' height='700px' src='?path_page_iframe=<?php echo $current_page;?>'></iframe>
<?
}
yii::app()->params['header_menu_li']="<li><a style='color:red !important;' id='save_page_link' href='#'>Save page</a></li>"
?>
<script>
$("#save_page_link").on("click",function(){
//$('#editor_area').contents().find('a#save_tpl_file').click();
//$('#editor_area').contents().find('body').trigger('savepage');
document.editorarea.my_page_save();
 
return false;
});
</script>
