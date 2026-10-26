<?
if(isset($plugin_config['name'])){
?>
<h2><?php echo $plugin_config['name'];?></h2>
<?
}
?>
<?
if(isset($_GET['plugin_selected'])){
echo PluginsUserComponent::getToolbar($_GET['plugin_selected'],$site,array());
}
?>
 <?
$fields=$plugin_config['fields'];
if(isset($fields) and is_array($fields) and count($fields)>0){

if(isset($plugin_config['count'])){
$max_count=$plugin_config['count'];
}
$newdata=array('site'=>$site);

  



$path_create=ShoutPlugin::getRoute2()."widget/mysites_components/plugins/".$site['_id']->__toString()."?plugin_selected=".$_GET['plugin_selected']."&page=config&create=1";
 
if(isset($_GET['update']) and isset($value_row[$_GET['update']])){
$path_create=ShoutPlugin::getRoute2()."widget/mysites_components/plugins/".$site['_id']->__toString()."?plugin_selected=".$_GET['plugin_selected']."&page=config&create=1&update=".$_GET['update'];

}
if(isset($max_count) and $max_count==1 and isset($value_row[0])){
 $_GET['update']=1;
 $_GET['id']=0;
}
?>
<h2>Настройки</h2>
<form action="<?php echo $path_create;?>" method="POST" enctype="multipart/form-data">
    <table>
     <?
    
     foreach($fields as $key_new=>$row){
    $label=$key_new;
    $type="string";
    if(isset($row['type'])){
    $type=$row['type'];
    }
    if(isset($row['label'])){
    $label=$row['label'];
    }
    $cur_value="";
    if(isset($_GET['update']) and $_GET['update']==1 and isset($_GET['id']) and isset($value_row[$_GET['id']])){
    if(isset($value_row[$_GET['id']][$key_new])){
        $cur_value=$value_row[$_GET['id']][$key_new];
    }else {
        $cur_value="";
    }

    }
     ?>
        <tr>
        <td><?php echo $label;?></td>
        <td>
        <?
        if($type=="string"){
        ?>
        <input type="text" name="<?php echo $key_new;?>" required="required"  value="<?php echo $cur_value;?>">
        <?
        }else if($type=="select"){
        $available=$row['available'];
        if(isset($available) and is_array($available) and count($available)>0){
        ?>
        <select name="<?php echo $key_new;?>">
        <?
        foreach($available as $s){
         $selected="";
         if($s['value']==$cur_value){
         $selected="selected";
         }

        ?>
            <option <?php echo $selected;?> value="<?php echo $s['value'];?>"><?php echo $s['title'];?></option>
        <?
        }
        ?>
        </select>
        <?
        }
        ?>
        <?

        }else if($type=="image"){
        ?>
        <input type="file" name="<?php echo $key_new?>" value="">
        <?
        }else if($type=="textarea"){
         $template=Yii::app()->getController()->widget('ext.redactor.ImperaviRedactorWidget',array(
    'name'=>$key_new,
    'value'=>$cur_value,
    // Redactor options
    'options'=>array(),
),true);
         echo $template;
        }else if($type=="array"){
       if(isset($row['fields'])){
        $list_fields=$row['fields'];
        ?>
        <div class="field_temp_<?php echo $key_new?>" style="display:none;">
        <?
        foreach($list_fields as $f_key=>$f_value){
        $type_temp="string";
        $label_temp=$f_key;
        if(isset($f_value['label'])){
        $label_temp=$f_value['label'];
        }
        if(isset($f_value['type'])){
        $type_temp=$f_value['type'];
        }
        if($type_temp=="string"){
        ?>
            <p><?php echo $label_temp?>:<input type="text" name="<?php echo $key_new;?>_<?php echo $f_key?>[n]"></p>
        <?
        }else if($type_temp=="textarea"){
          $template_temp=Yii::app()->getController()->widget('ext.redactor.ImperaviRedactorWidget',array(
    'name'=>$key_new."_".$f_key."[n]",
    'value'=>"",
    // Redactor options
    'options'=>array(),
),true);
         echo $template_temp;
        }else if($type_temp=="image" or $type_temp=="file"){
          ?>
            <p><?php echo $label_temp?>:<input type="file" name="<?php echo $key_new;?>_<?php echo $f_key?>[n]"></p>
          <?
        }else if($type_temp=="select"){


         ?>
            <p><?php echo $label_temp;?>:<select name="<?php echo $key_new;?>_<?php echo $f_key?>[n]">
            <?
            if(isset($f_value['available']) and is_array($f_value['available']) and count($f_value['available'])>0) {
                foreach($f_value['available'] as $ss_key=>$ss_value){
                if(isset($ss_value['title']) and isset($ss_value['value'])){
                ?>
                    <option value="<?php echo $ss_value['title']?>"><?php echo $ss_value['value'];?></option>
                <?
                }
                }
                $temp_array['select'][$key_new."_".$f_key]=$f_value['available'];
            }
            ?>
                </select></p>
         <?
        }
        }
        if(is_array($cur_value)){
        $i_field=count($cur_value);
        }else {
        $i_field=0;
        }


        ?>
           </div><div class="field_insert_<?php echo $key_new?>">
           <?
if(isset($_GET['id'])){
            if(isset($field['value'][$_GET['id']][$key_new]) and is_array($field['value'][$_GET['id']][$key_new]) and count($field['value'][$_GET['id']][$key_new])>0){
          foreach($field['value'][$_GET['id']][$key_new] as $nn_key=>$nn_value){

          foreach($nn_value as $n_key=>$n_value){
         if($list_fields[$n_key]['type']=="string"){

            ?>
             <p><?php echo $list_fields[$n_key]['label']?>:<input type="text"    value="<?php echo $n_value;?>" name="<?php echo $key_new;?>_<?php echo $n_key?>_<?php echo $nn_key;?>"></p>
             <?
         }else if($list_fields[$n_key]['type']=="select"){

          $current_available=$temp_array['select'][$key_new."_".$f_key]  ;
         ?>
         <p><?php echo $list_fields[$n_key]['label'];?>:<select name="<?php echo $key_new;?>_<?php echo $f_key?>[n]">
            <?
            if(isset($current_available) and is_array($current_available) and count($current_available)>0) {
                foreach($current_available as $ss_key=>$ss_value){
                if(isset($ss_value['title']) and isset($ss_value['value'])){
                ?>
                    <option value="<?php echo $ss_value['title']?>"><?php echo $ss_value['value'];?></option>
                <?
                }
                }
            }
            ?>
                </select></p>
         <?
         }else if($list_fields[$n_key]['type']=="textarea") {
            $template_temp=Yii::app()->getController()->widget('ext.redactor.ImperaviRedactorWidget',array(
    'name'=>$key_new."_".$f_key."_".$nn_key,
    'value'=>$n_value,
    // Redactor options
    'options'=>array(),
),true);
         ?>
             <p><?php echo $list_fields[$n_key]['label']?>:<?php echo $template_temp;?></p>
         <?
         }else if($list_fields[$n_key]['type']=="image"){
        ?>
             <p><?php echo $list_fields[$n_key]['label']?>:<a href="<?php echo $n_value;?>"><img  width="100px" src="<?php echo $n_value;?>"></a></a><input type="file"  name="<?php echo $key_new;?>_<?php echo $f_key?>_<?php echo $nn_key;?>"></p>

         <?
         }else if($list_fields[$n_key]['type']=="file"){
         ?>
        <p><?php echo $list_fields[$n_key]['label']?>:<input type="file"  name="<?php echo $key_new;?>_<?php echo $f_key?>_<?php echo $nn_key;?>"></p>

         <?
         }
              //var_dump(; echo $n_value;
          }
          }
       }}

           ?>
           </div>
           <a id="add_<?php echo $key_new;?>" href="#">Добавить</a>
           <script>
             function replaceAll(find, replace, str)
    {
      while( str.indexOf(find) > -1)
      {
        str = str.replace(find, replace);
      }
      return str;
    }
           var i_<?php echo $key_new;?>=<?php echo $i_field;?>;
            $("#add_<?php echo $key_new?>").on("click",function(){
               var html="";
               html=$(".field_temp_<?php echo $key_new?>").html();
               var newinput=replaceAll("[n]","_"+i_<?php echo $key_new;?>+"",html);

               var newstring = "<div class='field_<?php echo $key_new?>'_"+i_<?php echo $key_new?>+">"+newinput+"</div>";
               $(".field_insert_<?php echo $key_new?>").append(newstring);
               i_<?php echo $key_new;?>++;
                return false;
            });
           </script>
        <?
       }
        }
        ?>
        </td>
    </tr>
     <?
     }
     ?>
    <tr>
        <td></td>
        <td><input type="submit" name="act_save_d" value="Сохранить"></td>
    </tr>
    </table>
</form>
<?
//$label_main=$key;
//if(isset($field['label'])){
//$label_main=$field['label'];
//}
?>

<table>
    <thead>
    <tr>
    <?
    foreach($fields as $key_new=>$row){
    $label=$key_new;
    if(isset($row['label'])){
    $label=$row['label'];
    }
    ?>
    <th><?php echo $label;?></th>
    <?
    }
    ?>

    </tr>
    </thead>
    <tbody>
    <?
    if(isset($value_row) and is_array($value_row) and count($value_row)>0){
     $number_i=0;
     foreach($value_row as $r){
     ?>
        <tr>
     <?
      foreach($fields as $key_new=>$row){
     $row_cur="";
     $type=$row['type'];
    

     if(isset($r[$key_new])){
      $row_cur=$r[$key_new];
     }
     if($type=="image" and strlen($row_cur)){
     $row_cur="<img src='".$row_cur."' width='100px'/>";
     }else if($type=="array"){
     $row_cur=count($r[$key_new]);
     }
    ?>
    <td><?php echo $row_cur;?></td>
    <?
    }
     ?>
    <td><a href="<?php echo   ShoutPlugin::getRoute2()?>widget/mysites_components/plugins/<?php echo $site['_id']->__toString();?>?plugin_selected=<?php echo $key?>&page=config&update=<?php echo $number_i?>&id=<?php echo $number_i?>">Обновить</a></td>
    <td><a href="<?php echo   ShoutPlugin::getRoute2()?>widget/mysites_components/plugins/<?php echo $site['_id']->__toString();?>?plugin_selected=<?php echo $key?>&page=config&delete=<?php echo $number_i?>&id=<?php echo $number_i?>">Удалить</a></td>
        </tr>
     <?
     $number_i++;
     }
    }
    ?>
    </tbody>
</table>
<?
}
?>


