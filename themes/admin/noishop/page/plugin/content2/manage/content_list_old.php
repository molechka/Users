<h3><?php echo $mg->title;?></h3>

<table class="table">
 <tr><td>
 <?

 if(in_array("create",$mg->operations->available)){
 ?>
<a href="<?php echo $mg->setRoute('/create/1');?>">Создать</a>
<?
 }
 ?></td>

     <td><form action='<?php echo   $mg->setRoute('/list/1');?>' method="POST">
         <select name="search_field">
         <?
         if(isset($mg->fields->array_fields)){
         foreach($mg->fields->array_fields as $search_field){
         $title=$search_field;
         $selected="";
         if(!isset($mg->fields->not_show[$search_field]["list"])){
         if(isset($_POST['search_field']) and $_POST['search_field']==$search_field){
         $selected="selected='selected'";
         }

         if(isset($mg->fields->array_type[$search_field]['label'])){
         $title=$mg->fields->array_type[$search_field]['label'];
         }
         ?>
             <option <?php echo $selected;?> value="<?php echo $search_field?>"><?php echo $title?></option>
         <?
         }
         }
         }
         ?>
         </select><input type="text" value="<?if(isset($_POST['search_value'])) echo $_POST['search_value'];?>"name="search_value"><input type="submit" name="search_btn" value="Фильтр">
         </form></td>
 </tr>
</table>
<table class="table">
    <thead>
    <tr>
        <td></td>
    <?
    if($mg->fields->showid==true){
    ?>
        <th>_id</th>
    <?
    }
    foreach($mg->fields->array_fields as $field){
    if(isset($mg->fields->not_show[$field]["list"])){

    }else {
    $title=$mg->fields->array_type[$field]['label'];

    ?>
    <th><?php echo $title;?></th>
    <?
    }
    }
    ?>
    <?
    if(in_array("update",$mg->operations->available)  and !in_array("update",$mg->operations->denied_access)){
    ?>
    <th>Кнопка</th>
    <?
    }
    ?>
     <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)){
    ?>
    <th>Кнопка</th>
    <?
    }
    ?>
    </tr>
    </thead>
    <tbody class="ajax_load_row">
    <?


    if(isset($mg->result) and isset($mg->result[0]['_id'])){
     foreach($mg->result as $row){
     ?>
    <tr>
        <td><?
      
        if(isset($row['title_translit']) and isset($option['controller'])){
        ?>
            <a href="<?php echo $option['controller']->getPreviewUrl("page/".$row['title_translit']);;?>">Посмотреть</a>
        <?
        }

        ?></td>
    <?
    if($mg->fields->showid==true){
    ?>
        <td><a href=""><?php echo $row['_id']->__toString();?></a></td>
    <?
    }
    foreach($mg->fields->array_fields as $field){
        if(isset($mg->fields->not_show[$field]["list"])){

        }else {



  if(isset($row[$field])){
    if(is_array($row[$field])){
    $row[$field]=count($row[$field]);
    }
    ?>
    <td><?php echo $row[$field];?></td>
    <?
    }
    }
    }
    ?>
     <?
    if(in_array("update",$mg->operations->available) and !in_array("update",$mg->operations->denied_access) and isset($row['_id'])){
    ?>
    <td><a href="<?php echo $mg->setRoute('/update/'.$row['_id']->__toString());?>">Редактировать</a></td>
    <?
    }
    ?>
     <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <td><a href="<?php echo $mg->setRoute('/delete/'.$row['_id']->__toString());?>">Удалить</a></td>

    <?
    }
    ?>
    </tr>
     <?
     }
    }

    ?>
    </tbody>
</table>
<?
if(!isset($js)){
$js=0;
}
if($js=="1"){
?>
<script>
 function getUrlParam( paramName ) {
    var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' ) ;
    var match = window.location.search.match(reParam) ;

    return ( match && match.length > 1 ) ? match[ 1 ] : null ;
}
function OpenFile( fileUrl )
{

	//PATCH: Using CKEditors API we set the file in preview window.

	funcNum = getUrlParam('CKEditorFuncNum') ;
	//fixed the issue: images are not displayed in preview window when filename contain spaces due encodeURI encoding already encoded fileUrl
	window.top.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl);

	///////////////////////////////////
	window.top.close() ;
	window.top.opener.focus() ;
}
$(document).ready(function(){
 $("a img").on("click",function(){
 var href=$(this).attr("src");

var funcNum = getUrlParam( 'CKEditorFuncNum' );

 OpenFile(href);


 })
})
</script>
<?
}
$count=0;
if(isset($mg->result[0]['_count_'])){
$count=$mg->result[0]['_count_'];
}
?>
<mgplugin count="<?php echo $count;?>" limit="<?php echo $mg->page_item;?>">paginator</mgplugin>