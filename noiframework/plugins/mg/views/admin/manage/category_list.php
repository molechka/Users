<h3><?php echo $mg->title;?> <a href="<?=NoiCore::app()->getRoute('p_mg/fields/index/'.$collection['_id']->__toString());?>" class="btn btn-danger">поля</a>&nbsp;&nbsp;<a href="<?=NoiCore::app()->getRoute('p_mg/collections/index/null?path_grid_asd=/update/'.$collection['_id']->__toString());?>" class="btn btn-danger">настройка</a></h3>
 <?
if(NoiCore::lang()->is()){
?>
<p><a href="<?php echo $url_to_lang;?>">Default</a></p>
<?
foreach($languages as $lang){
?>

<p><a href="<?php echo $url_to_lang;?><?php echo $lang;?>">Language (<?php echo $lang;?>)</a></p>
<?
}
}
?>
<table class="table">
 <tr><td>
 <?

 if(in_array("create",$mg->operations->available)){
 ?>
<a href="<?php echo $mg->setRoute('/create/1');?>">Добавить документ</a>
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
         </select><input type="text" value="<?if(isset($_POST['search_value'])) echo $_POST['search_value'];?>"name="search_value"><input type="submit" name="search_btn" value="<?php echo NoiCore::app()->lang('content_search');?>">
         </form></td>
 </tr>
</table>
<table class="table">
    <thead>
    <tr>
      
    <?
    if($mg->fields->showid==true){
    ?>
        <th>_id</th>
    <?
    }
    ?>
    <?
    
    if(isset($sort['order_last_id'])){
    ?>
        <th>Позиция</th>    
    <?    
    }
    ?>
        <?
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
        
    <?
    if($mg->fields->showid==true){
    ?>
        <td><a href=""><?php echo $row['_id']->__toString();?></a></td>
    <?
    }
    ?>
     <?
    if(isset($mg->sort['order_last_id'])){
    ?>
        <td>
            <a href="<?=NoiCore::app()->getRoute('p_mg/arrows/index/'.$row['last_id']."/".$collection['name']."/up");?>"><i class="fa fa-arrow-up"></i></a>    
        <?=$row['order_last_id'];?>
            <a href="<?=NoiCore::app()->getRoute('p_mg/arrows/index/'.$row['last_id']."/".$collection['name']."/down");?>"><i class="fa fa-arrow-down"></i></a>
        </td>   
    <?    
    }
    ?>
    <?    
            
    foreach($mg->fields->array_fields as $field){
         
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
    <td><?php echo  GridImage::showImage($blob,100,100,$row['_id']->__toString(),$field,$url_image)?></td>
    <?

    }else  if(isset($row[$field])){
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
    <td><a href="<?php echo $mg->setRoute('/update/'.$row['_id']->__toString());?>"><?php echo NoiCore::app()->lang('content_edit');?></a></td>
    <?
    }
    ?>
     <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <td><a class="delete" href="<?php echo $mg->setRoute('/delete/'.$row['_id']->__toString());?>"><?php echo NoiCore::app()->lang('content_delete');?></a></td>

    <?
    }
    ?>
      <?
       
    if(in_array("clone",$mg->operations->available) and !in_array("clone",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <td><a  href="<?php echo $mg->setRoute('/clone/'.$row['_id']->__toString());?>"><?php echo NoiCore::app()->lang('mongogrid_clone');?></a></td>

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