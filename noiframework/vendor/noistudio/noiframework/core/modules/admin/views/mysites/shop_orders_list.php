<h3><?php echo $mg->title;?></h3>

<table class="table">
 <tr><td>
 <?

 if(in_array("create",$mg->operations->available)){
 ?>
<a href="<?php echo $mg->setRoute('/create/1');?>"><?php echo Lang::t('standart_create_button');?></a>
<?
 }

 ?><br>
   </td>

    
 </tr>
</table>
<form action="" method="POST">
<table  class="table">
    <tr>
        <td><?php echo Lang::t("component_shop_orders_date_order_id");?></td>
          <td><input type="text" name="filter_order_id" value="<?if(isset($_POST['filter_order_id'])) { echo $_POST['filter_order_id'];}?>"</td>
    </tr>
   <?
    $filter_date_order_begin=yii::app()->session['filter_date_begin'];

   ?>
        <td><?php echo Lang::t("component_shop_orders_date_order_begin");?> </td>
        <td><input type="text" name="filter_date_begin" value="<?if(isset($filter_date_order_begin)){ echo $filter_date_order_begin;}?>"></td>
    </tr>
     <tr>
   <?
    $filter_date_order_end=yii::app()->session['filter_date_end'];

   ?>
        <td><?php echo Lang::t("component_shop_orders_date_order_end");?> </td>
        <td><input type="text" name="filter_date_end" value="<?if(isset($filter_date_order_end)){ echo $filter_date_order_end;}?>"></td>
    </tr>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_status");?> </td>
        <td><select name="filter_status">
  <?
  $filter_status=yii::app()->session['filter_status'];
 
  if(!StrInput::is_Id($filter_status)){
  $filter_status="0";
  }
  ?>
                <option <? if(isset($filter_status) and $filter_status=="0") { echo "selected";} ?> value="0">none</option>
           <?
 $statuses=  MGQuery::execute2(array(), 'user_shop_statuses', array());
 if(isset($statuses) and isset($statuses[0]['_id'])){

 foreach($statuses as $st){
 ?>
                <option <? if(isset($filter_status) and $filter_status==$st['_id']->__toString()) { echo "selected";} ?> value="<?php echo $st['_id']->__toString();?>"><?php echo $st['name'];?></option>
 <?
 }
 }
 ?>
            </select></td>
    </tr>
     <tr>
        <td><?php echo Lang::t("component_shop_orders_end");?></td>
                <td><select name="filter_complete">
                        <option value="2">None</option>
<?
$filter_complete=yii::app()->session['filter_complete'];
if(!isset($filter_complete) and $filter_complete!="0" and $filter_complete!="1"){
$filter_complete=0;
}
?>
                        <option <?if(isset($filter_complete) & $filter_complete=="0"){ echo "selected";}?>  value="0"><?php echo Lang::t("component_shop_orders_end_0");?></option>
                        <option <?if(isset($filter_complete) & $filter_complete=="1"){ echo "selected";}?> value="1"><?php echo Lang::t("component_shop_orders_end_1");?></option>
            </select></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" class="btn btn-success" name="act_search" value="Search"></td>
    </tr>
</table>
</form>
<table class="table">
    <thead>
    <tr>
        <td><?php echo Lang::t("component_shop_admin_order_id");?></td>
        <td><?php echo Lang::t("component_shop_admin_price");?></td>
        <td></td>
        <td></td>
    </tr>
    </thead>
    <tbody class="ajax_load_row">
    <?


    if(isset($mg->result) and isset($mg->result[0]['_id'])){
     foreach($mg->result as $row){
     $order_id=$row['_id']->__toString();
     if(isset($row['order_id'])){
     $order_id=$row['order_id'];
     }
     ?>
    <tr>
        <td><a href="<?php echo $mg->setRoute('/show/'.$row['_id']->__toString());?>"><?php echo $order_id;?></a></td>
        <td><?php echo $row['price'];?></td>
        <td><?php echo date('Y-M-d', $row['date_order']->sec); ;?></td>
        <td> <?
    if(in_array("delete",$mg->operations->available) and !in_array("delete",$mg->operations->denied_access)  and isset($row['_id'])){
    ?>
    <a href="<?php echo $mg->setRoute('/delete/'.$row['_id']->__toString());?>"><?php echo Lang::t("standart_delete_button");?></a>

    <?
    }
    ?></td>
    </tr>
     <?
     }
    }

    ?>
    </tbody>
</table>
<mgplugin count="<?php echo $mg->result[0]['_count_'];?>" limit="<?php echo $mg->page_item;?>">paginator</mgplugin>
