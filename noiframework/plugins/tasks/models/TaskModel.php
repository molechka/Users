<?php

namespace tasks\models;

use MongoDate;
use NoiCore;

class TaskModel {

    public static function complete($task) {
        $rows = $task;
        if (!isset($rows['cron'])) {
            $rows['cron'] = array();
        }
        $array_update = array('cron' => $rows['cron']);
        $array_update['notnotify'] = 0;
        $array_update['notrightnow2'] = 0;
        $array_update['not5'] = 0;
        $nofail = false;
        if (count($array_update['cron'])) {
            foreach ($array_update['cron'] as $kk => $cr) {
                if (time() > $cr['time']->sec) {
                    $nofail = true;
                }
                //  if (time()>$cr['time']->sec) {
                $cron = \Cron\CronExpression::factory($cr['format']);
                $newtime = $cron->getNextRunDate(date('Y-m-d H:i:s', $cr['time']->sec))->getTimestamp();
                $array_update['cron'][$kk]['time'] = new MongoDate($newtime);
                \Yii::info("Задача успешно запущена,следущая дата запуска " . date('Y-m-d H:i:s', $newtime), "cron_delete");
                //  }
            }
        }
        \Yii::info("Пользователь " . $task['user']['email'] . " подтвердил, что сделал задачу (" . $task['name'] . ")", "task_complete");
        NotifyModel::doAdd($task, "Пользователь " . $task['user']['email'] . " подтвердил, что продолбал задачу");
        if ($task['creator']['_id']->__toString() != $task['user']['_id']->__toString()) {
            NotifyModel::doAdd($task, "Пользователь " . $task['user']['email'] . " подтвердил, что продолбал задачу", $task['creator']);
        }
        if (count($array_update['cron']) == 0) {
            $array_update['complete'] = 1;
        } else {
            $newtask = $task;
            unset($newtask['_id']);
            unset($newtask['last_id']);
            $newtask['complete'] = 1;
            $newtask['date'] = new MongoDate();
            NOiCore::app()->db()->insert($newtask, "tasks");
        }
        NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $rows['last_id']));
    }

    public static function fail($task) {
        $rows = $task;
        if (!isset($rows['cron'])) {
            $rows['cron'] = array();
        }
        $array_update = array('cron' => $rows['cron']);
        $array_update['notnotify'] = 0;
        $array_update['notrightnow2'] = 0;
        $array_update['not5'] = 0;

        $nofail = false;
        if (count($array_update['cron'])) {
            foreach ($array_update['cron'] as $kk => $cr) {
                if (time() > $cr['time']->sec) {
                    $nofail = true;
                }

                $cron = \Cron\CronExpression::factory($cr['format']);
                $newtime = $cron->getNextRunDate(date('Y-m-d H:i:s', $cr['time']->sec))->getTimestamp();

                $array_update['cron'][$kk]['time'] = new MongoDate($newtime);
                \Yii::info("Задача успешно запущена,следущая дата запуска " . date('Y-m-d H:i:s', $newtime), "cron_delete");
            }
        }
        \Yii::info("Пользователь " . $task['user']['email'] . " подтвердил, что продолбал задачу  (" . $task['name'] . ")", "task_complete");
        NotifyModel::doAdd($task, "Пользователь " . $task['user']['email'] . " подтвердил, что продолбал задачу");
        if ($task['creator']['_id']->__toString() != $task['user']['_id']->__toString()) {
            NotifyModel::doAdd($task, "Пользователь " . $task['user']['email'] . " подтвердил, что продолбал задачу", $task['creator']);
        }
        if (count($array_update['cron']) == 0) {
            $array_update['fail'] = 1;
        } else {
            $newtask = $task;
            unset($newtask['_id']);
            unset($newtask['last_id']);
            $newtask['fail'] = 1;
            $newtask['date'] = new MongoDate();
            NOiCore::app()->db()->insert($newtask, "tasks");
        }


        NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $rows['last_id']));
    }

    public static function startnotify() {
        $rightnow = TaskModel::rightnow();

        if (count($rightnow)) {
            foreach ($rightnow as $task) {
                NotifyModel::doAdd($task, $task['creator']['email'] . " создал для вас задачу");
            }
        }
        $fivelater = TaskModel::fiveLater();
        if (count($fivelater)) {
            foreach ($fivelater as $task) {
                NotifyModel::doAdd($task, "Через 5 минут будет задача ");
            }
        }
        $all = TaskModel::allUnnotify();
        if (count($all)) {
            foreach ($all as $task) {
                NotifyModel::doAdd($task, "Для вас создали задачу");
            }
        }
    }

    public static function doSync() {
        $user = NoiCore::user()->load();
        $query = NoiCore::app()->db()->query2(array(), "tasks", array('user._id' => $user['_id'], 'cron.time' => array('$lt' => new MongoDate())));
        foreach ($query as $rows) {
            if (!isset($rows['cron'])) {
                $rows['cron'] = array();
            }
            $array_update = array('cron' => $rows['cron']);
            if (count($array_update['cron'])) {
                foreach ($array_update['cron'] as $kk => $cr) {
                    if (time() > $cr['time']->sec) {
                        $cron = \Cron\CronExpression::factory($cr['format']);
                        $newtime = $cron->getNextRunDate()->getTimestamp();
                        $array_update['cron'][$kk]['time'] = new MongoDate($newtime);
                        \Yii::info("Задача успешно запущена,следущая дата запуска " . date('Y-m-d H:i:s', $newtime), "cron_delete");
                    }
                }
            }
            NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $rows['last_id']));
        }
    }

    public static function getAllFails() {
        $user = NoiCore::user()->load();
        $condition = array();
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            
        } else {
            $condition['user._id'] = $user['_id'];
        }
        $condition['fail'] = 1;
        //  $condition['cron.time']=array('$lt'=>new MongoDate());
        $sort = array('_id' => -1);
        if (isset($_GET['sort_type']) and ( $_GET['sort_type'] == "asc" or $_GET['sort_type'] == "desc") and isset($_GET['sort_field']) and is_string($_GET['sort_field'])) {
            $sort = array(strip_tags($_GET['sort_field']) => -1);
            if ($_GET['sort_type'] == "asc") {
                $sort = array(strip_tags($_GET['sort_field']) => 1);
            }
        }
        $query = NoiCore::app()->db()->query2(array(), "tasks", $condition, $sort);
        return $query;
    }

    public static function getAllCompletes() {
        $user = NoiCore::user()->load();
        $condition = array();
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            
        } else {
            $condition['user._id'] = $user['_id'];
        }

        $condition['complete'] = 1;
        //  $condition['fail']=array('$ne'=>1);
        //  $condition['cron.time']=array('$lt'=>new MongoDate());
        $sort = array('_id' => -1);
        if (isset($_GET['sort_type']) and ( $_GET['sort_type'] == "asc" or $_GET['sort_type'] == "desc") and isset($_GET['sort_field']) and is_string($_GET['sort_field'])) {
            $sort = array(strip_tags($_GET['sort_field']) => -1);
            if ($_GET['sort_type'] == "asc") {
                $sort = array(strip_tags($_GET['sort_field']) => 1);
            }
        }
        $query = NoiCore::app()->db()->query2(array(), "tasks", $condition, $sort);
        return $query;
    }

    public static function getAll($user = array()) {
        if (!isset($user['_id'])) {
            $user = NoiCore::user()->load();
        }
        $condition = array();
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            
        } else {
            $condition['user.last_id'] = $user['last_id'];
        }

        $condition['complete'] = array('$ne' => 1);
        $condition['fail'] = array('$ne' => 1);
        //  $condition['cron.time']=array('$lt'=>new MongoDate());
        $sort = array('_id' => -1);
        if (isset($_GET['sort_type']) and ( $_GET['sort_type'] == "asc" or $_GET['sort_type'] == "desc") and isset($_GET['sort_field']) and is_string($_GET['sort_field'])) {
            $sort = array(strip_tags($_GET['sort_field']) => -1);
            if ($_GET['sort_type'] == "asc") {
                $sort = array(strip_tags($_GET['sort_field']) => 1);
            }
        }



        $query = NoiCore::app()->db()->query2(array(), "tasks", $condition, $sort);
        return $query;
    }

    public static function getCount() {
        $user = NoiCore::user()->load();
        $condition = array();
        if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
            
        } else {
            $condition['user._id'] = $user['_id'];
        }

        $condition['complete'] = array('$ne' => 1);
        $condition['fail'] = array('$ne' => 1);
        //  $condition['cron.time']=array('$lt'=>new MongoDate());

        $count = NoiCore::app()->db()->count("tasks", $condition);
        return $count;
    }

    public static function rightnow() {
        $user = NoiCore::user()->load();

        $condition = array('user._id' => $user['_id']);
        $condition['cron.time'] = array('$lt' => new MongoDate());
        $condition['notrightnow2'] = array('$ne' => 1);

        $results = NoiCore::app()->db()->query2(array(), "tasks", $condition);

        NoiCore::app()->db()->update(array('notrightnow2' => 1), "tasks", $condition, true);
        return $results;
    }

    public static function fiveLater() {
        $user = NoiCore::user()->load();
        $time_start = strtotime("+ 5 minute");
        $time_end = strtotime("+ 6 minutes");
        $condition = array('user._id' => $user['_id']);
        $condition['cron.time'] = array('$gt' => new MongoDate($time_start), '$lt' => new MongoDate($time_end));
        $condition['not5'] = array('$ne' => 1);
        $results = NoiCore::app()->db()->query2(array(), "tasks", $condition);
        NoiCore::app()->db()->update(array('not5' => 1), "tasks", $condition, true);


        return $results;
    }

    public static function allUnnotify() {
        $user = NoiCore::user()->load();
        $results = NoiCore::app()->db()->query2(array(), "tasks", array('notnotify' => array('$ne' => 1), 'user._id' => $user['_id']));
        NoiCore::app()->db()->update(array('notnotify' => 1), "tasks", array('notnotify' => array('$ne' => 1), 'user._id' => $user['_id']), true);
        return $results;
    }

    public static function getGuest($last_id) {
        $result = false;
        if (isset($last_id) and is_numeric($last_id)) {
            $condition = array();
            $condition['last_id'] = (int) $last_id;
            $query = NoiCore::app()->db()->query(array(), "tasks", $condition);

            if (isset($query[0]['_id'])) {
                $result = $query[0];
                if (!isset($result['cron'])) {
                    $result['cron'] = array();
                }
            }
        }
        return $result;
    }

    public static function get($last_id) {
        $user = NoiCore::user()->load();
        $result = false;
        if (isset($last_id) and is_numeric($last_id)) {
            $condition = array('creator._id' => $user['_id']);
            if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
                $condition = array();
            }
            $condition['last_id'] = (int) $last_id;

            $query = NoiCore::app()->db()->query(array(), "tasks", $condition);
            if (isset($query[0]['_id'])) {
                $result = $query[0];
                if (!isset($result['cron'])) {
                    $result['cron'] = array();
                }
            }
        }
        return $result;
    }

    public static function get2($last_id) {
        $user = NoiCore::user()->load();
        $result = false;
        if (isset($last_id) and is_numeric($last_id)) {
            $condition = array();

            $condition['last_id'] = (int) $last_id;
            $query = NoiCore::app()->db()->query(array(), "tasks", $condition);
            if (isset($query[0]['_id'])) {
                $result = $query[0];
                if (!isset($result['cron'])) {
                    $result['cron'] = array();
                }
            }
        }
        return $result;
    }

    public static function getMy($last_id) {
        $user = NoiCore::user()->load();
        $result = false;
        if (isset($last_id) and is_numeric($last_id)) {
            $condition = array('user._id' => $user['_id']);
            if (isset($user['ismanager']) and (int) $user['ismanager'] == 1) {
                $condition = array();
            }
            $condition['last_id'] = (int) $last_id;
            $query = NoiCore::app()->db()->query(array(), "tasks", $condition);
            if (isset($query[0]['_id'])) {
                $result = $query[0];
                if (!isset($result['cron'])) {
                    $result['cron'] = array();
                }
            }
        }
        return $result;
    }

    public static function delCron($array, $key) {
        if (isset($array['cron'][$key]['format'])) {
            $array_update = array();
            $array_update['cron'] = $array['cron'];
            unset($array_update['cron'][$key]);
            $array_update['cron'] = array_values($array_update['cron']);
            NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $array['last_id']));
            \Yii::info("Расписание успешно удалено", "cron_delete");
        }
    }

    public static function doUpdate($array, $key) {
        if (isset($_POST['hours']) and ( $_POST['hours'] == "*" or ( is_numeric($_POST['hours']) and (int) $_POST['hours'] >= 1 and (int) $_POST['hours'] < 25))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали часы");
            \Yii::warning("Вы не указали часы", "cron_update");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['minuts']) and ( $_POST['minuts'] == "*" or ( is_numeric($_POST['minuts']) and (int) $_POST['minuts'] >= 0 and (int) $_POST['minuts'] < 61))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали минуты");
            \Yii::warning("Вы не указали минуты", "cron_update");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['month']) and ( $_POST['month'] == "*" or ( is_numeric($_POST['month']) and (int) $_POST['month'] > 0 and (int) $_POST['month'] < 13))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали месяцы");
            \Yii::warning("Вы не указали месяцы", "cron_update");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['days']) and ( $_POST['days'] == "*" or ( is_numeric($_POST['days']) and (int) $_POST['days'] > 0 and (int) $_POST['days'] < 32))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали дни");
            \Yii::warning("Вы не указали дни", "cron_update");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['dayweek']) and ( $_POST['dayweek'] == "*" or ( is_numeric($_POST['dayweek']) and (int) $_POST['dayweek'] > 0 and (int) $_POST['dayweek'] < 8))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали дни недели");
            \Yii::warning("Вы не указали дни недели", "cron_update");
            NoiCore::app()->returnback();
            exit;
        }
        $format = $_POST['minuts'] . " " . $_POST['hours'] . " " . $_POST['days'] . " " . $_POST['month'] . " " . $_POST['dayweek'];
        $cron = \Cron\CronExpression::factory($format);

        $array_update = array();
        $array_update['cron'] = $array['cron'];
        $array_update['cron'][$key] = array('format' => $format, "time" => new MongoDate($cron->getNextRunDate()->getTimestamp()));
        NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $array['last_id']));

        // echo $cron->getNextRunDate()->format('Y-m-d H:i:s');
        NoiCore::app()->setNotify("Расписание успешно обновлено!");
        $user = NoiCore::user()->load();
        $newtask = TaskModel::get2($array['last_id']);
        NotifyModel::doAdd($newtask, "Пользователь " . $user['email'] . " обновил расписание для задачи", $newtask['creator']);
        \Yii::info("Расписание успешно добавлено", "cron_update");
        NoiCore::app()->redirect("/tasks/index.html");
        exit;
    }

    public static function doCron($array) {
        if (isset($_POST['hours']) and ( $_POST['hours'] == "*" or ( is_numeric($_POST['hours']) and (int) $_POST['hours'] >= 1 and (int) $_POST['hours'] < 25))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали часы");
            \Yii::warning("Вы не указали часы", "cron_add");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['minuts']) and ( $_POST['minuts'] == "*" or ( is_numeric($_POST['minuts']) and (int) $_POST['minuts'] >= 0 and (int) $_POST['minuts'] < 61))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали минуты");
            \Yii::warning("Вы не указали минуты", "cron_add");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['month']) and ( $_POST['month'] == "*" or ( is_numeric($_POST['month']) and (int) $_POST['month'] > 0 and (int) $_POST['month'] < 13))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали месяцы");
            \Yii::warning("Вы не указали месяцы", "cron_add");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['days']) and ( $_POST['days'] == "*" or ( is_numeric($_POST['days']) and (int) $_POST['days'] > 0 and (int) $_POST['days'] < 32))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали дни");
            \Yii::warning("Вы не указали дни", "cron_add");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['dayweek']) and ( $_POST['dayweek'] == "*" or ( is_numeric($_POST['dayweek']) and (int) $_POST['dayweek'] > 0 and (int) $_POST['dayweek'] < 8))) {
            
        } else {
            NoiCore::app()->setNotify("Вы не указали дни недели");
            \Yii::warning("Вы не указали дни недели", "cron_add");
            NoiCore::app()->returnback();
            exit;
        }
        $format = $_POST['minuts'] . " " . $_POST['hours'] . " " . $_POST['days'] . " " . $_POST['month'] . " " . $_POST['dayweek'];
        $cron = \Cron\CronExpression::factory($format);

        $array_update = array();
        $array_update['cron'] = $array['cron'];
        $array_update['cron'][] = array('format' => $format, "time" => new MongoDate($cron->getNextRunDate()->getTimestamp()));
        NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $array['last_id']));

        // echo $cron->getNextRunDate()->format('Y-m-d H:i:s');
        NoiCore::app()->setNotify("Расписание успешно добавлено!");
        $user = NoiCore::user()->load();
        $newtask = TaskModel::get2($array['last_id']);
        NotifyModel::doAdd($newtask, "Пользователь " . $user['email'] . " добавил расписание для задачи", $newtask['creator']);
        \Yii::info("Расписание успешно добавлено", "cron_add");
        NoiCore::app()->redirect("/tasks/index.html");
        exit;
    }

    public static function doEdit($array) {
        $array_update = array('name' => $array['name']);
        $array_update['description'] = $array['description'];
        $creator = NoiCore::user()->load();
        if (isset($_POST['name']) and ! is_array($_POST['name'])) {
            $array_update['name'] = strip_tags($_POST['name']);
        } else {
            
        }
        if (isset($_POST['description']) and ! is_array($_POST['description'])) {
            $array_update['description'] = strip_tags($_POST['description']);
        } else {
            
        }

        if (isset($_POST['user']) and ! is_array($_POST['user'])) {
            $assigned = NoiCore::user()->load((int) $_POST['user'], "last_id");

            if (isset($assigned['_id'])) {
                $array_update['user'] = $assigned;
            } else {
                
            }
        } else {
            
        }


        NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $array['last_id']));
        if (isset($_POST['user']) and $_POST['user'] == "null") {
            $result = NoiCore::app()->db()->update(array('user' => true), "tasks", array("last_id" => (int) $array['last_id']), true, '$unset');

//$tmp = NoiCore::app()->db()->query(array(), "tasks", array('last_id' => (int) $array['last_id']));
        }
        NoiCore::app()->setNotify("Задача успешно обновлена");
        $user = NoiCore::user()->load();
        $newtask = TaskModel::get2($array['last_id']);

        NotifyModel::doAdd($newtask, "Пользователь " . $user['email'] . " обновил задачу", $newtask['creator']);
        \Yii::info("Задача успешно добавлена", "task_edit");
        NoiCore::app()->redirect("/tasks/index.html");
        exit;
    }

    public static function doAdd() {
        $creator = NoiCore::user()->load();
        if (isset($_POST['name']) and ! is_array($_POST['name'])) {
            
        } else {
            NoiCore::app()->setNotify("Вы не ввели название задания");
            \Yii::warning("Вы не ввели название задания", "task_create");
            NoiCore::app()->returnback();
            exit;
        }
        if (isset($_POST['description']) and ! is_array($_POST['description'])) {
            
        } else {
            \Yii::warning("Вы не ввели описание задания", "task_create");
            NoiCore::app()->setNotify("Вы не ввели описание задания");
            NoiCore::app()->returnback();
            exit;
        }
        $assigned = null;
        if (isset($_POST['user']) and ! is_array($_POST['user'])) {
            $assigned = NoiCore::user()->load((int) $_POST['user'], "last_id");
        }



        $array_insert = array();
        $array_insert['date'] = new MongoDate();
        $array_insert['creator'] = $creator;
        if (isset($assigned['_id'])) {
            $array_insert['user'] = $assigned;
        }

        $array_insert['name'] = strip_tags($_POST['name']);
        $array_insert['description'] = strip_tags($_POST['description']);
        NoiCore::app()->db()->insert($array_insert, "tasks");
        NoiCore::app()->setNotify("Задача успешно добавлена");
        \Yii::info("Задача успешно добавлена", "task_create");
        NoiCore::app()->redirect("/tasks/index.html");
        exit;
    }

}
