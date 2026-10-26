<?php

//$cache_conf=array(
//            'class'=>'system.caching.CMemCache',
//            'servers'=>array(
//                array('host'=>'localhost', 'port'=>11211, 'weight'=>60),
//
//            ),
//        );
//normal_caching

$cache_conf=array(
            'class'=>'EDMSCache',
             'ensureIndex' => true,

        );

