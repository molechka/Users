<?php

class MyTasksFCP extends CoreFrontendControllerPlugin
{
    public function __construct($route, &$cur)
    {
        parent::__construct("tasks", $cur, $route);
        if (!NoiCore::user()->isLogin()) {
            \tasks\models\NotifyModel::returntologin();
            exit;
        }
    }
    public function actionIndex()
    {
        $user=NoiCore::user()->load();
        $data=array();
        $data['all']=  \tasks\models\TaskModel::getAll();
  //  \tasks\models\TaskModel::doSync();
  if (isset($user['ismanager']) and (int)$user['ismanager']==1) {
      return $this->render("newlist_manager", $data);
  } else {
      return $this->render("newlist", $data);
  }
    }
    public function actionCompletes()
    {
        $user=NoiCore::user()->load();
        $data=array();
        $data['all']=  \tasks\models\TaskModel::getAllCompletes();
  //  \tasks\models\TaskModel::doSync();
    if (isset($user['ismanager']) and (int)$user['ismanager']==1) {
        return $this->render("complete_list_manager", $data);
    } else {
        return $this->render("complete_list", $data);
    }
    }
    public function actionFails()
    {
        $user=NoiCore::user()->load();
        $data=array();
        $data['all']=  \tasks\models\TaskModel::getAllFails();
  //  \tasks\models\TaskModel::doSync();
    if (isset($user['ismanager']) and (int)$user['ismanager']==1) {
        return $this->render("fail_list_manager", $data);
    } else {
        return $this->render("fail_list", $data);
    }
    }
    public function actionShow($last_id)
    {
        $task=\tasks\models\TaskModel::getMy($last_id);
        if (is_array($task)) {
            $data=array();
            $data['task']=$task;
            return $this->render("show_task", $data);
        }
    }
    public function actionComplete($last_id)
    {
        $task=\tasks\models\TaskModel::getMy($last_id);
        if (is_array($task)) {
            \tasks\models\TaskModel::complete($task);
        }
        NoiCore::app()->returnback();
        exit;
    }
    public function actionFail($last_id)
    {
        $task=\tasks\models\TaskModel::getMy($last_id);
        if (is_array($task)) {
            \tasks\models\TaskModel::fail($task);
        }
        NoiCore::app()->returnback();
        exit;
    }
}
