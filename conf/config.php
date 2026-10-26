<?php

$config = array();


$config['debug'] = false;
$type_run = php_sapi_name();
$config_admin = array();
$config_admin['only_ip'] = "";

$config_admin['document_root'] = "/var/www/admin/www/users.bugred.ru";



$type_run = php_sapi_name();
$config_admin = array();
$config_admin['only_ip'] = "";
$config_admin['admin_folder'] = "adminbugusers";
$config_admin['document_root'] = "/home/megamind/NoiProjects/noiframe2/";



$config_admin['http_host'] = "wantmay.com";
$config['admin_username'] = "useradmin";
$config['admin_password'] = "change-me";
$config['default_language'] = "ru";
$config['user_id'] = "54553141c42693be328b4567";
$config['api_site_id'] = "54553141c42693be328b4568";
$config['api_login'] = "username";
$config['api_password'] = "password";
$language_set = "ru";
$config['default_lang'] = $language_set;
$config['sitestorage'] = "mongodb";
$config['json'] = '{json}';
