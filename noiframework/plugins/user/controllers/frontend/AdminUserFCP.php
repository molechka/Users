<?php

use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use noicms\mongogrid\OneField;
use noicms\core\StrInput;

class AdminUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("user", $cur, $route);
    }

    public function actionView($id_user) {
        $myuser = NoiCore::user()->load();

        $condition = array("last_id" => (int) $id_user);

        if (isset($id_user) and StrInput::is_Id($id_user)) {
            $condition = array('_id' => new MongoId($id_user));
        }
        $main = $this->get_value();
        $fields_array = $this->get_value('fields');
        if (isset($main[0]['collection']) and strlen($main[0]['collection']) > 3) {
            $this->name_collection = $main[0]['collection'];
        }
        $result = $this->db()->query(array(), $this->name_collection, $condition);

        $password_field = $this->getPassword();
        if (isset($password_field) and is_array($password_field) and isset($password_field['name']) and isset($password_field['type'])) {
            $tmp_obj = new OneField();
            $opt = array();
            if (isset($password_field['opt']) and is_array($password_field['opt'])) {
                $opt = $password_field['opt'];
            }
            $tmp_obj->init($password_field['name'], $password_field['type'], $opt);
            $password_field['obj'] = $tmp_obj;
            if (isset($_POST['act_changepw'])) {
                $tmp_new_result = $tmp_obj->setInput();
                if ($tmp_new_result === false) {
                    
                } else {
                    $array_update['password'] = $tmp_new_result;
                    $this->db()->update($array_update, $this->name_collection, array('_id' => new MongoId($id_user)));
                }
            }
        }
        if (isset($result[0]['_id'])) {
            if (NoiCore::user()->isLogin()) {
                \Yii::info("Пользователь с email " . $myuser['email'] . " смотрит пользователя с " . $result[0]['email'], "users_see");
            } else {
                \Yii::info("Гость  смотрит пользователя с " . $result[0]['email'], "users_see");
            }
            $data = array('user' => $result[0], 'password_field' => $password_field);
            $data['all'] = \tasks\models\TaskModel::getAll($result[0]);

            $data['companys'] = companys\models\CompanyModel::all($result[0]);

            return $this->render("view_user", $data);
        }
    }

    public function createUser() {
        if (!NoiCore::user()->isLogin()) {
            exit;
        }
        $main = $this->get_value();
        $fields_array = $this->get_value('fields');
        if (isset($main[0]['collection']) and strlen($main[0]['collection']) > 3) {
            $this->name_collection = $main[0]['collection'];
        }
        $field_mg = array();
        $field_list = array();
        $is_create = 0;
        if (isset($_POST['act_create'])) {
            $is_create = 1;
        }
        $array_insert = array();
        $complete = 0;
        $result_parse = 3;
        $roles = $this->getRoles();
        if (isset($_POST['dog']) and is_string($_POST['dog']) and strlen($_POST['dog']) > 8) {

            $result_parse = 0;
            NoiCore::app()->setNotify("Поле Собака   максимальная длина 8");
            \Yii::warning("Поле Собака максимальная длина 8", "users_create");
        }

        if (isset($_POST['noibiz_parrot']) and is_string($_POST['noibiz_parrot']) and strlen($_POST['noibiz_parrot']) > 30) {

            $result_parse = 0;
            NoiCore::app()->setNotify("Поле Попугай   максимальная длина 20");
            \Yii::warning("Поле Попугай максимальная длина 20", "users_create");
        }
        if (isset($_POST['noibiz_cavy']) and is_string($_POST['noibiz_cavy']) and strlen($_POST['noibiz_cavy']) > 30) {

            $result_parse = 0;
            NoiCore::app()->setNotify("Поле Морская свинка   максимальная длина 20");
            \Yii::warning("Поле Морская свинка  максимальная длина 20", "users_create");
        }

        if (isset($_POST['noibiz_hamster']) and is_string($_POST['noibiz_hamster']) and strlen($_POST['noibiz_hamster']) > 30) {

            $result_parse = 0;
            NoiCore::app()->setNotify("Поле Хомячок   максимальная длина 20");
            \Yii::warning("Поле Хомячок  максимальная длина 20", "users_create");
        }

        if (isset($_POST['noibiz_squirrel']) and is_string($_POST['noibiz_squirrel']) and strlen($_POST['noibiz_squirrel']) > 30) {

            $result_parse = 0;
            NoiCore::app()->setNotify("Поле Белочка   максимальная длина 30");
            \Yii::warning("Поле Белочка  максимальная длина 30", "users_create");
        }

        if (isset($fields_array) and count($fields_array) > 0) {
            foreach ($fields_array as $field) {
                if (isset($field['type']) and isset($field['name'])) {
                    $tmp_obj = new OneField();
                    $opt = array();

                    if (isset($field['opt'])) {
                        $opt = json_decode($field['opt'], true);
                    }
                    if (!is_Array($opt)) {
                        $opt = array();
                    }

                    $tmp_obj->init($field['name'], $field['type'], $opt);
                    $field_mg[] = array('obj' => $tmp_obj, 'field' => $field);

                    if ($is_create == 1 and ( $result_parse == 1 or $result_parse == 3)) {
                        $tmp_result = $tmp_obj->setInput();

                        if ($tmp_result === false) {
                            if (isset($field['default_status']) and $field['default_status'] == 1 and isset($field['default'])) {
                                $array_insert[$field['name']] = $field['default'];
                                $result_parse = 1;
                            } else {
                                if (isset($field['required']) and $field['required'] == 1) {
                                    $result_parse = 0;
                                    NoiCore::app()->setNotify("Поле " . $field['name'] . " является обязательным");
                                    \Yii::warning("Поле " . $field['name'] . " является обязательным", "users_create");
                                } else {
                                    $array_insert[$field['name']] = "";
                                    $result_parse = 1;
                                }
                            }
                        } else {
                            $array_insert[$field['name']] = $tmp_result;
                            $result_parse = 1;
                        }
                        if (isset($field['unique']) and $result_parse == 1 and $field['unique'] == 1 and isset($array_insert[$field['name']])) {
                            $count = $this->db()->count($this->name_collection, array($field['name'] => $array_insert[$field['name']]));



                            if ($count == 1) {
                                $result_parse = 0;
                                NoiCore::app()->setNotify("Поле " . $field['name'] . " уже есть в БД!");
                                \Yii::warning("Поле " . $field['name'] . " уже есть в БД!", "users_create");
                            }
                        }
                    }
                }
            }
        }

        if ($result_parse == 1) {
            $array_insert['blocked'] = 0;
            $array_insert['role'] = array('user');
            $user = NoiCore::user()->load();
            $array_insert['by_user'] = $user;
            $array_insert["enable_account"] = 1;
            $array_insert['date_updated'] = new MongoDate();
            $this->db()->insert($array_insert, $this->name_collection);
            $this->redirect($this->getRoute('admin/index'));
            \Yii::info("Пользователь с email " . $array_insert['email'] . " успешно создан", "users_create");
        }
        return $this->render("create_user", array('fields' => $field_mg, 'error' => $result_parse));
    }

    public function actionIndex($current_op = "list") {


        if (NoiCore::user()->isLogin()) {
            $user = NoiCore::user()->load();
        } else {
            $user = array();
        }
        if (isset($current_op) and $current_op == "create") {
            return $this->createUser();
        }
        $main = $this->get_value();
        $fields_array = $this->get_value('fields');
        if (isset($main[0]['collection']) and strlen($main[0]['collection']) > 3) {
            $this->name_collection = $main[0]['collection'];
        }
        $site = $this->site_data;
        $url_list = $this->getRoute('admin/index');
        $array_query = array();
        if (isset($_GET['q']) and is_string($_GET['q'])) {
            $array_query['q'] = strip_tags($_GET['q']);
        }
        if (isset($_GET['date_start']) and is_string($_GET['date_start'])) {
            $array_query['date_start'] = strip_tags($_GET['date_start']);
        }
        if (isset($_GET['date_end']) and is_string($_GET['date_end'])) {
            $array_query['date_end'] = strip_tags($_GET['date_end']);
        }
        if (isset($_GET['sort_type']) and ( $_GET['sort_type'] == "asc" or $_GET['sort_type'] == "desc")) {
            $array_query['sort_type'] = strip_tags($_GET['sort_type']);
        }
        if (isset($_GET['sort_field']) and is_string($_GET['sort_field'])) {
            $array_query['sort_field'] = strip_tags($_GET['sort_field']);
        }
        if (count($array_query)) {
            $url_list = $url_list . "?" . http_build_query($array_query);
        }

        $grid = new MongoGrid($main[0]['collection'], 10, 0, "asd", 'Manage Users', $url_list);
        $grid->sort = array('date_updated' => -1);
        $condition = array();
        if (!\user\models\UserAccount::isManager()) {
            //  $condition['by_user.last_id'] = $user['last_id'];
        }
        if (isset($_GET['q']) and is_string($_GET['q'])) {
            $_GET['q'] = strip_tags($_GET['q']);

            $condition['$or'] = array();
            $condition['$or'][] = array('name' => array('$options' => 'i', '$regex' => $_GET['q']));
            $condition['$or'][] = array('email' => array('$options' => 'i', '$regex' => $_GET['q']));
            $condition['$or'][] = array('email' => strtolower($_GET['q']));
            $condition['$or'][] = array('name' => $_GET['q']);
            $condition['$or'][] = array('by_user.email' => array('$options' => 'i', '$regex' => $_GET['q']));
        }
        if (isset($_GET['date_start']) and is_string($_GET['date_start']) and (bool) strtotime($_GET['date_start'])) {
            $time = strtotime($_GET['date_start']);

            if (!isset($condition['date_updated'])) {
                $condition['date_updated'] = array();
            }
            $condition['date_updated']['$gte'] = new MongoDate($time);
        }

        if (isset($_GET['date_end']) and is_string($_GET['date_end']) and (bool) strtotime($_GET['date_end'])) {
            $time = strtotime($_GET['date_end']);

            if (!isset($condition['date_updated'])) {
                $condition['date_updated'] = array();
            }
            $condition['date_updated']['$lte'] = new MongoDate($time);
        }

        if (isset($_GET['sort_type']) and ( $_GET['sort_type'] == "asc" or $_GET['sort_type'] == "desc") and isset($_GET['sort_field']) and is_string($_GET['sort_field'])) {
            $sort = array();
            $_GET['sort_field'] = strip_tags($_GET['sort_field']);
            if ($_GET['sort_type'] == "asc") {
                $sort = array($_GET['sort_field'] => 1);
            } else {
                $sort = array($_GET['sort_field'] => -1);
            }
            $grid->sort = $sort;
        }

        $grid->condition = $condition;
        $fields = new GridField();
        $list_fields = $this->generateFields("list");

        $roles = $this->getRoles();


        $fields->setFields($list_fields);

        if (isset($fields_array) and count($fields_array) > 0) {
            foreach ($fields_array as $field) {
                if (isset($field['type']) and isset($field['name']) and isset($field['is_password']) and $field['is_password'] != 1) {
                    $required = false;
                    $unique = false;
                    $label = $field['name'];
                    if (isset($field['label'])) {
                        $label = $field['label'];
                    }
                    if (isset($field['required']) and $field['required'] == 1) {
                        $required = true;
                    }
                    if (isset($field['unique']) and $field['unique'] == 1) {
                        $unique = true;
                    }
                    $default_value = "";
                    if (isset($field['default_status']) and $field['default_status'] == 1 and isset($field['default']) and strlen($field['default']) > 1) {
                        $default_value = $field['default'];
                    }

                    $opt = array();
                    if (isset($field['opt'])) {
                        $opt = json_decode($field['opt'], true);
                    }
                    if (!is_Array($opt)) {
                        $opt = array();
                    }

                    $fields->setField($field['name'], $field['type'], $default_value, $opt, $label, $required, $unique);
                }
            }
        }
        $blocked_array = array(
            array('value' => '0', 'title' => 'No Blocked'),
            array('value' => '1', 'title' => 'Yes Blocked'),
        );
        $fields->setField("blocked", "select", '0', $blocked_array, 'Is Blocked?', true, false);
        $fields->setField("date_updated", "hidden", new MongoDate(), array(), 'date_updated', true, false);

        $fields->setField("site_id", "hidden", $this->site_data['_id']->__toString(), array(), 'site_id', true, false);
        $fields->setField("role", "multiselect", "", array('data' => $roles), 'Role User', true, false);

        $login_field = $this->getLogin();
        if (isset($list_fields) and count($list_fields) > 0) {
            foreach ($list_fields as $nf) {
                if ($nf != $login_field) {
                    $fields->not_show[$nf]['list'] = 1;
                }
            }
        }
//      $fields->not_show['site_id']['list']=1;
//      $fields->not_show['full']['list']=1;
//      $fields->not_show['anonce']['list']=1;
//      $fields->not_show['entry_date']['list']=1;
        $fields->showid = false;
        $grid->setFields($fields);
//
        // $grid->condition['by_user._id']=$user['_id'];
        $operation = new GridOperation();
        $denied_access = array();
        $roles = \user\models\UserAccount::getRoles();

        $available_access = array('list', 'update', 'delete');
        $ismanager = \user\models\UserAccount::isManager();
        if ($ismanager) {
            $available_access = array('list', 'update', 'delete');
        }




        $operation->denied_access = $denied_access;
        $operation->available = $available_access;
        $operation->default_operation = 'list';
        $grid->setOperations($operation);

        $grid->view->available['list'] = $this->render("standart_list", array(), 1);
        $grid->view->available['update'] = $this->render("standart_update", array(), 1);
        $grid->view->available['create'] = $this->render('standart_create', array(), 1);
        $grid->view->options['controller'] = $this;
        $newdata = array('site' => $site);


        $result = $grid->render();
        if (isset($_GET['path_grid_asd'])) {
            $tmp = str_replace("/delete/", "", $_GET['path_grid_asd']);
            if ($tmp != $_GET['path_grid_asd']) {

                NoiCore::app()->returnback();
            }
        }

        return $result;
    }

    public function generateFields($op = "list") {
        if (isset($op) and ( $op == "list" or $op == "array")) {
            $fields = $this->get_value('fields');
            if ($op == "list") {
                if (count($fields) > 0) {
                    $result_array = array();
                    $result_array[] = "date_updated";

                    foreach ($fields as $field) {
                        if (isset($field['name']) and isset($field['is_password']) and $field['is_password'] != 1) {
                            $result_array[] = $field['name'];
                        }
                    }

                    return $result_array;
                } else {
                    return array();
                }
            }
        } else {
            return array();
        }
    }

    public function getRoles() {
        $value = $this->get_value('roles');
        $result_array = array();
        if (isset($value) and count($value) > 0) {
            foreach ($value as $val) {
                if (isset($val['name'])) {
                    $result_array[] = array('title' => $val['name'], 'value' => $val['name']);
                }
            }
        }
        return $result_array;
    }

    public function getLogin() {
        $fields = $this->get_value('fields');
        $result_field = "";
        if (count($fields) > 0) {
            $result_array = array();
            foreach ($fields as $field) {
                if (isset($field['is_login']) and $field['is_login'] == 1 and $field['is_password'] != 1) {
                    $result_field = $field['name'];
                }
            }
            if ($result_field == "") {
                if (isset($fields[0]['name'])) {
                    $result_field = $fields[0]['name'];
                }
            }
            return $result_field;
        }
    }

    public function getPassword() {
        $fields = $this->get_value('fields');
        $result_field = "";
        if (count($fields) > 0) {
            $result_array = array();
            foreach ($fields as $field) {
                if (isset($field['is_password']) and $field['is_password'] == 1) {
                    return $field;
                    break;
                }
            }
        }
    }

}
