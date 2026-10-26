<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserFCP
 *
 * @author backdoor
 */
class UserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("user", $cur, $route);
    }

    public function actionLogout() {

        Yii::$app->session->removeAll();
        $session_id = Yii::$app->session->getId();

        Yii::$app->session->destroySession($session_id);
        Yii::$app->session->regenerateID();
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('misterti');
//      NoiCore::app()->setSession("user_auth",0);
//      NoiCore::app()->setSession("user_result",array());
//      NoiCore::app()->removeSession("user_id");
//      NoiCore::app()->removeSession("user_result");

        NoiCore::app()->redirect("/");
        exit;
    }

    public function actionStatus() {
        $this->iswidget = 0;
        return $this->render("status_widget");
    }

    public function actionAvatar($last_id) {
        $user = null;
        $users = NoiCore::app()->db()->query(array(), "cms_users", array("last_id" => (int) $last_id));
        if (isset($users[0]['last_id'])) {
            $user = $users[0];
        }

        if (is_array($user)) {
            header("Location: " . $user['avatar']);
            die();
        }
    }

}
