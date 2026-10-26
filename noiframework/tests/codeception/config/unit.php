<?php
/**
 * Application configuration for unit tests
 */
     
return yii\helpers\ArrayHelper::merge(
    require(PATH_TO_ENGINE . '/vendor/noistudio/noiframework/config/web_tests.php'),
     
    [

    ]
);
