<h2><?=$collection['name']; ?></h2>
<form  method="POST" action="<?=NoiCore::app()->getRoute('p_mg/fields/update2/'.$collection['_id']->__toString()."/".$field['name'])?>">
    <table class="table">
        <tr>
            <td>Title</td>
            <td><input type="text" name="field_title" class="form-control input-sm" value="<?=$field['title'];?>"></td>
        </tr>
        <?
        $username=  new noicms\mongogrid\OneField();
        $username->init("name","username");
        
        
        ?>
        <tr>
            <td>
              Name  
            </td>
            <td><?=$username->getInput($field['name']);?></td>
        </tr>
        <?
        $type=new noicms\mongogrid\OneField();
        $type->init("type","type");
        ?>
        <tr>
            <td>Type</td>
            <td><?=$type->getInput($field['type']);?></td>
        </tr>
        <tr>
            <td>Multilang</td>
            <td><input type="checkbox" name="multilang" value="1" <?  if(isset($field['multilang']) and $field['multilang']==1){ echo 'checked';} ?>></td>
        </tr>
        <tr>
            <td>Required</td>
            <td><input type="checkbox" name="required" <?  if($field['required'] and $field['required']==1){ echo 'checked';} ?> value="1"></td>
        </tr>
         <tr>
            <td>Unique</td>
            <td><input type="checkbox" name="unique" <?  if($field['unique'] and $field['unique']==1){ echo 'checked';}?></td>
        </tr>
        <tr>
            <td>Default value</td>
            <td><input type="text" name="field_value" class="form-control input-sm" value="<?=$field['default'];?>"></td>
        </tr>
        <tr>
            <td>Show in list</td>
            <td><input type="checkbox" name="showinlist" value="1" <?  if($field['showinlist'] and $field['showinlist']==1){ echo 'checked';}?>></td>
        </tr>
        <tr>
            <td>Options(JSON)</td>
            <td><textarea  class="form-control" name="json"><?=$field['json'];?></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="btn btn-submit" value="Edit Field"></td>
        </tr>
    </table>
</form>

