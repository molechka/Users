<h2><?=$collection['name']; ?> <a href="<?=NoiCore::app()->getRoute('p_mg/manage/index/'.$collection['_id']->__toString());?>" class="btn btn-danger">документы</a>&nbsp;&nbsp;<a href="<?=NoiCore::app()->getRoute('p_mg/collections/index/null?path_grid_asd=/update/'.$collection['_id']->__toString());?>" class="btn btn-danger">настройка</a></h2>
<form  method="POST" action="<?=NoiCore::app()->getRoute('p_mg/fields/add/'.$collection['_id']->__toString())?>">
    <table class="table">
        <tr>
            <td>Title</td>
            <td><input type="text" name="field_title" class="form-control input-sm"></td>
        </tr>
        <?
        $username=  new noicms\mongogrid\OneField();
        $username->init("name","username");
        ?>
        <tr>
            <td>
              Name  
            </td>
            <td><?=$username->getInput();?></td>
        </tr>
        <?
        $type=new noicms\mongogrid\OneField();
        $type->init("type","type");
        ?>
        <tr>
            <td>Type</td>
            <td><?=$type->getInput();?></td>
        </tr>
           <tr>
            <td>Multilang</td>
            <td><input type="checkbox" name="multilang" value="1"></td>
        </tr>
        <tr>
            <td>Required</td>
            <td><input type="checkbox" name="required" value="1"></td>
        </tr>
         <tr>
            <td>Unique</td>
            <td><input type="checkbox" name="unique"></td>
        </tr>
        <tr>
            <td>Default value</td>
            <td><input type="text" name="field_value" class="form-control input-sm"></td>
        </tr>
        <tr>
            <td>Show in list</td>
            <td><input type="checkbox" name="showinlist" value="1"></td>
        </tr>
        <tr>
            <td>Options(JSON)</td>
            <td><textarea  class="form-control" name="json"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="btn btn-submit" value="Add Field"></td>
        </tr>
    </table>
</form>
<h4>Список полей</h4>
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Name</th>
            <th></th>
            <th></th>
        </tr>   
    </thead>
    <tbody>
    <?
    if(isset($collection['fields']) and is_array($collection['fields']) and count($collection['fields'])>0){
    foreach($collection['fields'] as $key=>$field){
    ?>
        <tr>
            <td><?=$field['title'];?></td>   
            <td><?=$key;?></td>
            <td><a href="<?=NoiCore::app()->getRoute('p_mg/fields/update/'.$collection['_id']->__toString()."/".$key)?>">Edit</a></td>
            <td><a href="<?=NoiCore::app()->getRoute('p_mg/fields/delete/'.$collection['_id']->__toString()."/".$key)?>">Delete</a></td>
        </tr>
    <?    
    }    
    }
    ?>
    </tbody>
</table>