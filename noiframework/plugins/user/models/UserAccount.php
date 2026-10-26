<?php

namespace user\models;

use NoiCore;
use noicms\mongogrid\OneField;
use MongoId;
use MongoDate;

class UserAccount {

    static function checkField($name, $value, $value2 = 0) {
        if (!isset($name) and ! is_string($name)) {
            return false;
        }
        if (!isset($value) and ! is_string($value)) {
            return false;
        }
        if ($name == "captcha") {
            $result_captcha = NoiCore::c("captcha")->check("noicms_captcha", $value);
            return $result_captcha;
        }
        $main_conf = NoiCore::app()->plugin_values("user", "default");
        if (!isset($main_conf[0]['collection'])) {
            return false;
        }
        $collection = $main_conf[0]['collection'];
        $fields = NoiCore::app()->plugin_values("user", "fields");
        $newfields = UserAccount::getFields();

        if (isset($newfields[$name])) {

            $_POST[$name] = $value;
            $key_field = $name;
            $field = $newfields[$name];
            if ($field['required'] == 1 or $field['required'] == "1") {
                if (!isset($_POST[$key_field]) or strlen($_POST[$key_field]) == 0) {
                    $_POST['error_key'] = $key_field;
                    $_POST['error_message'] = NoiCore::app()->lang("register_required_field", "user");
                    ;

                    return false;
                } else {
                    
                }
            }

            if ($field['unique'] == 1 and isset($_POST[$key_field]) and strlen($_POST[$key_field]) > 0) {
                $_POST[$key_field] = strtolower($_POST[$key_field]);
                $result_found = NoiCore::app()->db()->query(array(), $collection, array($key_field => $_POST[$key_field]));
                $condition2 = array();

                $condition2[$key_field] = strlen($_POST[$key_field]);
                $result_found2 = NoiCore::app()->db()->query(array(), $collection, $condition2);

                if (isset($result_found2[0]['_id'])) {
                    $result_found = array_merge($result_found, $result_found2);
                }
                if (isset($result_found[0]['_id'])) {
                    $_POST['error_key'] = $key_field;
                    $_POST['error_message'] = NoiCore::app()->lang("register_busy", "user");
                    ;
                    return false;
                }
            }
            if (isset($_POST[$key_field]) and strlen($_POST[$key_field]) > 0) {
                if ($field['type'] == "password") {

                    $_POST[$field['render']->getName() . "_2"] = $value2;
                }
                $_POST[$field['render']->getName()] = $_POST[$key_field];
                $tmp_result = $field['render']->setInput();
                if ($tmp_result === false) {
                    $_POST['error_key'] = $key_field;
                    $_POST['error_message'] = NoiCore::app()->lang("register_not_correct_field", "user");
                    ;
                    return false;
                } else {
                    return true;
                }
            } else {
                if ($field['default_status'] == 1) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    static function getEmail() {
        $all_fields = NoiCore::app()->plugin_values("user", "fields");
        $result = array();
        if (isset($all_fields) and count($all_fields) > 0) {
            foreach ($all_fields as $field) {

                if (isset($field['is_email']) and $field['is_email'] == 1) {
                    return $field['name'];
                }
            }
        }
    }

    static function getRoles() {
        $roles = NoiCore::app()->plugin_values("user", "roles");
        $result_array = array();
        if (isset($roles) and is_array($roles) and count($roles) > 0) {
            foreach ($roles as $role) {
                if ($role['default'] == "1") {
                    $result_array[] = $role['name'];
                }
            }
        }
        return $result_array;
    }

    static function getLogin() {
        $all_fields = NoiCore::app()->plugin_values("user", "fields");
        $result = array();
        if (isset($all_fields) and count($all_fields) > 0) {
            foreach ($all_fields as $field) {

                if (isset($field['is_login']) and $field['is_login'] == 1) {
                    return $field['name'];
                }
            }
        }
    }

    static function isManager() {

        $result = NoiCore::app()->getSession("user_result");
        if (isset($result['ismanager']) and $result['ismanager'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    static function checkFields($fields) {
        $main_conf = NoiCore::app()->plugin_values("user", "default");
        if (!isset($main_conf[0]['collection'])) {
            return false;
        }
        $collection = $main_conf[0]['collection'];
        $result_array = array();
        if (is_array($fields) and count($fields) > 0) {
            foreach ($fields as $key_field => $field) {

                if ($field['required'] == 1 or $field['required'] == "1") {
                    if (!isset($_POST[$key_field]) or strlen($_POST[$key_field]) == 0) {
                        $_POST['error_key'] = $key_field;
                        $_POST['error_message'] = NoiCore::app()->lang("register_required_field", "user");

                        return false;
                    } else {
                        
                    }
                }

                if ($field['unique'] == 1 and isset($_POST[$key_field]) and strlen($_POST[$key_field]) > 0) {
                    $_POST[$key_field] = strtolower($_POST[$key_field]);
                    $result_found = NoiCore::app()->db()->query(array(), $collection, array($key_field => strtolower($_POST[$key_field])));
                    $condition2 = array();

                    $condition2[$key_field] = strlen($_POST[$key_field]);
                    $result_found2 = NoiCore::app()->db()->query(array(), $collection, $condition2);

                    if (isset($result_found2[0]['_id'])) {
                        $result_found = array_merge($result_found, $result_found2);
                    }
                    if (isset($result_found[0]['_id'])) {
                        $_POST['error_key'] = $key_field;
                        $_POST['error_message'] = NoiCore::app()->lang("register_busy", "user");
                        ;
                        return false;
                    }
                }
                if (isset($_POST[$key_field]) and strlen($_POST[$key_field]) > 0) {
                    $_POST[$field['render']->getName()] = $_POST[$key_field];
                    if ($field['type'] == "password") {
                        if (!isset($_POST[$key_field . "_2"])) {
                            $_POST[$key_field . "_2"] = "";
                        }
                        $_POST[$field['render']->getName() . "_2"] = $_POST[$key_field . "_2"];
                    }
                    $tmp_result = $field['render']->setInput();
                    if ($tmp_result === false) {
                        $_POST['error_key'] = $key_field;
                        $_POST['error_message'] = NoiCore::app()->lang("register_not_correct_field", "user");
                        return false;
                    } else {
                        $result_array[$key_field] = $tmp_result;
                    }
                } else {
                    if ($field['default_status'] == 1) {
                        $result_array[$key_field] = $field['default'];
                    }
                }
            }
            return $result_array;
        } else {
            return false;
        }
    }

    static function addOtherfields($array) {
        $all_fields = NoiCore::app()->plugin_values("user", "fields");
        $result = array();
        if (isset($all_fields) and count($all_fields) > 0) {
            foreach ($all_fields as $field) {

                if (isset($field['available_pages']) and ! in_array("register", $field['available_pages'])) {
                    if ($field['default_status'] == 1) {
                        $array[$field['name']] = $field['default'];
                    }
                }
            }
        }
        return $array;
    }

    static function getFields() {
        $all_fields = NoiCore::app()->plugin_values("user", "fields");
        $result = array();
        if (isset($all_fields) and count($all_fields) > 0) {
            foreach ($all_fields as $field) {

                if (isset($field['available_pages']) and in_array("register", $field['available_pages'])) {
                    $field['render'] = new OneField();
                    $opt = array();

                    $json_opt = json_decode($field['opt'], true);
                    if ($json_opt != NULL and is_array($json_opt)) {
                        $opt = $json_opt;
                    }

                    $field['render']->init($field['name'], $field['type'], $opt);
                    $result[$field['name']] = $field;
                }
            }
        }
        return $result;
    }

    static function insert($isactivate = 1, $result = array()) {
        $main_conf = NoiCore::app()->plugin_values("user", "default");
        $status_activate = NoiCore::app()->plugin_values("user", "status_activate");


        $result['_id'] = new MongoId();
        $result['role'] = UserAccount::getRoles();
        $result['date_register'] = new MongoDate();
        $result['date'] = date('Y-m-d');
        $result['user_active'] = 0;
        $result['enable_account'] = 1;
        $result['total_deposits'] = 0;
        $result['with_vznos'] = 0;
        $result['with_outvznos'] = 0;
        $result['structure_vznos'] = 0;

        $result = UserAccount::addOtherfields($result);

        if ($isactivate == 1) {
            $field_email = UserAccount::getEmail();
            $result['enable_account'] = 0;
            $result['activate_email'] = hash("sha512", time() . "" . rand(0, 9999));
            if (isset($status_activate[0]['text_mail_from']) and isset($status_activate[0]['text_mail_subject']) and isset($status_activate[0]['text_mail'])) {
                $text = $status_activate[0]['text_mail'];
                foreach ($result as $key => $row) {
                    if (is_string($result[$key])) {
                        $text = str_replace("[user." . $key . "]", $row, $text);
                    }
                }
                $link = "http://" . $_SERVER['HTTP_HOST'] . "/user/activate/" . $result['activate_email'];
                $text = str_replace("[link]", $link, $text);
                NoiCore::app()->email($result[$field_email], $status_activate[0]['text_mail_subject'], $text, $status_activate[0]['text_mail_from']);
            }
        }

        $result['user_money'] = 0;
        $result = NoiCore::app()->db()->insert($result, $main_conf[0]['collection'], true);
        UserAccount::eventAfter($result);
        if (isset($main_conf[0]['auto_login']) and $main_conf[0]['auto_login'] == 1 and $result['enable_account'] == 1) {
            //$user_identify=new UserIdentify("1","1");
            // $user_identify->login=$result[$this->getLogin()];
            $result['user_id'] = $result['_id']->__toString();
            // $user_identify->result=$result;
            // $result=$user_identify->authenticate();
            NoiCore::app()->setSession("user_auth", 1);
            NoiCore::app()->setSession("user_id", $result['_id']->__toString());
            NoiCore::app()->setSession("user_result", $result);
            NoiCore::app()->redirect($main_conf[0]['after_login']);
        } else {
            NoiCore::app()->redirect($main_conf[0]['after_register']);
        }
    }

    static function eventAfter($user) {
        if (isset($user['_id'])) {
            $array_referals = array();
            $array_update = array();
            $end = strtotime('+1 years');
            $array_update['end_date'] = new MongoDate($end);
            if (isset($user['referal']) and strlen($user['referal']) > 1) {
                $array_referals = UserAccount::getArrayReferals($user, "referal", $array_referals);

                if (count($array_referals) > 0) {

                    $array_update['referals_list'] = $array_referals;
                }
            }

            NoiCore::user()->update($array_update, $user['_id']->__toString());
        }
    }

    static function getArrayReferals($user, $field, $results) {
        if (isset($user[$field]) and strlen($user[$field]) > 1) {
            $result = NoiCore::app()->db()->query(array(), "cms_users", array('login' => $user[$field]));
            if (isset($result[0]['_id'])) {
                if (isset($result[0]['referals_list']) and is_array($result[0]['referals_list'])) {
                    $results = $result[0]['referals_list'];
                }
                array_unshift($results, $user[$field]);
            }
            return $results;
        } else {
            return $results;
        }
    }

}
