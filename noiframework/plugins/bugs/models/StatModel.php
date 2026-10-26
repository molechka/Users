<?php

namespace bugs\models;

use NoiCore;
use MongoDate;
use Yii;

class StatModel {

    public static function get_user_browser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $ub = '';
        if (preg_match('/MSIE/i', $u_agent)) {
            $ub = "ie";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $ub = "firefox";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $ub = "safari";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $ub = "chrome";
        } elseif (preg_match('/Flock/i', $u_agent)) {
            $ub = "flock";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $ub = "opera";
        }

        return $ub;
    }

    public static function getMonths() {
        $years = array();
        $user = NoiCore::user()->load();
        $condition = array('user._id' => $user['_id']);
        $rows = NoiCore::app()->db()->query2(array(), "documents_filtered", $condition, array('_id' => -1));
        if (count($rows)) {
            foreach ($rows as $row) {
                $year = date('Y', $row['date']->sec);
                $m = "m" . (int) date('m', $row['date']->sec);
            }
        }

        return $years;
    }

    public static function getAll() {
        $user = NoiCore::user()->load();
        $condition = array('user._id' => $user['_id']);
        $_POST['title2'] = "Вся статистика";
        if (isset($_GET['year']) and is_numeric($_GET['year'])) {
            if ($_GET['year'] == "2015" and isset($user['enable_year']) and $user['enable_year'] == 1) {
                throw new \yii\base\ExitException("Произошла непредвиденная ошибка при обработке данных!");
            }
            $year = $_GET['year']; // Get current year and subtract 1
            $start = mktime(0, 0, 0, 1, 1, $year);
            $end = mktime(0, 0, 0, 12, 31, $year);
            $condition['date'] = array('$lte' => new MongoDate($end), '$gte' => new MongoDate($start));
            $_POST['title2'] = "Статистика за  " . $_GET['year'] . " год";
        } elseif (isset($_GET['year']) and is_numeric($_GET['year']) and isset($_GET['month']) and is_numeric($_GET['month'])) {
            $month = $_GET['month'];
            if ($month < 10) {
                $month = "0" . (string) $month;
            }
            $query_date = $_GET['year'] . '-' . $month . '-04';

// First day of the month.
            $start_month = date($_GET['year'] . '-' . $month . '-01', strtotime($query_date));

// Last day of the month.
            $end_month = date($_GET['year'] . '-' . $month . '-t', strtotime($query_date));
            $condition['date'] = array('$lte' => new MongoDate(strtotime($end_month)), '$gte' => new MongoDate(strtotime($start_month)));
            $_POST['title2'] = "Статистика за  " . $month . "/" . $_GET['year'];
        }

        $rows = NoiCore::app()->db()->query2(array(), "documents_filtered", $condition);
        return $rows;
    }

}
