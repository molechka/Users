<h2>Главная страница</h2>
              <?

              $shortcut_all=NoiCore::admin()->getAll("mainpage/index");
              ?>

             
    <div class="row">
<?
if(count($shortcut_all)>0){
foreach($shortcut_all as $value){
?>
  <div class="col-md-6">      
<?        
    echo $value;
?>
    </div>        
<?        
}
}
?>
    </div>
    <?

              $rows=NoiCore::admin()->getAll("rows/index");
              
              ?>

             
    
<?
if(count($rows)>0){
foreach($rows as $row){
?>
  <div class="row">      
<?        
    echo $row;
?>
    </div>        
<?        
}
}
?>
    
                <!-- Shortcuts -->
                
 