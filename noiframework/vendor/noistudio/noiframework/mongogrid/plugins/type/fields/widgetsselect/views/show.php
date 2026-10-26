<?
use NoiCore;

   $added="";
  if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }  
?>
<input <?=$added;?> type="text" id="widgetsselect_<?php echo $plugin->getNameField()?>" name="<?php echo $plugin->getNameField()?>" value="<?php echo $value?>">
<div id="additional_<?php echo $plugin->getNameField()?>_content" style="display:none;">
    <select id="ajax_select_plugin_<?php echo $plugin->getNameField();?>">
        <option value="#">#</option>
    <?
    if(isset($site['theme_components']['plugins']['available']) and is_array($site['theme_components']['plugins']['available']) and count($site['theme_components']['plugins']['available'])>0){
     foreach($site['theme_components']['plugins']['available'] as $val){
     ?>
        <option value="<?php echo $val;?>"><?php echo $val;?></option>
     <?
     }
    }
    ?>
    </select>
    Выбор Widget <select id="step2_<?php echo $plugin->getNameField()?>">
        <option value="null">null</option>
    </select>

</div>
<a href="#" id="click_action_<?php echo $plugin->getNameField()?>">Выбрать Widget</a>

<script>
 
var $=jQuery;
$(document).ready(function(){
 $("#click_action_<?php echo $plugin->getNameField()?>").on("click",function(){
  $("#additional_<?php echo $plugin->getNameField()?>_content").show();
  return false;
 });
 $("#step2_<?php echo $plugin->getNameField()?>").on("change",function(){
  var cur_val=$(this).val();
  var plugin=$(this).attr("data-plugin");
  $("#widgetsselect_<?php echo $plugin->getNameField()?>").val(plugin+"::"+cur_val);
  return false;
 });
 
 $("#ajax_select_plugin_<?php echo $plugin->getNameField();?>").on("change",function(){
  var cur_val=$("#ajax_select_plugin_<?php echo $plugin->getNameField();?>").val();
  if(cur_val!="null"){
  var url_current='<?php echo NoiCore::app()->getRoute('wi/get/');?>'+cur_val;
$.get( url_current, function( data ) {
  $( "#step2_<?php echo $plugin->getNameField();?>" ).html('<option></option>'+ data );
  $("#step2_<?php echo $plugin->getNameField();?>").attr("data-plugin",cur_val);
   return false;
});
  }

 });
})
</script>

