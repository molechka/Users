<?php
/**
 * Application configuration for acceptance tests
 */

$mongodb=require(__DIR__ . '/config.php');

$webtest=require(PATH_TO_ENGINE . '/vendor/noistudio/noiframework/config/web_tests.php'); 
 

return yii\helpers\ArrayHelper::merge(
    $webtest,
    
    [

    ]
);
