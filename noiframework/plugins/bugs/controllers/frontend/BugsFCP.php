<?php

class BugsFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("bugs", $cur, $route);
    }

    public function renderForm() {
        $data = array();
        return $this->render("form", $data);
    }

    public function renderFile() {
        if (NoiCore::user()->isLogin()) {
            $data = array();
            return $this->render("file", $data);
        }
    }

    public function actionOld() {
        echo $this->render("old");
        exit;
    }

}
