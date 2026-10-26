<?php
/**
 * Application configuration shared by all test types
 */
 
return [
    'components' => [
        'mongodb' => require(PATH_TO_ENGINE . '/vendor/noistudio/noiframework/config/db.php'),
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
