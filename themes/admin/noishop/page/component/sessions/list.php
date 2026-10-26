<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang('sessions');?></li>
</ol>
<h2><?php echo NoiCore::app()->lang('sessions');?></h2>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th></th>


        </tr>
    </thead>
    <tbody>
     <?
     if(isset($sessions) and count($sessions)>0){
     foreach($sessions as $session){
     ?>
        <tr>
            <td>#<?php echo $session['_id']->__toString();?></td>
            <td><a href="<?php echo NoiCore::app()->getRoute('sessions/delete/'.$session['_id']->__toString())?>"><?php echo NoiCore::app()->lang('delete');?></a></td>
              

        </tr>
     <?
     }
     }
     ?>
    </tbody>
</table>
