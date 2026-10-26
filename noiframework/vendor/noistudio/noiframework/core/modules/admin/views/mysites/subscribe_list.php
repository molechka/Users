<h3><?php echo $mg->title;?></h3>

<table class="table">
 <tr><td>
 <?

 if(in_array("create",$mg->operations->available)){
 ?>
<a href="<?php echo $mg->setRoute('/create/1');?>"><?php echo Lang::t('standart_create_button');?></a>
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
         </select><input type="text" value="<?if(isset($_POST['search_value'])) echo $_POST['search_value'];?>"name="search_value"><input type="submit" name="search_btn" value="<?php echo Lang::t("standart_search_button");?>">
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
    <th><?php echo Lang::t("standart_simple_button");?></th>
    <?
    }
    ?>
     <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)){
    ?>
    <th><?php echo Lang::t("standart_simple_button");?></th>
    <?
    }
    ?>
     <?
    if(in_array("send",$mg->operations->available) and !in_array("send",$mg->operations->denied_access)){
    ?>
    <th><?php echo Lang::t("standart_simple_button");?></th>
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
    <td><?php echo $row['_id']->__toString();?></td>
    <?
    }
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
    ?>
    <td><?php echo  GridImage::showImage($blob,100,100,$row['_id']->__toString(),$field,$mg->url)?></td>
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
    <td><a href="<?php echo $mg->setRoute('/update/'.$row['_id']->__toString());?>"><?php echo Lang::t("standart_update_button");?></a></td>
    <?
    }
    ?>
     <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <td><a href="<?php echo $mg->setRoute('/delete/'.$row['_id']->__toString());?>"><?php echo Lang::t("standart_delete_button");?></a></td>

    <?
    }
    ?>
     <?
    if(in_array("send",$mg->operations->available) and !in_array("send",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <td><a href="<?php echo $mg->setRoute('/send/'.$row['_id']->__toString());?>"><?php echo Lang::t("subscribe_form_send_button");?></a></td>

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
<mgplugin count="<?php echo $mg->result[0]['_count_'];?>" limit="<?php echo $mg->page_item;?>">paginator</mgplugin>