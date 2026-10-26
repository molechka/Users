<?php

use voucher\models\Qualification;
use voucher\models\Voucher;
use user\models\MManager;
use noicms\core\StrInput;

class UsersUserACP extends CoreAdminControllerPlugin {

    public function __construct($site) {
        parent::__construct('user', $site);
    }

    public function actionDelete($id) {
        NoiCore::app()->db()->delete("cms_users", array('last_id' => (int) $id));
        NoiCore::app()->returnback();
        exit;
    }

    public function actionDeleteall($id) {
        NoiCore::app()->db()->delete("cms_users", array(), true);
        NoiCore::app()->returnback();
        exit;
    }

    public function actionManager($id) {
        $user = NoiCore::user()->load((int) $id, "last_id");
        if (isset($user['_id'])) {
            if (isset($user['ismanager']) and $user['ismanager'] == 1) {
                $array_update = array();
                $array_update['ismanager'] = 0;
                NoiCore::app()->db()->update($array_update, "cms_users", array('last_id' => (int) $id));
            } else {
                $array_update = array();
                $array_update['ismanager'] = 1;
                NoiCore::app()->db()->update($array_update, "cms_users", array('last_id' => (int) $id));
            }
        }
        NoiCore::app()->returnback();
        ;
        exit;
    }

    public function actionEdit($id) {
        if (isset($id)) {
            $user = NoiCore::user()->load((int) $id, "last_id");
            if (isset($user['_id'])) {
                $data = array('user' => $user);

                return $this->render("edit", $data);
            }
        }
    }

    public function actionAddmoney($id) {
        if (isset($id) and StrInput::is_Id($id)) {
            $user = NoiCore::user()->load($id);
            if (isset($user['_id'])) {
                if (isset($_POST['comment']) and isset($_POST['type_op']) and ( $_POST['type_op'] == "plus" or $_POST['type_op'] == "minus") and isset($_POST['amount']) and is_numeric($_POST['amount']) and (float) $_POST['amount'] > 0.0) {
                    if ($_POST['type_op'] == "plus") {
                        MManager::plus($user['_id']->__toString(), (float) $_POST['amount'], $_POST['comment'], 1, array('type' => 'payment'));
                        NoiCore::app()->setNotify("Вы успешно подарили пользователю " . $user['login'] . " деньги,ваша доброта просто незнает границ!");
                    } elseif ($_POST['type_op'] == "minus") {
                        $result = MManager::minus($user['_id']->__toString(), (float) $_POST['amount'], $_POST['comment']);
                        if ($result == false) {
                            NoiCore::app()->setNotify("У пользователя " . $user['login'] . " не хватает средств,к сожалению обонкротить его не выходит :(");
                        } else {
                            NoiCore::app()->setNotify("У пользователя " . $user['login'] . " успешно отжаты деньги");
                        }
                    }
                }
            }
        }
        NoiCore::app()->returnback();
    }

    public function actionSetact($id) {
        if (isset($id)) {
            $user = NoiCore::user()->load((int) $id, "last_id");

            if (isset($user['_id'])) {
                $array_update = array();
                $array_update['setac'] = 1;

                NoiCore::app()->db()->update($array_update, "cms_users", array('_id' => $user['_id']));
            }
        }
        NoiCore::app()->returnback();
        exit;
    }

    public function actionEditact($id) {
        if (isset($id) and StrInput::is_Id($id)) {
            $user = NoiCore::user()->load($id);
            if (isset($user['_id'])) {
                $array_update = array();
                if (isset($_POST['name']) and strlen($_POST['name']) > 0) {
                    $array_update['name'] = strip_tags($_POST['name']);
                }

                if (isset($_POST['email']) and filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $_POST['email'] = strtolower($_POST['email']);
                    $count = NoiCore::app()->db()->count("cms_users", array('email' => $_POST['email']));
                    if ($count == 0) {
                        $array_update['email'] = $_POST['email'];
                    }
                }




                if (isset($_POST['user_data']) and is_array($_POST['user_data']) and count($_POST['user_data'])) {
                    foreach ($_POST['user_data'] as $key => $us) {
                        if (isset($us) and strlen($us) > 0) {
                            $array_update[$key] = strip_tags($us);
                        }
                    }
                }

                if (count($array_update) > 0) {
                    NoiCore::user()->update($array_update, $user['_id']->__toString());
                    NoiCore::app()->setNotify("Пользователь успешно обновлен!");
                }
            }
        }
        NoiCore::app()->returnback();
    }

