<?php

$events_array=array();
$events_array['payeer_exists']=array('class'=>"\\pay\\models\\Payeer",'method'=>'exists');
$events_array['payeer_form']=array('class'=>"\\pay\\models\\Payeer",'method'=>'form');
$events_array['payeer_check']=array('class'=>"\\pay\\models\\Payeer",'method'=>'check');
//
//
//$events_array['perfectmoney_exists']=array('class'=>"\\pay\\models\\Perfectmoney",'method'=>'exists');
//$events_array['perfectmoney_form']=array('class'=>"\\pay\\models\\Perfectmoney",'method'=>'form');
//$events_array['perfectmoney_check']=array('class'=>"\\pay\\models\\Perfectmoney",'method'=>'check');

//$events_array['interkassa_exists']=array('class'=>"\\pay\\models\\Interkassa",'method'=>'exists');
//$events_array['interkassa_form']=array('class'=>"\\pay\\models\\Interkassa",'method'=>'form');
//$events_array['interkassa_check']=array('class'=>"\\pay\\models\\Interkassa",'method'=>'check');
//$events_array['personalpay_exists']=array('class'=>"\\pay\\models\\Personalpay",'method'=>'exists');
//$events_array['personalpay_form']=array('class'=>"\\pay\\models\\Personalpay",'method'=>'form');
//$events_array['personalpay_check']=array('class'=>"\\pay\\models\\Personalpay",'method'=>'check');

$events_array['pay_urls']=array(
 
array('class'=>"\\pay\\models\\Payeer",'method'=>'listUrl')    
);

