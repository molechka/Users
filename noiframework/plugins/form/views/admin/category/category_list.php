<h3><?=$mg->title;?></h3>
<?
if(NoiCore::lang()->is()){
?>
<p><a href="<?=$url_to_lang;?>">Default</a></p>
<?
foreach($languages as $lang){
?>

<p><a href="<?=$url_to_lang;?><?=$lang;?>">Language (<?=$lang;?>)</a></p>
<?
}
}
?>
<table class="table">
 <tr><td>
 <?

 if(in_array("create",$mg->operations->available)){
 ?>
<a href="<?=$mg->setRoute('/create/1');?>"><?=NoiCore::app()->lang('contentc_add');?></a>
<?
 }
 ?></td>

     <td><form action='<?=  $mg->setRoute('/list/1');?>' method="POST">
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
             <option <?=$selected;?> value="<?=$search_field?>"><?=$title?></option>
         <?
         }
         }
         }
         ?>
         </select><input type="text" value="<?if(isset($_POST['search_value'])) echo $_POST['search_value'];?>"name="search_value"><input type="submit" name="search_btn" value="<?=NoiCore::app()->lang('content_search');?>">
         </form></td>
 </tr>
</table>
<table class="table">
    <thead>
    <tr>
        <th></th>
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
    <th><?=$title;?></th>
    <?
    }
    }
    ?>
    <?
    if(in_array("update",$mg->operations->available)  and !in_array("update",$mg->operations->denied_access)){
    ?>
    <th></th>
    <?
    }
    ?>
     <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)){
    ?>
    <th></th>
    <?
    }
    ?>
     <?
    if(in_array("clone",$mg->operations->available) and !in_array("clone",$mg->operations->denied_access)){
    ?>
    <th></th>
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
        <td>
                  <?
           if($row['visible']==0){
           ?>
            <a href="<?=  NoiCore::app()->getRoute('p_gallery/category/change/1?id='.$row['_id']->__toString())?>"><i class="fa fa-eye-slash"></i></a>
           <?
            }else if($row['visible']==1){
            ?>
            <a href="<?=  NoiCore::app()->getRoute('p_gallery/category/change/0?id='.$row['_id']->__toString())?>"><i class="fa  fa-eye"></i></a>
            <a target="_blank" href="<?=NoiCore::admin()->getPreview("/gallery/c/".$row['_id']->__toString().".html");?>"><?=NoiCore::app()->lang('content_look');?></a>
            <?
            }
           ?>


        <?
        

        ?></td>
    <?
    if($mg->fields->showid==true){
    ?>
        <td><a href=""><?=$row['_id']->__toString();?></a></td>
    <?
    }
    foreach($mg->fields->array_fields as $field){
         $tmp_check=str_replace("title","",$field);
       if($tmp_check!=$field){
        $field="title";   
       }
        if(isset($mg->fields->not_show[$field]["list"])){

        }else {




    if(isset($mg->fields->array_type[$field]['type']) and $mg->fields->array_type[$field]['type']=="image"){
   //  $bin= new MongoBinData($row[$field]);
     //echo $row[$field]->bin;
    // $imagick=new Imagick();
   //  $imagick->readimageblob($row[$field]->bin);
    // $imagick->displayimage($row['_id']->__toString());


        if(!isset($row[$field]->bin)){
        $blob=$row[$field];
        }else {
        $blob=$row[$field]->bin;
        }
$js=0;
if(isset($_GET['CKEditorFuncNum']) and isset($_GET['CKEditor']) and isset($_GET['langCode'])){
$funcNum = $_GET['CKEditorFuncNum'] ;
$js=1;
// Optional: instance name (might be used to load a specific configuration file or anything else).
$CKEditor = $_GET['CKEditor'] ;
// Optional: might be used to provide localized messages.
$langCode = $_GET['langCode'] ;
$url_image=$blob;
}else {
$url_image=$blob;
}
    ?>
    <td><?= GridImage::showImage($blob,100,100,$row['_id']->__toString(),$field,$url_image)?></td>
    <?

    }else  if(isset($row[$field])){
    if(is_array($row[$field])){
    $row[$field]=count($row[$field]);
    }
    ?>
    <td><?=$row[$field];?></td>
    <?
    }
    }
    }
    ?>
     <?
    if(in_array("update",$mg->operations->available) and !in_array("update",$mg->operations->denied_access) and isset($row['_id'])){
    ?>
    <td><a href="<?=$mg->setRoute('/update/'.$row['_id']->__toString());?>"><?=NoiCore::app()->lang('content_edit');?></a></td>
    <?
    }
    ?>
     <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <td><a class="delete" href="<?=$mg->setRoute('/delete/'.$row['_id']->__toString());?>"><?=NoiCore::app()->lang('content_delete');?></a></td>

    <?
    }
    ?>
     <?
    if(in_array("clone",$mg->operations->available) and !in_array("clone",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <td><a  href="<?=$mg->setRoute('/clone/'.$row['_id']->__toString());?>"><?=NoiCore::app()->lang('mongogrid_clone');?></a></td>

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
<mgplugin count="<?=$count;?>" limit="<?=$mg->page_item;?>">paginator</mgplugin>