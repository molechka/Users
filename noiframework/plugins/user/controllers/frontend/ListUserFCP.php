<?php

use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use noicms\mongogrid\OneField;
use noicms\mongogrid\system_core\MGQuery;

class ListUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("user", $cur, $route);
        if (!NoiCore::user()->isLogin()) {
            return false;
        }
    }

    public function getForumMessages($user) {
        $db = MGQuery::getCollection('forum_themes');
        $result = $db->aggregate(array(array('$unwind' => '$messages'), array('$match' => array("messages.user._id" => $user['_id'])), array('$group' => array(
                    '_id' => '$messages.user._id',
                    'total' => array('$sum' => array('$multiply' => array('$messages.user.last_id'))),
                    'count' => array('$sum' => 1)
                )))
        );
        $count = 0;
        if (isset($result[0]['total'])) {
            $count = $result[0]['total'];
        }
        return $count;
    }

    public function actionProfile($id_user) {
        if (isset($id_user) and is_numeric($id_user)) {
            $main = $this->get_value();

            if (isset($main[0]['status_list']) and $main[0]['status_list'] == 1) {
                $collection = "";
                if (isset($main[0]['collection'])) {
                    $collection = $main[0]['collection'];
                }
                $user_load = $this->db()->query(array(), $collection, array('last_id' => (int) $id_user));

                if (isset($user_load[0]['_id'])) {
                    $this->setTitle("Участники " . $user_load[0]['name']);
                    $user_load[0]['posts'] = $this->db()->query(array(), "blogs_post", array('user._id' => $user_load[0]['_id']));

                    return $this->render('view_profile', array('user' => $user_load[0]));
                }
            }
        }
    }

    public function actionIndex($type = 0) {
        NoiCore::app()->setParam("type", "users");
        $this->setTitle(NoiCore::lang()->t('users'));
        $condition_users = array();
        $condition_users['$or'] = array();
        $condition_users['$or'][] = array('referals_list' => NoiCore::user()->getLogged("login"));
        $condition_users['$or'][] = array('binars_list' => NoiCore::user()->getLogged("login"));
        if (isset($_GET['islp']) and $_GET['islp'] == "all") {
            $condition_users['referal'] = NoiCore::user()->getLogged("login");
        }
        if (isset($_GET['islp']) and $_GET['islp'] == "onlyact") {
            $condition_users['referal'] = NoiCore::user()->getLogged("login");
            $condition_users['user_active'] = 1;
        }
        if (isset($_GET['islp']) and $_GET['islp'] == "onlynoact") {
            $condition_users['referal'] = NoiCore::user()->getLogged("login");
            $condition_users['user_active'] = array('$ne' => 1);
        }
        if (isset($_GET['country']) and is_string($_GET['country']) and $_GET['country'] != "not") {
            $condition_users['country'] = $_GET['country'];
        }
        if (isset($_GET['id_or_login'])) {
            if (is_numeric($_GET['id_or_login'])) {

                $condition_users['last_id'] = (int) $_GET['id_or_login'];
            } else {
                if (strlen($_GET['id_or_login']) > 2) {
                    $condition_users['login'] = $_GET['id_or_login'];
                }
            }
        }
        if (isset($_GET['status_user']) and $_GET['status_user'] == "act") {
            $condition_users['user_active'] = 1;
        }
        if (isset($_GET['status_user']) and $_GET['status_user'] == "noact") {
            $condition_users['user_active'] = array('$ne' => 1);
        }
        if (isset($_GET['status_user']) and $_GET['status_user'] == "block") {
            $condition_users['enable_account'] = 0;
        }
        $condition_users['blocked'] = array('$ne' => 1);

        $sort_users = array('_id' => -1);
        $sort_users = array('date_register' => -1, 'date_last_buy' => -1);
        if (isset($type) and $type == "reg") {
            $sort_users['date_register'] = 1;
            unset($sort_users['date_last_buy']);
        } else if (isset($type) and $type == "buy") {
            $sort_users['date_last_buy'] = 1;
            unset($sort_users['date_register']);
        } else if (isset($type) and $type == 'buy2') {
            $sort_users['date_last_buy'] = -1;
            unset($sort_users['date_register']);
        } else if (isset($type) and $type == 'reg2') {
            $sort_users['date_register'] = -1;
            unset($sort_users['date_last_buy']);
        }
        $data = array();
        $data['users'] = NoiCore::app()->db()->query(array(), "cms_users", $condition_users, $sort_users, 50, NoiCore::c("ppaginator")->getOffset(50));
        $data['count'] = NoiCore::app()->db()->count("cms_users", $condition_users);
        $data['pages'] = NoiCore::c("ppaginator")->show($data['count'], 50);
        if ($type == "reg") {
            $data['reg_link'] = "/user/list/index/reg2.html";
            $data['reg_btn'] = "fa-arrow-down";
            $data['buy_link'] = "/user/list/index/buy.html";
            $data['buy_btn'] = "fa-arrow-up";
        } else if ($type == "reg2") {
            $data['reg_link'] = "/user/list/index/reg.html";
            $data['reg_btn'] = "fa-arrow-up";
            $data['buy_link'] = "/user/list/index/buy.html";
            $data['buy_btn'] = "fa-arrow-up";
        } else if ($type == "buy") {
            $data['reg_link'] = "/user/list/index/reg.html";
            $data['reg_btn'] = "fa-arrow-up";
            $data['buy_link'] = "/user/list/index/buy2.html";
            $data['buy_btn'] = "fa-arrow-down";
        } else if ($type == "buy2") {
            $data['reg_link'] = "/user/list/index/reg.html";
            $data['reg_btn'] = "fa-arrow-up";
            $data['buy_link'] = "/user/list/index/buy";
            $data['buy_btn'] = "fa-arrow-up";
        } else {
            $data['reg_link'] = "/user/list/index/reg.html";
            $data['reg_btn'] = "fa-arrow-up";
            $data['buy_link'] = "/user/list/index/buy.html";
            $data['buy_btn'] = "fa-arrow-up";
        }


        return $this->render("standart_list", $data);
    }

}
