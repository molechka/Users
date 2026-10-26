<div class="row">
    <h2>Результаты обработки</h2>   
    <table class="  table">
        <tr  >
            <td><label for="id_address">Исходное ФИО:</label></td> 
            <td><input class="form-control" name="name" value="<?=$_POST['name'];?>"></td>
        </tr>  
        <tr>
            <td><label for="id_address">После обработки:</label></td> 
            <td><input class="form-control" readonly   value="<?=$fio_new;?>"></td>
        </tr>  
        <tr>
            <td colspan="2">
            <?
            if($fio_status){
            ?>
                <div class="alert alert-success"><p><?=$fio_text;?></p></div>    
            <?    
            }else {
            ?>
           <div class="alert alert-danger"><p><?=$fio_text;?></p></div>     
            <?    
            }
            ?>
            </td>
        
        </tr>
        <tr>
                        <th><label for="id_address">Исходная дата:</label></th>
                        <td><input class="form-control form_dr"  maxlength="300" name="date" value="<?=$_POST['date'];?>"   placeholder="11.03.2000" type="text"></td>
                    </tr>
         <tr>
                        <th><label for="id_address">Категория:</label></th>
                        <td><input class="form-control form_dr"  maxlength="300" readonly value="<?=$category;?>"   placeholder="11.03.2000" type="text"></td>
                    </tr>           
                   <tr>
            <td colspan="2">
            <?
            if($date_status){
            ?>
                <div class="alert alert-success"><p><?=$date_text;?></p></div> 
                
            <?    
            }else {
            ?>
           <div class="alert alert-danger"><p><?=$date_text;?></p></div>     
            <?    
            }
            ?>
            </td>
        
        </tr>
           
    </table>
</div>
