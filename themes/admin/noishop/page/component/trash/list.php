<?
use yii\data\Pagination;

use yii\web\Linkable;
use yii\widgets\LinkPager;
?>
<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang('trash_title');?></li>
</ol>

<h2><?php echo NoiCore::app()->lang('trash_title');?><sup><a href="<?php echo NoiCore::app()->getRoute('trash/delete/all');?>"><?php echo NoiCore::app()->lang('trash_delete_all');?></a></sup></h2>
<table class="table">
    <thead>
        <tr>
            <th><?php echo NoiCore::app()->lang('trash_collection');?></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
     <?
     if(isset($trash) and count($trash)>0){
     foreach($trash as $tr){
     ?>
        <tr>
            <td><?php echo $tr['collection'];?></td>
            <td><?
            if(isset($tr['date'])){
            echo date('Y-m-d H:i',$tr['date']->sec);
            }
            ?></td>
            <td><a href="<?php echo NoiCore::app()->getRoute('trash/restore/'.$tr['_id']->__toString());?>"><?php echo NoiCore::app()->lang('trash_restore');?></a></td>
            <td><a href="<?php echo NoiCore::app()->getRoute('trash/delete/'.$tr['_id']->__toString());?>"><?php echo NoiCore::app()->lang('trash_delete');?></a></td>
           
        </tr>
     <?
     }
     }
     ?>
    </tbody>
</table>
<?
echo $paginator;
?>