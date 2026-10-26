<?
if(count($collections)){
foreach($collections as $collection){
if(count($collection['fields'])>0){    
?>
<div class="col-md-6">
    <h4><?=$collection['title'];?></h4>  
    <table class="table">
        <thead>
            <tr>
                <?
                 foreach($collection['fields'] as $kf=>$f){
                 if($f['showinlist']!==0){
                 ?>
                <th><?=$f['title'];?></th>
                 <?
                 }    
                 }
                ?>
               
                <th>Кнопка</th>
                <th>Кнопка</th>
            </tr> 
            
        </thead>
        <tbody>
          <?
          if(count($collection['rows'])){
          foreach($collection['rows'] as $row){
           ?>
            <tr>
                <?
                 foreach($collection['fields'] as $kf=>$f){
                 if($f['showinlist']!==0 ){
                 ?>
                <td><? if(isset($row[$kf])){ echo $row[$kf]; }?></td>
                 <?
                 }    
                 }
                ?>
                 
                <td><a href="<?=NoiCore::app()->getRoute('p_mg/manage/index/'.$collection['name'].'/null?path_grid_asd=/update/'.$row['_id']->__toString())?>">Редактировать</a></td>
                <td><a href="<?=NoiCore::app()->getRoute('p_mg/manage/index/'.$collection['name'].'/null?path_grid_asd=/delete/'.$row['_id']->__toString())?>">Удалить</a></td>
            </tr>
           <? 
          }    
          }
          ?>
        </tbody>
    </table>
    <p><a class="btn btn-success" href="<?=NoiCore::app()->getRoute('p_mg/manage/index/'.$collection['name']);?>">Посмотреть все <?=$collection['title'];?></a></p>
</div>
<?
}
}    
}
?>
