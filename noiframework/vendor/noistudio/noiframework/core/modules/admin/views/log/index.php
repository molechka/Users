<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("logs_title");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("logs_title");?></h2>
<table class="table">
    <thead>
        <tr>
            <th>IP-adress</th>
            <th>User agent</th>

            <th>Time</th>
              <th>Route</th>
        </tr>
    </thead>
    <tbody>
     <?
     if(isset($logs) and count($logs)>0){
     foreach($logs as $log){
     ?>
        <tr>
            <td><?php echo $log['ip'];?></td>
             <td><?php echo $log['user_agent'];?></td>
               <td><?if(isset($log['date'])){ echo date('Y-m-d H:i:s',$log['date']->sec);} ?></td>
             <td><?php echo $log['route'];?></td>
           
        </tr>
     <?
     }
     }
     ?>
    </tbody>
</table>
