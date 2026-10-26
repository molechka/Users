<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterUserFCP
 *
 * @author backdoor
 */
use voucher\models\Linebonus;
use voucher\models\Leaderbonus;
use noicms\mongogrid\OneField;
use voucher\models\ClearAll;

class ProfileUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("user", $cur, $route, 1);

        $this->iswidget = 0;
        if (!$this->user()->isLogin()) {
            \tasks\models\NotifyModel::returntologin();
            exit;
        }
    }

    public function getFields($name_page = "profile") {
        $all_fields = $this->get_value('fields');
        $result = array();
        if (isset($all_fields) and count($all_fields) > 0) {
            foreach ($all_fields as $field) {
                if (isset($field['available_pages']) and in_array($name_page, $field['available_pages'])) {
                    $field['render'] = new OneField();
                    $opt = array();

                    $json_opt = json_decode($field['opt'], true);
                    if ($json_opt != null and is_array($json_opt)) {
                        $opt = $json_opt;
                    }

                    $field['render']->init($field['name'], $field['type'], $opt);
                    $result[$field['name']] = $field;
                }
            }
        }
        return $result;
    }

    public function actionIn2() {
        
    }

    public function actionIndex() {
        NoiCore::app()->setParam("curnav", "profile");

        $this->iswidget = 0;
        $main_conf = $this->get_value();

        if (isset($main_conf[0]['status_profile']) and $main_conf[0]['status_profile'] == 1) {
            $fields = $this->getFields();
            $iserror = 0;

            $_POST['ct_captcha'] = "sadasdsd";
            if (isset($_POST['ct_captcha'])) {
                if (isset($_POST['act_profile_now'])) {
                    $result = $this->checkFields($fields);

                    $check_user = NoiCore::user()->load();
                    if (isset($_POST['finance_password']) and strlen($_POST['finance_password']) > 5) {
                        if (isset($_POST['finance_password2']) and $_POST['finance_password'] == $_POST['finance_password2']) {
                            if (!isset($check_user['finance_password'])) {
                                $result['finance_password'] = hash("sha512", strip_tags($_POST['finance_password']));
                                NoiCore::app()->setNotify("Финансовый пароль успешно установлен!");
                            }
                        }
                    }
                    if (is_array($result) and count($result) > 0) {
                        if (isset($main_conf[0]['collection'])) {

                            // $this->db()->insert($result,$main_conf[0]['collection']);
                            $load = $this->user()->load();
                            if (isset($_POST['inn']) and is_string($_POST['inn']) and strlen($_POST['inn']) > 1) {
                                if (is_numeric($_POST['inn']) and strlen($_POST['inn']) == 12) {

                                    $result['inn'] = (string) $_POST['inn'];
                                } else {
                                    $result['inn'] = "";
                                    NoiCore::app()->setNotify("ИНН ФЛ должен содержать 12 цифр");
                                }
                            }

                            $this->user()->update($result, $load['_id']->__toString());


                            $load = $this->user()->load();
                            $this->subUpdate($load);
                        } else {
                            $iserror = 1;
                        }
                    } else {
                        if ($result === false) {
                            $iserror = 1;
                        }
                    }
                }
            }
            if ($iserror == 1) {
                if (isset($_POST['error_message'])) {
                    // yii::app()->session->add("error_message",$_POST['error_message']);
                }
                if (isset($_POST['error_key'])) {
                    // yii::app()->session->add("error_key",$_POST['error_key']);
                }
                if (isset($_POST['main_form_error'])) {
                    //yii::app()->session->add("main_form_error",$_POST['main_form_error']);
                }
            }

            $user = $this->user()->load();
            $newdata = array("load" => $user, "user" => $user, 'iserror' => $iserror, 'fields' => $fields);
            $newdata['total'] = \historyop\models\Finance::getTotale();
            return $this->render("profile", $newdata);
        }
    }

    public function getRoles() {
        $roles = $this->get_value('roles');
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

    public function getLogin() {
        $all_fields = $this->get_value('fields');
        $result = array();
        if (isset($all_fields) and count($all_fields) > 0) {
            foreach ($all_fields as $field) {
                if (isset($field['is_login']) and $field['is_login'] == 1) {
                    return $field['name'];
                }
            }
        }
    }

    public function subUpdate($load) {
        //    $array_update_wall=array();
//    $array_update_wall['user']=$load;
//    $array_update_friend['friend']=$load;
//    $this->db()->update($array_update_wall,"my_wall",array('user.login'=>$load['login']),true);
//    $this->db()->update($array_update_friend,"my_friends",array('friend.login'=>$load['login']),true);
    }

    public function checkFields($fields) {
        $main_conf = $this->get_value();
        if (!isset($main_conf[0]['collection'])) {
            return false;
        }
        $collection = $main_conf[0]['collection'];
        $result_array = array();

        if (is_array($fields) and count($fields) > 0) {
            foreach ($fields as $key_field => $field) {
                $continue = 1;
                if ($field['required'] == 1 or $field['required'] == "1") {
                    if (!isset($_POST[$key_field]) or strlen($_POST[$key_field]) == 0) {
                        $continue = 0;
                    } else {
                        
                    }
                }
                if ($continue == 1) {
                    if ($field['unique'] == 1 and isset($_POST[$key_field]) and strlen($_POST[$key_field]) > 0) {
                        $result_found = $this->db()->query(array(), $collection, array($key_field => $_POST[$key_field]));
                        if (isset($result_found[0]['_id'])) {
                            $continue = 0;
                        }
                    }
                    if ($continue == 1) {
                        if ((isset($_FILES[$key_field])) or isset($_POST[$key_field]) and strlen($_POST[$key_field]) > 0) {
                            if (isset($_POST[$key_field])) {
                                $_POST[$field['render']->getName()] = $_POST[$key_field];
                            }
                            if (isset($_FILES[$key_field])) {
                                $_FILES[$field['render']->getName()] = $_FILES[$key_field];
                            }
                            $tmp_result = $field['render']->setInput();
                            if ($tmp_result === false) {
                                $continue = 0;
                            } else {
                                $result_array[$key_field] = $tmp_result;
                            }
                        } else {
                            if ($field['type'] == "checkbox") {
                                if (!isset($_POST[$key_field])) {
                                    $result_array[$key_field] = 0;
                                }
                            }
                        }
                    }
                }
            }
            return $result_array;
        } else {
            return false;
        }
    }

}
