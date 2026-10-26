  <form method="POST" id="formx_<?php echo $mg->name_short;?>" action="<?php echo $mg->setRoute("/create/2");?>" enctype="multipart/form-data" >
      <table >
     <?

     if(isset($mg->fields->array_fields)){
     foreach($mg->fields->array_fields as $field){
     $type="hidden";
     if(isset($mg->fields->array_type[$field]['type'])){
     $type=$mg->fields->array_type[$field]['type'];
     }

     $title=$mg->fields->array_type[$field]['label'];
     if($type!="hidden"){
    ?>
    <tr>
    <td><?php echo $title;?></td>
    <td><?php echo $mg->fields->render[$field]?> </td>
    </tr>
    <?
     }
     }
     }
     ?>
    <tr>
        <td><input type="hidden" name="act_create" value="123213213"><input type="hidden" name="act_create_<?php echo $mg->name_short;?>" value="testtesttest"/></td>
     <td><input id="ajaxaddbutton" type="submit" name="act_create_<?php echo $mg->name_short;?>_2" value="Создать"></td>
    </tr>
    </table>
  </form>
<?
if(!isset($disable)){
?>
<script>
var url_send="<?php echo $mg->url;?>?<?php echo $mg->setRoute("/create/2");?>&ajax=1";
var url_get="<?php echo $mg->url;?>?<?php echo $mg->setRoute("/list/1");?>&ajax=1";

$("document").ready(function(){
 $("#ajaxaddbutton").on("click",function(){
    var msg   = $('#formx_<?php echo $mg->name_short;?>').serialize();
  
    $.ajax({
          type: 'POST',
          url: url_send,
          data: msg,
          success: function(data) {
     try
{
   var json = JSON.parse(data);
   alert(json.message);
}
catch(e)
{
   $.get(url_get, function( data ) {
      $('.<?php echo $classname;?>').html(data);
      });
}
     
           // $('.<?php echo $classname;?>').html(data);
          },
          error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
   return false;
 });
});
</script>
<?
}
?>