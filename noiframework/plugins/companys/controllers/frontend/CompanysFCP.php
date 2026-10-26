<?php

class CompanysFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("companys", $cur, $route);
        if (!NoiCore::user()->isLogin()) {
            \tasks\models\NotifyModel::returntologin();
            exit;
        }
        //\tasks\models\TaskModel::doSync();
    }

    public function actionIndex() {
        $user = NoiCore::user()->load();
        $data = array();
        $data['user'] = $user;
        $data['ismanager'] = false;
        $condition = array();
        //  $condition = array('creator._id' => $user['_id']);
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            $data['ismanager'] = true;
        }


        $data['rows'] = NoiCore::app()->db()->query(array(), "companys", $condition, array('_id' => -1), 20, NoiCore::c("ppaginator")->getOffset(20));
        $data['count'] = NoiCore::app()->db()->count("companys", $condition);
        $data['pages'] = NoiCore::c("ppaginator")->show($data['count'], 20);
        return $this->render("list", $data);
    }

    public function actionAdd() {
        $user = NoiCore::user()->load();
        $data = array();
        $data['my'] = $user;
        $data['users'] = NoiCore::app()->db()->query2(array(), "cms_users", array());

        $result = $this->render("add", $data);

        return $result;
    }

    public function actionView($last_id) {
        $company = \companys\models\CompanyModel::get((int) $last_id, true);

        if (is_array($company)) {
            $data = array();
            $data['company'] = $company;

            return $this->render("view", $data);
        }
    }

    public function actionEdit($last_id) {
        $company = \companys\models\CompanyModel::get((int) $last_id);
        if (is_array($company)) {
            $user = NoiCore::user()->load();
            $data = array();
            $data['my'] = $user;
            $data['users'] = NoiCore::app()->db()->query2(array(), "cms_users", array());
            $data['company'] = $company;
            $result = $this->render("edit", $data);
        }

        return $result;
    }

    public function actionDoedit($last_id) {
        $company = \companys\models\CompanyModel::get((int) $last_id);
        if (is_array($company)) {
            $result = companys\models\CompanyModel::update($company);

            $type = "error";
            $link = null;
            if (!$result) {
                $type = "error";
                $notifys = NoiCore::notify()->getAll();
                if (isset($notifys)) {

                    foreach ($notifys as $key => $message) {
                        
                    }
                }
            } else {
                $type = "success";
                $link = "/companys/index.html";
            }

            $json = array("type" => $type, 'message' => $message);
            if (!is_null($link)) {
                $json['link'] = $link;
            }
            echo json_encode($json);
            exit;
        }
        exit;
    }

    public function actionDo() {
        $result = companys\models\CompanyModel::add();

        $type = "error";
        $link = null;
        if (!$result) {
            $type = "error";
        } else {
            $type = "success";
            $link = "/companys/index.html";
        }

        $notifys = NoiCore::notify()->getAll();
        if (isset($notifys)) {

            foreach ($notifys as $key => $message) {
                
            }
        }

        $json = array("type" => $type, 'message' => $message);
        if (!is_null($link)) {
            $json['link'] = $link;
        }
        echo json_encode($json);
        exit;
    }

    public function actionDelete($last_id) {
        $user = NoiCore::user()->load();

        $condition = array('creator._id' => $user['_id']);
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            $condition = array();
        }
        $condition['last_id'] = (int) $last_id;
        NoiCore::app()->db()->delete("companys", $condition);
        \Yii::info("Компания успешно удалена", "company_delete");
        NoiCore::app()->returnback();
        exit;
    }

}
