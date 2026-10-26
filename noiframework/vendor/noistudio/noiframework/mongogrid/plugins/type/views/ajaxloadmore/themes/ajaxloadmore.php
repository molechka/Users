<a  class="load_more" data-limit="<?php echo $limit;?>" data-offset="0" href="">Загрузить больше</a>
<?
$params_serialize=array('class_div_insert'=>$class_div_insert,'offset'=>$offset,'limit'=>$limit,'count'=>$count,'endtag'=>$endtag);
$serialize=  serialize($params_serialize);
?>
<script>
$(document).ready(function(){
  var name_div_insert=".<?php echo $class_div_insert;?>";
  var offset=<?php echo $offset;?>;
  var limit=<?php echo $limit?>;
  var ident_page=2;
  $(".load_more").on("click",function(){
  $.get( '<?php echo $mg->url;?>?plugin=ajaxloadmore&ajax=1&page='+ident_page+'&params=<?php echo $serialize?>', function( data ) {
  if(data.length<10){
  $(".load_more").hide();
  }else {
  $( name_div_insert ).append( data );
  }
  ident_page++;

});
return false;
  });
});
</script>