    public function actionIndex() {
        $data = array();
        $condition = array();
        if (isset($_GET['date_registr_start']) and strlen($_GET['date_registr_end']) and strlen($_GET['date_registr_start']) > 1 and strlen($_GET['date_registr_end']) > 1) {
            $start_time = strtotime($_GET['date_registr_start']);
            $end_time = strtotime($_GET['date_registr_end']);
            $condition['date_register'] = array('$gte' => new MongoDate($start_time), '$lte' => new MongoDate($end_time));
        }
        if (isset($_GET['country']) and $_GET['country'] != "not") {
            $condition['country'] = $_GET['country'];
        }
        if (isset($_GET['qual']) and is_numeric($_GET['qual'])) {
            $condition['qualification'] = (int) $_GET['qual'];
        }
        if (isset($_GET['bonus']) and $_GET['bonus'] == "infinity") {
            $condition['$or'] = array(array('infinitybonus' => 1), array('bonus_month' => array('$gt' => 0)));
        } elseif (isset($_GET['bonus']) and $_GET['bonus'] == "bonus") {
            if (!isset($condition['$or'])) {
                $condition['$or'] = array();
            }
            $condition['$or'][] = array('bonus_500' => 1);
            $condition['$or'][] = array('bonus_2000' => 1);
            $condition['$or'][] = array('bonus_2500' => 1);
            $condition['$or'][] = array('bonus_5000' => 1);
        } elseif (isset($_GET['bonus']) and $_GET['bonus'] == 'bonus500') {
            $condition['bonus_500'] = 1;
        } elseif (isset($_GET['bonus']) and $_GET['bonus'] == 'bonus2000') {
            $condition['bonus_2000'] = 1;
        } elseif (isset($_GET['bonus']) and $_GET['bonus'] == 'bonus2500') {
            $condition['bonus_2500'] = 1;
        } elseif (isset($_GET['bonus']) and $_GET['bonus'] == 'bonus5000') {
            $condition['bonus_5000'] = 1;
        }
        if (isset($_GET['type_search']) and $_GET['type_search'] == "lp" and isset($_GET['search_login']) and strlen($_GET['search_login']) > 2) {
            $condition['referal'] = $_GET['search_login'];
        } elseif (isset($_GET['type_search']) and $_GET['type_search'] == "classic" and isset($_GET['search_login']) and strlen($_GET['search_login']) > 2) {
            $condition['referals_list'] = $_GET['search_login'];
        } elseif (isset($_GET['type_search']) and $_GET['type_search'] == "binar" and isset($_GET['search_login']) and strlen($_GET['search_login']) > 2) {
            $condition['binars_list'] = $_GET['search_login'];
        }

        if (isset($_GET['type_user']) and $_GET['type_user'] == "act") {
            $condition['enable_account'] = 1;
            $condition['user_active'] = 1;
        } elseif (isset($_GET['type_user']) and $_GET['type_user'] == "noact") {
            $condition['enable_account'] = 1;
            $condition['user_active'] = 0;
        } elseif (isset($_GET['type_user']) and $_GET['type_user'] == "block") {
            $condition['enable_account'] = 0;
        }

        if (isset($_GET['isveryfication']) and $_GET['isveryfication'] == "yes") {
            $condition['setac'] = 1;
        }
        if (isset($_GET['isveryfication']) and $_GET['isveryfication'] == "no") {
            $condition['setac'] = array('$ne' => 1);
        }
        if (isset($_GET['id_or_login']) and strlen($_GET['id_or_login']) > 1) {
            if (is_numeric($_GET['id_or_login'])) {
                $condition['last_id'] = (int) $_GET['id_or_login'];
            } else {
                $condition['login'] = $_GET['id_or_login'];
            }
        }
        $data['filter_email'] = "";
        if (isset($_GET['email']) and is_string($_GET['email'])
                and filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $data['filter_email'] = $_GET['email'];
            $condition['email'] = strtolower($_GET['email']);
        }


        $data['rows'] = NoiCore::app()->db()->query(array(), "cms_users", $condition, array('_id' => -1), 25, NoiCore::c("ppaginator")->getOffset(25));
        $data['count'] = NoiCore::app()->db()->count("cms_users", $condition);
        $data['pages'] = NoiCore::c('ppaginator')->show($data['count'], 25);

        return $this->render("index", $data, 1);
    }

}
