<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$components=scandir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/console");
 
if(count($components)>0){

foreach($components as $c){
 if($c!="." and $c!=".."){


 require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/console/".$c;
 }
}
}

$config= [
    'id' => 'basic-console',
    'basePath' => PATH_TO_ENGINE,
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'noicms\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
         'session' => [
            'class' => 'yii\mongodb\Session',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
         'mongodb' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];
