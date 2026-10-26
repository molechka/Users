<?php


class NotifyTasksFCP extends CoreFrontendControllerPlugin
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
        $data=array();
        $user=NoiCore::user()->load();
        if (isset($user['ismanager']) and (int)$user['ismanager']==1) {
            return $this->managerIndex();
        }
        $condition=array();
        $condition['user._id']=$user['_id'];
        $condition['read']=array('$ne'=>1);
        $data['all']=NoiCore::app()->db()->query2(array(), "notify_list", $condition);
        return $this->render("list", $data);
    }

    public function managerIndex()
    {
        $data=array();
        $user=NoiCore::user()->load();

        $condition=array();
        $condition['read']=array('$ne'=>1);
        if (isset($_GET['q']) and is_string($_GET['q'])) {
            $_GET['q']=strip_tags($_GET['q']);
            if (filter_var($_GET['q'], FILTER_VALIDATE_EMAIL)) {
                $condition['user.email']=strtolower($_GET['q']);
            } else {
                $condition['user.email']=array('$options'=>'i','$regex' => $_GET['q']);
            }
        }
        if (isset($_GET['date_start']) and is_string($_GET['date_start']) and  (bool)strtotime($_GET['date_start'])) {
            $time=  strtotime($_GET['date_start']);

            if (!isset($condition['date'])) {
                $condition['date']=array();
            }
            $condition['date']['$gte']=new MongoDate($time);
        }

        if (isset($_GET['date_end']) and is_string($_GET['date_end']) and  (bool)strtotime($_GET['date_end'])) {
            $time=  strtotime($_GET['date_end']);

            if (!isset($condition['date'])) {
                $condition['date']=array();
            }
            $condition['date']['$lte']=new MongoDate($time);
        }
        $sort=array('_id'=>-1);
        if (isset($_GET['sort_type']) and ($_GET['sort_type']=="asc" or $_GET['sort_type']=="desc") and isset($_GET['sort_field']) and is_string($_GET['sort_field'])) {
            $sort=array(strip_tags($_GET['sort_field'])=>-1);
            if ($_GET['sort_type']=="asc") {
                $sort=array(strip_tags($_GET['sort_field'])=>1);
            }
        }

        $data['all']=NoiCore::app()->db()->query2(array(), "notify_list", $condition, $sort);
        return $this->render("list_manager", $data);
    }
}
