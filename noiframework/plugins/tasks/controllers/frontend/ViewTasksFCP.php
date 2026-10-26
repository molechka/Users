<?php

class ViewTasksFCP extends CoreFrontendControllerPlugin
{
    public function __construct($route, &$cur)
    {
        parent::__construct("tasks", $cur, $route);

         //\tasks\models\TaskModel::doSync();
    }
    public function actionIndex($last_id)
    {
        $task=  \tasks\models\TaskModel::getGuest($last_id);
        if (is_array($task)) {
            $data=array();
            $data['task']=$task;
            return $this->render("task", $data);
        }
    }
}
