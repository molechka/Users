<?php

namespace companys\models;

use MongoDate;
use NoiCore;

class CompanyModel {

    static function all($user) {

        $sort = array("last_id" => -1);
        $condition = array();
        $condition['users.id_' . $user['last_id'] . ".last_id"] = $user['last_id'];
        $query = NoiCore::app()->db()->query2(array(), "companys", $condition, $sort);
        return $query;
    }

    public static function getUser($last_id) {
        $condition = array();
        if (isset($last_id) and filter_var($last_id, FILTER_VALIDATE_EMAIL)) {
            $condition['email'] = strtolower((string) $last_id);
        } else {
            $condition = array('last_id' => (int) $last_id);
        }

        $result = false;
        $query = NoiCore::app()->db()->query(array(), "cms_users", $condition);
        if (isset($query[0]['_id'])) {
            $result = $query[0];
        }
        return $result;
    }

    static function get($last_id, $readonly = false) {
        $user = NoiCore::user()->load();
        $condition = array();
        if (!$readonly) {
            $condition = array('creator._id' => $user['_id']);
            if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
                $condition = array();
            }
        }
        $condition['last_id'] = (int) $last_id;

        $result = false;
        $query = NoiCore::app()->db()->query(array(), "companys", $condition);
        if (isset($query[0]['_id'])) {
            $result = $query[0];
        }


