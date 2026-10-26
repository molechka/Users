<div class="totalpage">
<div class="row">
    
    <div class="col-md-7"><h2>Предварительные результаты</h2></div>
    <div class="col-md-4">
        <p><?=$name_file;?> | <a href="/">Выбрать другой файл</a></p>
    </div>
    
</div>
<div class="row">
   
    <?=$controller->render("xls",array('result'=>$result['results']));?>
</div>
<?
if(count($result['results'])>100){
?>
<div class="row">
    <p>Показаны первые 100 записей</p>   
</div>
<?
}
?>
<div class="row">
    <div class="col-md-6">
    <?=count($result['results']);?> записей, стоимостью <?=$result['totalmoney'];?> рублей  
    </div>  
    <div class="col-md-6">
        <?
        if($canpay){
        ?>
        <a data-href="/bugs/xls/pay/<?=$result['last_id'];?>" href="#" class="btn btn-danger startprogress">Обработать файл</a>  
        <?
        }else {
        ?>
        <a  href="/bugs/xls/save/<?=$result['last_id']?>" class="btn btn-danger">пополнить счет и обработать</a>
        <?
        }
        ?>
    </div>
</div>
</div>
<div class="row">
    <img class="img-responsive superimg" style="display: none;width:50%;" src="/tmp/files/progress.png">   
  <div id="sample_goal" style="display:none;"></div>  
</div>

