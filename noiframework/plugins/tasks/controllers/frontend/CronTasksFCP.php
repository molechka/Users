<?php

class CronTasksFCP extends CoreFrontendControllerPlugin
{
    public function __construct($route, &$cur)
    {
        parent::__construct("tasks", $cur, $route);
        if (!NoiCore::user()->isLogin()) {
            \tasks\models\NotifyModel::returntologin();
            exit;
        }
    }
    public function actionDel($last_id, $key)
    {
        if (!is_numeric($key)) {
            $key=0;
        }
        $result=  tasks\models\TaskModel::get($last_id);
        \tasks\models\TaskModel::delCron($result, $key);

        NoiCore::app()->returnback();
        exit;
    }
    public function actionEdit($last_id, $key)
    {
        if (!is_numeric($key)) {
            $key=0;
        }
        $result=  tasks\models\TaskModel::get($last_id);
        if (isset($result['_id']) and isset($result['cron'][$key])) {
            $data=array();
            $data['row']=$result['cron'][$key];
            $data['result']=$result;

            $data['format']=explode(" ", $result['cron'][$key]['format']);
            $data['link']=$last_id."/".$key;

            return $this->render("edit", $data);
        }
    }
    public function actionDoupdate($last_id, $key)
    {
        if (!is_numeric($key)) {
            $key=0;
        }
        $result=  tasks\models\TaskModel::get($last_id);
        if (isset($result['_id']) and isset($result['cron'][$key])) {
            \tasks\models\TaskModel::doUpdate($result, $key);
        }
        exit;
    }
}