        return $result;
    }

    static function update($company) {
        $update = array();
        if (!(isset($_POST['name']) and is_string($_POST['name']) and strlen($_POST['name']) > 0)) {
            NoiCore::app()->setNotify("Вы не ввели название компании");
            \Yii::warning("Вы не ввели название компании", "companys_update");
            return false;
        }
        $types = array("ООО", "ИП", "ОАО");
        if (!(isset($_POST['type']) and is_string($_POST['type']) and in_array($_POST['type'], $types))) {
            NoiCore::app()->setNotify("Вы не выбрали ТИП");
            \Yii::warning("Вы не выбрали ТИП", "companys_update");
            return false;
        }
        $inn_length = 10;
        if ($_POST['type'] == "ИП") {
            $inn_length = 12;
        }

        if (isset($_POST['inn']) and strlen($_POST['inn']) > 0) {
            if (!(isset($_POST['inn']) and is_string($_POST['inn']) and is_numeric($_POST['inn']) and strlen($_POST['inn']) == $inn_length)) {


                NoiCore::app()->setNotify("Поле ИНН должно состоять из " . $inn_length . " цифр");
                \Yii::warning("Поле ИНН должно состоять из " . $inn_length . " цифр", "companys_update");
                return false;
            }
        }
        if (isset($_POST['ogrn']) and strlen($_POST['ogrn']) > 0) {
            if (!(isset($_POST['ogrn']) and is_string($_POST['ogrn']) and is_numeric($_POST['ogrn']) and strlen($_POST['ogrn']) == 13)) {
                NoiCore::app()->setNotify("Поле ОГРН должно состоять из 13 цифр");
                \Yii::warning("Поле ОГРН должно состоять из 13 цифр", "companys_update");
                return false;
            }
        }
        if (isset($_POST['kpp']) and strlen($_POST['kpp']) > 0) {
            if (!(isset($_POST['kpp']) and is_string($_POST['kpp']) and strlen($_POST['kpp']) == 9)) {
                NoiCore::app()->setNotify("Поле КПП должно состоять из 9 символов");
                \Yii::warning("Поле КПП должно состоять из 9 символов", "companys_update");
                return false;
            }
        }

        if (isset($_POST['phone']) and strlen($_POST['phone']) > 0) {

            if (!(isset($_POST['phone']) and is_string($_POST['phone']) and is_numeric($_POST['phone']) and strlen($_POST['phone']) > 0)) {
                NoiCore::app()->setNotify("Поле телефон должен состоять из цифр");
                \Yii::warning("Поле телефон должен состоять из цифр", "companys_update");
                return false;
            }
        }
        if (isset($_POST['adress']) and strlen($_POST['adress']) > 0) {
            if (!(isset($_POST['adress']) and is_string($_POST['adress']) and strlen($_POST['adress']) > 0)) {
                NoiCore::app()->setNotify("Вы не заполнили поле адрес ");
                \Yii::warning("Вы не заполнили поле адрес", "companys_update");
                return false;
            }
        }

        $users = array();

        if (isset($_POST['users']) and is_array($_POST['users']) and count($_POST['users'])) {
            foreach ($_POST['users'] as $user_id) {
                $tmp = CompanyModel::getUser((int) $user_id);
                if (is_array($tmp)) {

                    $users['id_' . $tmp['last_id']] = $tmp;
                }
            }
        }

        if (count($users) == 0) {
            
        }







        $array_insert = array();

        $array_insert['date_update'] = new MongoDate();

        $array_insert['name'] = strip_tags($_POST['name']);
        $array_insert['type'] = $_POST['type'];
        if (isset($_POST['inn']) and strlen($_POST['inn']) > 0) {
            $array_insert['inn'] = $_POST['inn'];
        }
        if (isset($_POST['ogrn']) and strlen($_POST['ogrn']) > 0) {
            $array_insert['ogrn'] = $_POST['ogrn'];
        }
        if (isset($_POST['kpp']) and strlen($_POST['kpp']) > 0) {
            $array_insert['kpp'] = strip_tags($_POST['kpp']);
        }
        if (isset($_POST['phone']) and strlen($_POST['phone']) > 0) {
            $array_insert['phone'] = $_POST['phone'];
        }
        if (isset($_POST['adress']) and strlen($_POST['adress']) > 0) {
            $array_insert['adress'] = strip_tags($_POST['adress']);
        }
        if (count($users)) {
            $array_insert['users'] = $users;
        }


        NoiCore::app()->db()->update($array_insert, "companys", array('last_id' => (int) $company['last_id']));

        NoiCore::app()->setNotify("Компания успешно обновлена");
        \Yii::info("Компания успешно обновлена", "companys_update");
        return true;
    }

    public static function add() {
        $creator = NoiCore::user()->load();
        if (!(isset($_POST['name']) and is_string($_POST['name']) and strlen($_POST['name']) > 0)) {
            NoiCore::app()->setNotify("Вы не ввели название компании");
            \Yii::warning("Вы не ввели название компании", "companys_create");

            return false;
//            NoiCore::app()->returnback();
//            exit;
        }
        $types = array("ООО", "ИП", "ОАО");
        if (!(isset($_POST['type']) and is_string($_POST['type']) and in_array($_POST['type'], $types))) {
            NoiCore::app()->setNotify("Вы не выбрали ТИП");
            \Yii::warning("Вы не выбрали ТИП", "companys_create");
            return false;
//            NoiCore::app()->returnback();
//            exit;
        }
        $inn_length = 10;
        if ($_POST['type'] == "ИП") {
            $inn_length = 12;
        }

        if (isset($_POST['inn']) and is_string($_POST['inn']) and strlen($_POST['inn']) > 1) {
            if (!(isset($_POST['inn']) and is_string($_POST['inn']) and is_numeric($_POST['inn']) and strlen($_POST['inn']) == $inn_length)) {


                NoiCore::app()->setNotify("Поле ИНН должно состоять из " . $inn_length . " цифр");
                \Yii::warning("Поле ИНН должно состоять из " . $inn_length . " цифр", "companys_create");
                //           NoiCore::app()->returnback();
                //           exit;
                return false;
            }
        } else {
            $_POST['inn'] = "";
        }
        if (isset($_POST['ogrn']) and is_string($_POST['ogrn']) and strlen($_POST['ogrn']) > 1) {
            if (!(isset($_POST['ogrn']) and is_string($_POST['ogrn']) and is_numeric($_POST['ogrn']) and strlen($_POST['ogrn']) == 13)) {
                $_POST['ogrn'] = "";
                NoiCore::app()->setNotify("Поле ОГРН должно состоять из 13 цифр");
                \Yii::warning("Поле ОГРН должно состоять из 13 цифр", "companys_create");
//                NoiCore::app()->returnback();
//                exit;
                return false;
            }
        } else {
            $_POST['ogrn'] = "";
        }
        if (isset($_POST['kpp']) and is_string($_POST['kpp']) and strlen($_POST['kpp']) > 1) {

            if (!(isset($_POST['kpp']) and is_string($_POST['kpp']) and strlen($_POST['kpp']) == 9)) {

                NoiCore::app()->setNotify("Поле КПП должно состоять из 9 символов");
                \Yii::warning("Поле КПП должно состоять из 9 символов", "companys_create");
                //NoiCore::app()->returnback();
                //exit;
                return false;
            }
        } else {
            $_POST['kpp'] = "";
        }
        if (isset($_POST['phone']) and is_string($_POST['phone']) and strlen($_POST['phone']) > 1) {
            if (!(isset($_POST['phone']) and is_string($_POST['phone']) and is_numeric($_POST['phone']) and strlen($_POST['phone']) > 0)) {

                NoiCore::app()->setNotify("Поле телефон должен состоять из цифр");
                \Yii::warning("Поле телефон должен состоять из цифр", "companys_create");
                //NoiCore::app()->returnback();
                //exit;
                return false;
            }
        } else {
            $_POST['phone'] = "";
        }
        if (isset($_POST['adress']) and is_string($_POST['adress']) and strlen($_POST['adress']) > 1) {
            if (!(isset($_POST['adress']) and is_string($_POST['adress']) and strlen($_POST['adress']) > 0)) {
                $_POST['adress'] = "";
                NoiCore::app()->setNotify("Вы не заполнили поле адрес ");
                \Yii::warning("Вы не заполнили поле адрес", "companys_create");
//                NoiCore::app()->returnback();
//                exit;
                return false;
            }
        } else {
            $_POST['adress'] = "";
        }

        $users = array();

        if (isset($_POST['users']) and is_array($_POST['users']) and count($_POST['users'])) {
            foreach ($_POST['users'] as $user_id) {
                $tmp = CompanyModel::getUser((int) $user_id);
                if (is_array($tmp)) {

                    $users['id_' . $tmp['last_id']] = $tmp;
                }
            }
        }



        if (count($users) == 0) {
//            NoiCore::app()->setNotify("Вы не заполнили блок сотрудники ");
//            \Yii::warning("Вы не заполнили блок сотрудники", "companys_create");
//            //NoiCore::app()->returnback();
//            // exit;
//            return false;
        }







        $array_insert = array();
        $array_insert['date'] = new MongoDate();
        $array_insert['date_update'] = new MongoDate();
        $array_insert['creator'] = $creator;
        $array_insert['name'] = strip_tags($_POST['name']);
        $array_insert['type'] = $_POST['type'];
        $array_insert['inn'] = $_POST['inn'];
        $array_insert['ogrn'] = $_POST['ogrn'];
        $array_insert['kpp'] = strip_tags($_POST['kpp']);
        $array_insert['phone'] = $_POST['phone'];
        $array_insert['adress'] = strip_tags($_POST['adress']);
        $array_insert['users'] = $users;

        NoiCore::app()->db()->insert($array_insert, "companys");
        NoiCore::app()->setNotify("Компания успешно добавлена");
        \Yii::info("Компания успешно добавлена", "companys_create");
        return true;
        // NoiCore::app()->redirect("/companys/index.html");
        // exit;
    }

}
