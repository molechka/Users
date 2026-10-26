<?php

class TasksFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("tasks", $cur, $route);
        if (!NoiCore::user()->isLogin()) {
            \tasks\models\NotifyModel::returntologin();
            exit;
        }
        //\tasks\models\TaskModel::doSync();
    }

    public function actionIndex() {
        $user = NoiCore::user()->load();
        $data = array();
        $condition = array('creator._id' => $user['_id']);
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            $condition = array();
        }



        $condition['complete'] = array('$ne' => 1);
        $condition['fail'] = array('$ne' => 1);
        $data['rows'] = NoiCore::app()->db()->query(array(), "tasks", $condition, array('_id' => -1), 20, NoiCore::c("ppaginator")->getOffset(20));
        $data['count'] = NoiCore::app()->db()->count("tasks", $condition);
        $data['pages'] = NoiCore::c("ppaginator")->show($data['count'], 20);
        return $this->render("list", $data);
    }

    public function actionEdit($last_id) {
        $user = NoiCore::user()->load();
        $result = tasks\models\TaskModel::get($last_id);
        if (is_array($result)) {
            $data = array();
            $data['task'] = $result;
            $data['users'] = NoiCore::app()->db()->query2(array(), "cms_users", array());

            return $this->render("edit", $data);
        }
    }

    public function actionCron($last_id) {
        $user = NoiCore::user()->load();
        $result = tasks\models\TaskModel::get($last_id);
        if (is_array($result)) {
            $data = array();
            $data['task'] = $result;

            return $this->render("cron", $data);
        }
    }

    public function actionDocron($last_id) {
        $user = NoiCore::user()->load();
        $result = tasks\models\TaskModel::get($last_id);
        if (is_array($result)) {
            tasks\models\TaskModel::doCron($result);
        }
        exit;
    }

    public function actionDoedit($last_id) {
        $user = NoiCore::user()->load();
        $result = tasks\models\TaskModel::get($last_id);
        if (is_array($result)) {
            tasks\models\TaskModel::doEdit($result);
        }
        exit;
    }

    public function actionDelete($last_id) {
        $user = NoiCore::user()->load();
        $newtask = tasks\models\TaskModel::get2($last_id);
        tasks\models\NotifyModel::doAdd($newtask, "Пользователь " . $user['email'] . " удалил задачу ", $newtask['creator']);
        $condition = array('creator._id' => $user['_id']);
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            $condition = array();
        }
        $condition['last_id'] = (int) $last_id;
        NoiCore::app()->db()->delete("tasks", $condition);
        \Yii::info("Задача успешно удалена", "task_delete");
        NoiCore::app()->returnback();
        exit;
    }

    public function actionAdd() {
        $user = NoiCore::user()->load();
        $data = array();
        $data['my'] = $user;
        $data['users'] = NoiCore::app()->db()->query2(array(), "cms_users", array());

        $result = $this->render("add", $data);

        return $result;
    }

    public function actionDo() {
        tasks\models\TaskModel::doAdd();
        exit;
    }

}
