<?
if(Yii::app()->params['plexor']=="1"){
?>
<script>
 realplexor.subscribe("<?php echo $channel;?>", function(data, id) {
 
    template=data.<?php echo $field;?>;
    template=template+''+$('<?php echo $insert;?>').html();
       $('<?php echo $insert;?>').html(template);


});
realplexor.execute();
</script>
<?
}
?>
