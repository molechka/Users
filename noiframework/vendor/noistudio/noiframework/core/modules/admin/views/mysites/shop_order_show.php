<?php
 $statuses=  MGQuery::execute2(array(), 'user_shop_statuses', array());
 if(isset($mg->result) and isset($mg->result[0]['_id'])){
 
 $items=$mg->result[0]['items'];
 $order_id=$mg->result[0]['_id']->__toString();
 if(isset($mg->result[0]['order_id'])){
 $order_id=$mg->result[0]['order_id'];
 }
 ?>
<h2>#<?php echo $order_id;?></h2>
<form action="" method="POST">
<table class="table">
 
    <thead>
        <tr>
            <th><?php echo Lang::t("shop_items_title");?></th>
            <th><?php echo Lang::t("component_shop_quantity");?></th>
        </tr>
    </thead>
 <?
 if(isset($items) and is_array($items) and $items>0){
  foreach($items as $it){
 ?>
    <tr>
        <td><?php echo $it['item']['title'];?></td>
        <td><?php echo $it['count'];?></td>
    </tr>
 <?

  }
 }
 $adress=$mg->result[0]['adress'];
 if(isset($adress) and is_array($adress) and isset($adress['name'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_name");?></td>
        <td><?php echo $adress['name'];?></td>
    </tr>

 <?
 }

 if(isset($adress) and is_array($adress) and isset($adress['phone'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_phone");?></td>
        <td><?php echo $adress['phone'];?></td>
    </tr>

 <?
 }

 if(isset($adress) and is_array($adress) and isset($adress['adress1'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_adress1");?></td>
        <td><?php echo $adress['adress1'];?></td>
    </tr>

 <?
 }

 if(isset($adress) and is_array($adress) and isset($adress['adress2'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_adress2");?></td>
        <td><?php echo $adress['adress2'];?></td>
    </tr>

 <?
 }
  if(isset($adress) and is_array($adress) and isset($adress['city'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_city");?></td>
        <td><?php echo $adress['city'];?></td>
    </tr>

 <?
 }
  if(isset($adress) and is_array($adress) and isset($adress['zip'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_zip");?></td>
        <td><?php echo $adress['zip'];?></td>
    </tr>

 <?
 }

  if(isset($adress) and is_array($adress) and isset($adress['country'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_country");?></td>
        <td><?php echo $adress['country'];?></td>
    </tr>

 <?
 }
  if(isset($adress) and is_array($adress) and isset($adress['email'])){
 ?>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_email");?></td>
        <td><?php echo $adress['email'];?></td>
    </tr>

 <?
 }
 if(isset($mg->result[0]['fields']) and is_array($mg->result[0]['fields']) and count($mg->result[0]['fields'])>0){
 foreach($mg->result[0]['fields'] as $field){
 if(isset($field['title']) and isset($field['value'])){
 ?>
    <tr>
        <td><?php echo $field['title']?></td>
        <td><?php echo $field['value'];?></td>
    </tr>
 <?
 }
 }
 }
 ?>
    <tr>
        <td>Статус</td>
        <td>
            <select name="status">
             <?
             if(isset($statuses[0]['_id'])){
              foreach($statuses as $st){
              $selected="";
              if($st['_id']->__toString()==$mg->result[0]['status']){
              $selected="selected";
              }
              ?>
             <option <?php echo $selected;?> value="<?php echo $st['_id']->__toString();?>"><?php echo $st['name'];?></option>
              <?
              }
             }
             ?>
                
                
            </select>
        </td>
    </tr>
    <tr>
        <td><?php echo Lang::t("component_shop_orders_end");?></td>
                <td><select name="complete">

                        <option <? if(isset($mg->result[0]['complete']) and $mg->result[0]['complete']=="0") { echo "selected"; }  ?> value="0"><?php echo Lang::t("component_shop_orders_end_0");?></option>
                        <option <? if(isset($mg->result[0]['complete']) and $mg->result[0]['complete']=="1") { echo "selected"; }  ?> value="1"><?php echo Lang::t("component_shop_orders_end_1");?></option>
            </select></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" class="btn btn-submit" name="act_save_order" value="Save Changes"></td>
    </tr>
</table>
</form>
<?
 }