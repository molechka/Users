<?php

$plugin_config = array();
$plugin_config['name'] = 'tasks';
$plugin_config['route'] = 'tasks';
$plugin_config['type_run'] = "route";

$plugin_config['mongogrid'] = array(
    "users" => array(
        "label" => 'Емаил ownerов при создании задач через rest\soap',
        "count" => 1,
        'visible' => false,
        'fields' => array(
            'rest' => array('type' => 'string', 'label' => 'Email пользователя для REST', 'opt' => array()),
            'soap' => array('type' => 'string', 'label' => 'Email пользователя для SOAP', 'opt' => array()),
        ),
    ),
);
