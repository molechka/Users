 
<table class="table">
    <thead>
    <?
    if(count($result[0])){
    foreach($result[0] as $value){
    ?>
    <th><?=$value;?></th>    
    <?    
    }    
    }
    ?>
    </thead>
    <tbody>
<?
if(count($result)>0){
$key=1;    
while(isset($result[$key])){
 $row=$result[$key];   
if($key>=100){
 break;   
}    
?>
    <tr>
  <?
  if(count($row)){
   foreach($row as $val){
   ?>
        <td><?=$val;?></td>     
   <?     
   }   
  }
  ?>
   
    </tr>    
<?    
$key++;    
}
    
}
?>
    </tbody>
</table>
