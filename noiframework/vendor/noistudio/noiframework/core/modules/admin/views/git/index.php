<h2>Git Push</h2>
<form action='<?=NoiCore::app()->getRoute('git/push');?>' method='POST' class='gitfast'>
<table class='table'>
    <tr>
        <td>Репозитарий</td>
        <td><input type='text' name='repo' value='' class='form-control' required=''></td>
    </tr>   
    <tr>
        <td></td>
        <td><input type='submit' class='btn btn-danger' value='Git Push'></td>
    </tr>
</table>
</form>
<script>
 $(".gitfast").on("submit",function(){
  $.get( "<?=NoiCore::app()->getRoute('db/export?download=1')?>", function( data ) {
 return true;
});
 });   
</script>