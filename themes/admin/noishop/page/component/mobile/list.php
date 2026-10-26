<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("mobile/index");?>"><?php echo NoiCore::app()->lang('setup_mobile');?></a></li>
  <li class="active"><?php echo NoiCore::app()->lang('mobile_logs_used');?></li>
</ol>
<h2><?php echo NoiCore::app()->lang('mobile_logs_used');?></h2>
<table class="table">
    <thead>
        <tr>
            <th><?php echo NoiCore::app()->lang('mobile_logs_openkey');?></th>
            <th><?php echo NoiCore::app()->lang('mobile_logs_closedkey')?></th>

            <th>IP</th>
              <th><?php echo NoiCore::app()->lang('mobile_logs_data');?></th>
        </tr>
    </thead>
    <tbody>
     <?
     if(isset($logs) and count($logs)>0){
     foreach($logs as $log){
     ?>
        <tr>
            <td><?php echo $log['openkey'];?></td>
             <td><? if(isset($log['phrase'])) { $log['phrase'];}?></td>
             <td><? if(isset($log['ip'])) { $log['ip'];}?></td>
               <td><?if(isset($log['date'])){ echo date('Y-m-d H:i:s',$log['date']->sec);} ?></td>
             

        </tr>
     <?
     }
     }
     ?>
    </tbody>
</table>
<p><?php echo NoiCore::app()->lang('mongogrid_all');?>:<?php echo $count;?></p>
<?php echo $pages;?>