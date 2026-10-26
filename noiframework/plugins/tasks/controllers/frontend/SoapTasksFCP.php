<?php

use WSDL\WSDLCreator;

//use tasks\models\WrapperSoapServer;
class SoapTasksFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("tasks", $cur, $route);

        //\tasks\models\TaskModel::doSync();
    }

    public function actionIndex() {
        $domain = $_SERVER['HTTP_HOST'];


        if (isset($_GET['wsdl'])) {
            $wsdl = new WSDL\WSDLCreator('WrapperSoapServer', 'http://' . $domain . '/tasks/soap/WrapperSoapServer.php');

            $wsdl->setNamespace("http://foo.bar/");
            echo $wsdl->renderWSDL();

            exit;
        }

        $server = new SoapServer(null, array(
            'uri' => 'http://' . $domain . '/tasks/soap/WrapperSoapServer.php'
        ));
        $server->setClass('WrapperSoapServer');
        $server->handle();
        $code = http_response_code();
        if ($code > 400) {
            header("HTTP/1.1 " . http_response_code() . " ERROR");
        } else {
            header("HTTP/1.1 " . http_response_code() . " OK");
        }
        exit;
    }

}

class User {

    /**
     * @type string
     */
    public $name;

    /**
     * @type int
     */
    public $age;

    /**
     * @type double
     */
    public $payment;

}

class Employee {

    /**
     * @type int
     */
    public $id;

    /**
     * @type string
     */
    public $department;

}

class ErrorReturn {

    /**
     * @type string
     */
    public $message;

}

class CompanyReturn {

    /**
     * @type int
     */
    public $id_company;

    /**
     * @type string
     */
    public $message;

    /**
     * @type string
     */
    public $name = "";

    /**
     * @type string
     */
    public $type = "";

    /**
     * @type string
     */
    public $inn = "";

    /**
     * @type string
     */
    public $ogrn = "";

    /**
     * @type string
     */
    public $kpp = "";

    /**
     * @type string
     */
    public $phone = "";

    /**
     * @type string
     */
    public $adress = "";

    /**
     * @type array
     */
    public $users = "";

}

class MagicSearch {

    /**
     * @type int
     */
    public $foundCount;

    /**
     * @type array
     */
    public $results;

}

class TaskReturn {

    /**
     * @type int
     */
    public $id_task;

    /**
     * @type string
     */
    public $message;

}

class UserField {

    /**
     * @type string
     */
    public $name;

    /**
     * @type string
     */
    public $value;

}

class UserReturnTask {

    /**
     * @type string
     */
    public $email;

    /**
     * @type string
     */
    public $name;

    /**
     * @type string
     */
    public $avatar;

    /**
     * @type string
     */
    public $password;

    /**
     * @type string
     */
    public $birthday = 0;

    /**
     * @type string
     */
    public $gender;

    /**
     * @type string
     */
    public $date_start = 0;

    /**
     * @type string
     */
    public $hobby;

    /**
     * @type string
     */
    public $name1 = "";

    /**
     * @type string
     */
    public $surname1 = "";

    /**
     * @type string
     */
    public $fathername1 = "";

    /**
     * @type string
     */
    public $cat = "";

    /**
     * @type string
     */
    public $dog = "";

    /**
     * @type string
     */
    public $parrot = "";

    /**
     * @type string
     */
    public $cavy = "";

    /**
     * @type string
     */
    public $hamster = "";

    /**
     * @type string
     */
    public $squirrel = "";

    /**
     * @type string
     */
    public $phone = "";

    /**
     * @type string
     */
    public $adres = "";

    /**
     * @type array
     */
    public $tasks = "";

    /**
     * @type array
     */
    public $companies = "";

    /**
     * @type array
     */
}

class UserReturnFull {

    /**
     * @type string
     */
    public $email;

    /**
     * @type string
     */
    public $name;

    /**
     * @type string
     */
    public $avatar;

    /**
     * @type string
     */
    public $password;

    /**
     * @type string
     */
    public $birthday = 0;

    /**
     * @type string
     */
    public $gender;

    /**
     * @type string
     */
    public $date_start = 0;

    /**
     * @type string
     */
    public $hobby;

    /**
     * @type string
     */
    public $name1 = "";

    /**
     * @type string
     */
    public $surname1 = "";

    /**
     * @type string
     */
    public $fathername1 = "";

    /**
     * @type string
     */
    public $cat = "";

    /**
     * @type string
     */
    public $dog = "";

    /**
     * @type string
     */
    public $parrot = "";

    /**
     * @type string
     */
    public $cavy = "";

    /**
     * @type string
     */
    public $hamster = "";

    /**
     * @type string
     */
    public $squirrel = "";

    /**
     * @type string
     */
    public $phone = "";

    /**
     * @type string
     */
    public $adres = "";

    /**
     * @type array
     */
    public $tasks = array();

    /**
     * @type array
     */
    public $companys = array();

    /**
     * @type string
     */
}

class UserReturn {

    /**
     * @type string
     */
    public $email;

    /**
     * @type string
     */
    public $name;

    /**
     * @type string
     */
    public $avatar;

    /**
     * @type string
     */
    public $password;

    /**
     * @type string
     */
    public $birthday = 0;

    /**
     * @type string
     */
    public $gender;

    /**
     * @type string
     */
    public $date_start = 0;

    /**
     * @type string
     */
    public $hobby;

    /**
     * @type string
     */
    public $name1 = "";

    /**
     * @type string
     */
    public $surname1 = "";

    /**
     * @type string
     */
    public $fathername1 = "";

    /**
     * @type string
     */
    public $cat = "";

    /**
     * @type string
     */
    public $dog = "";

    /**
     * @type string
     */
    public $parrot = "";

    /**
     * @type string
     */
    public $cavy = "";

    /**
     * @type string
     */
    public $hamster = "";

    /**
     * @type string
     */
    public $squirrel = "";

    /**
     * @type string
     */
    public $phone = "";

    /**
     * @type string
     */
    public $adres = "";

    /**
     * @type int
     */
    public $inn = "";

    /**
     * @type string
     */
}

class WrapperSoapServer {

    /**
     * @WebMethod
     * @param string $email_owner
     * @param int $id_task
     * @return string  $result
     */
    public function DeleteTask($email_owner, $id_task) {
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода DeleteTask', "soap");
        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_owner . " некорректный", "soap");



            return ' email_owner ' . $email_owner . " некорректный";
        }
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            return 'Пользователь не найден c email_owner ' . $email_owner;
        }
        $tasks = NoiCore::app()->db()->query(array(), "tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        if (!isset($tasks[0]['_id'])) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " не найдена", "soap");

            return ' Задача с ID ' . $id_task . " не найдена";
        }

        NoiCore::app()->db()->delete("tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " успешно удалена", "soap");

        return ' Задача с ID ' . $id_task . " успешно удалена";
    }

    /**
     * @WebMethod
     * @param string $query
     * @param string $partyType
     * @param bool $fullSimilarity
     * @param string $taskStatus
     * @param mixed $include
     * @param int $maxCount
     * @return wrapper $MagicSearch @className=MagicSearch
     */
    public function MagicSearch($query = null, $partyType = "ALL", $fullSimilarity = null, $taskStatus = null, $include = null, $maxCount = 5) {
        $alltypes = array("ALL", "USER", "COMPANY");
        $allstatuses = array("ALL", "ACTUAL", "COMPLETE", "FAIL");
        $allinclude = array("ALL", "USER", "COMPANY", "TASK", "WHY");
        if (!(isset($query) and is_string($query))) {
            http_response_code(455);
            return array('code_error' => '455', 'message' => 'Не найден обязательный параметр query');
        }

        if (!(isset($query) and is_string($query) and strlen($query) > 0 and strlen($query) < 1000)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр query должен быть больше 0 символов и меньше 1000 символов', "soap");
            http_response_code(456);
            return array('code_error' => '456', 'message' => 'Длина запроса не должна превышать 1000 символов');
        }
        if (!(isset($fullSimilarity) and is_bool($fullSimilarity))) {
            $fullSimilarity = false;
        }

        if (isset($partyType) and is_object($partyType) and isset($partyType->info)) {
            if (is_array($partyType->info)) {
                $include = $partyType;
            } else {
                $include = $partyType->info;
            }
        }
        if (!is_null($taskStatus) and $taskStatus == "null") {
            $taskStatus = null;
        }





        if (is_object($include) and isset($include->info) and is_array($include->info)) {
            $include = $include->info;
        }


        if (isset($include) and ( is_string($include) or is_array($include))) {
            if (!(isset($include) and is_string($include) and in_array($include, $allinclude) )) {
                if (is_array($include) and ( in_array("ALL", $include) or in_array("USER", $include) or in_array("COMPANY", $include) or in_array("TASK", $include) or in_array("WHY", $include))) {
                    
                } else {
                    http_response_code(459);
                    return array('code_error' => '459', 'message' => 'Параметр include может принимать только значения: ALL, USER, COMPANY, TASK, WHY');
                }
            }
        } else {
            $include = "ALL";
        }


        if (is_null($include)) {
            $include = "ALL";
        }
        if (!(isset($maxCount) and is_numeric($maxCount) and (int) $maxCount > 0)) {
            $maxCount = 5;
        }
        $users = array();
        $companies = array();

        if (isset($partyType) and is_string($partyType)) {
            if (!(isset($partyType) and is_string($partyType) and in_array($partyType, $alltypes))) {
                http_response_code(457);

                return array('code_error' => '457', 'message' => 'Параметр partyType может принимать только значения: ALL,USER, COMPANY');

                // $partyType = "ALL";
            }
        } else {
            $partyType = "ALL";
        }


        if (isset($taskStatus) and is_string($taskStatus)) {
            if (!(isset($taskStatus) and is_string($taskStatus) and in_array($taskStatus, $allstatuses))) {
                // $taskStatus = null;
                http_response_code(458);
                return array('code_error' => '458', 'message' => 'Параметр taskStatus может принимать только значения: ALL, ACTUAL, COMPLETE, FAIL');
            }
        }

        $total = 0;
        if ($partyType == "ALL" or $partyType == "USER") {
            $users_result = tasks\models\SearchModel::findUser($query, $fullSimilarity, $taskStatus, $include, $maxCount);
            $users = $users_result['result'];
            $total += $users_result['count'];
        }

        if ($partyType == "ALL" or $partyType == "COMPANY") {

            $companies_result = tasks\models\SearchModel::findCompany($query, $fullSimilarity, $taskStatus, $include, $maxCount);
            $companies = $companies_result['result'];
            $total += $companies_result['count'];
        }



        $total_result = array();
        if (is_array($users) and count($users)) {
            foreach ($users as $user) {
                $user['type'] = "user";
                if (isset($user['by_user'])) {
                    $user['by_user'] = $user['by_user']['email'];
                }
                if (isset($user['date_start'])) {
                    unset($user['date_start']);
                }

                if (isset($user['birthday'])) {
                    $user['birthday'] = date('d.m.Y', $user['birthday']->sec);
                }
                if (isset($user['_id'])) {
                    unset($user['_id']);
                }
                if (isset($user['role'])) {
                    unset($user['role']);
                }
                if (isset($user['user_money'])) {
                    unset($user['user_money']);
                }
                if (isset($user['structure_vznos'])) {
                    unset($user['structure_vznos']);
                }
                if (isset($user['with_outvznos'])) {

                    unset($user['with_outvznos']);
                }
                if (isset($user['with_vznos'])) {
                    unset($user['with_vznos']);
                }
                if (isset($user['total_deposits'])) {
                    unset($user['total_deposits']);
                }
                if (isset($user['enable_account'])) {

                    unset($user['enable_account']);
                }
                if (isset($user['user_active'])) {
                    unset($user['user_active']);
                }
                if (isset($user['last_update_time'])) {
                    unset($user['last_update_time']);
                }
                if (isset($user['status_user'])) {
                    unset($user['status_user']);
                }
                if (isset($user['access_hash_token'])) {
                    unset($user['access_hash_token']);
                }
                if (isset($user['access_ip'])) {
                    unset($user['access_ip']);
                }
                if (isset($user['session_id'])) {
                    unset($user['session_id']);
                }
                if (isset($user['site_id'])) {
                    unset($user['site_id']);
                }
                if (isset($user['order_last_id'])) {
                    unset($user['order_last_id']);
                }
                if (isset($user['last_id'])) {
                    unset($user['last_id']);
                }
                if (isset($user['date_register'])) {
                    unset($user['date_register']);
                }
                if (isset($user['date_updated'])) {
                    unset($user['date_updated']);
                }
                if (isset($user['password'])) {
                    unset($user['password']);
                }
                if (isset($user['end_date'])) {
                    unset($user['end_date']);
                }

                if (isset($user['companies'])) {
                    $arr_tmp = array();
                    foreach ($user['companies'] as $company) {
                        $arr_tmp[] = array("name" => $company['name'], "id_company" => $company['last_id']);
                    }
                    $user['companies'] = $arr_tmp;
                }

                if (isset($user['tasks'])) {
                    $arr_tmp = array();
                    foreach ($user['tasks'] as $company) {
                        $status = "ACTUAL";

                        if (isset($company['complete']) and $company['complete'] == 1) {
                            $status = "COMPLETE";
                        } else if (isset($company['fail']) and $company['fail'] == 1) {
                            $status = "FAIL";
                        } else {
                            if (isset($company['cron']) and is_array($company['cron']) and count($company['cron'])) {
                                foreach ($company['cron'] as $cron) {
                                    if (isset($cron['time']) and is_object($cron['time'])) {
                                        $time = $cron['time']->sec;

                                        if ($time < time()) {
                                            $status = "FAIL";
                                            break;
                                        }
                                    } else if (isset($cron['time']['sec'])) {
                                        $time = $cron['time']['sec'];

                                        if ($time < time()) {
                                            $status = "FAIL";
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                        $arr_tmp [] = array('status' => $status, "name" => $company['name'], "id_task" => $company['last_id']);
                    }
                    $user['tasks'] = $arr_tmp;
                }

                $total_result[] = $user;
            }
        }

        if (is_array($companies) and count($companies)) {
            foreach ($companies as $company) {
                if (isset($company['_id'])) {
                    unset($company['_id']);
                }
                if (isset($company['last_id'])) {
                    $company['id_company'] = $company['last_id'];

                    unset($company['last_id']);
                }
                if (isset($company['site_id'])) {
                    unset($company['site_id']);
                }
                if (isset($company['order_last_id'])) {
                    unset($company['order_last_id']);
                }


                if (isset($company['creator'])) {
                    unset($company['creator']);
                }

                if (isset($company['date'])) {
                    unset($company['date']);
                }
                if (isset($company['date_update'])) {
                    unset($company['date_update']);
                }

                if (isset($company['users']) and count($company['users'])) {
                    $newusers = array();
                    foreach ($company['users'] as $user) {
                        $newusers[] = $user['email'];
                    }
                    $company['users'] = $newusers;
                }

                if (isset($company['tasks']) and count($company['tasks'])) {
                    $tasks = array();
                    foreach ($company['tasks'] as $task) {
                        $status = "ACTUAL";

                        if (isset($task['complete']) and $task['complete'] == 1) {
                            $status = "COMPLETE";
                        } else if (isset($task['fail']) and $task['fail'] == 1) {
                            $status = "FAIL";
                        } else {
                            if (isset($task['cron']) and is_array($task['cron']) and count($task['cron'])) {
                                foreach ($task['cron'] as $cron) {
                                    if (isset($cron['time']) and is_object($cron['time'])) {
                                        $time = $cron['time']->sec;

                                        if ($time < time()) {
                                            $status = "FAIL";
                                            break;
                                        }
                                    } else if (isset($cron['time']['sec'])) {
                                        $time = $cron['time']['sec'];

                                        if ($time < time()) {
                                            $status = "FAIL";
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                        $tasks[] = array('status' => $status, "name" => $task['name'], "id_task" => $task['last_id']);
                    }
                    $company['tasks'] = $tasks;
                }



                $company['type'] = "company";
                $total_result[] = $company;
            }
        }

        if (count($total_result) == 0) {
            http_response_code(230);
        } else {
            if (isset($companies) and is_array($companies) and count($companies) == 1 and ! (isset($users) and is_array($users) and count($users) > 0)) {
                http_response_code(233);
            } else if (isset($companies) and is_array($companies) and count($companies) > 1 and ! (isset($users) and is_array($users) and count($users) > 0)) {
                http_response_code(234);
            } else if (isset($users) and is_array($users) and count($users) == 1 and ! (isset($companies) and is_array($companies) and count($companies) > 0)) {
                http_response_code(231);
            } else if (isset($users) and is_array($users) and count($users) > 1 and ! (isset($companies) and is_array($companies) and count($companies) > 0)) {
                http_response_code(232);
            } else if (isset($users) and is_array($users) and count($users) > 0 and isset($companies) and is_array($companies) and count($companies) > 0) {
                http_response_code(235);
            } else {
                http_response_code(200);
            }
        }
        Yii::$app->response->statusCode = http_response_code();
        $MagicSearch = new MagicSearch();
        $MagicSearch->foundCount = $total;
        $MagicSearch->results = $total_result;


        return $MagicSearch;
    }

    /**
     * @WebMethod
     * @param string $email_owner
     * @param int $id_task
     * @param string $hours
     * @param string $minutes
     * @param string $month
     * @param string $days
     * @param string $day_weeks
     * @return string  $result
     */
    public function AddTaskInCron($email_owner, $id_task, $hours, $minutes, $month, $days, $day_weeks) {
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода AddTaskInCron', "soap");
        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_owner . " некорректный", "soap");



            return ' email_owner ' . $email_owner . " некорректный";
        }
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            return 'Пользователь не найден c email_owner ' . $email_owner;
        }
        $tasks = NoiCore::app()->db()->query(array(), "tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        if (!isset($tasks[0]['_id'])) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " не найдена", "soap");

            return ' Задача с ID ' . $id_task . " не найдена";
        }
        if (isset($hours) and ( $hours == "*" or ( is_numeric($hours) and (int) $hours >= 1 and (int) $hours < 25))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' hours имеет неправильное значение ', "soap");
            return "hours имеет неправильное значение";
        }

        if (isset($minutes) and ( $minutes == "*" or ( is_numeric($minutes) and (int) $minutes >= 0 and (int) $minutes < 61))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' minutes имеет неправильное значение ', "soap");
            return "minutes имеет неправильное значение";
        }

        if (isset($month) and ( $month == "*" or ( is_numeric($month) and (int) $month > 0 and (int) $month < 13))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' month имеет неправильное значение ', "soap");
            return "month имеет неправильное значение";
        }

        if (isset($days) and ( $days == "*" or ( is_numeric($days) and (int) $days > 0 and (int) $days < 32))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' days имеет неправильное значение ', "soap");
            return "days имеет неправильное значение";
        }
        if (isset($day_weeks) and ( $day_weeks == "*" or ( is_numeric($day_weeks) and (int) $day_weeks > 0 and (int) $day_weeks < 8))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' day_weeks имеет неправильное значение ', "soap");
            return "day_weeks имеет неправильное значение";
        }
        $array = array();
        $array['cron'] = array();
        if (isset($tasks[0]['cron'])) {
            $array['cron'] = $tasks[0]['cron'];
        }

        $format = $minutes . " " . $hours . " " . $days . " " . $month . " " . $day_weeks;
        $cron = \Cron\CronExpression::factory($format);


        $array_update = array();
        $array_update['cron'] = $array['cron'];
        $nexttime = $cron->getNextRunDate()->getTimestamp();
        $array_update['cron'][] = array('format' => $format, "time" => new \MongoDate($nexttime));
        NoiCore::app()->db()->update($array_update, "tasks", array('last_id' => (int) $id_task));
        return "Расписание успешно добавлено в задачу " . $id_task . " Следущая дата запуска " . date('d.m.Y H:i', $nexttime);
    }

    /**
     * @WebMethod
     * @param string $email_owner
     * @param string $email_assign
     * @param int $id_task
     * @param string $task_title
     * @param string $task_description
     * @return string  $result
     */
    public function UpdateTask($email_owner, $email_assign, $id_task, $task_title, $task_description) {
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateTask', "soap");

        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_owner . " некорректный", "soap");



            return ' email_owner ' . $email_owner . " некорректный";
        }
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            return 'Пользователь не найден c email_owner ' . $email_owner;
        }


        if (!(isset($email_assign) and is_string($email_assign) and filter_var($email_assign, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_assign ' . $email_assign . " некорректный", "soap");



            return ' email_assign ' . $email_owner . " некорректный";
        }
        $email_assign = strtolower($email_assign);
        $assigns = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_assign)));
        if (isset($assigns[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_assign ' . $email_assign . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_assign ' . $email_assign, "soap");

            return 'Пользователь не найден c email_assign ' . $email_owner;
        }


        $count = NoiCore::app()->db()->count("tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        if ($count == 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " не найдена", "soap");

            return ' Задача с ID ' . $id_task . " не найдена";
        }
        if (!(isset($task_title) and is_string($task_title) and strlen($task_title))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_title имеет  неверное значение', "soap");
            return ' Параметр task_title имеет  неверное значение';
        }
        if (!(isset($task_description) and is_string($task_description) and strlen($task_description))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_description имеет  неверное значение', "soap");
            return ' Параметр task_description имеет  неверное значение';
        }
        $update = array();
        $update['name'] = strip_tags($task_title);
        $update['user'] = $assigns[0];
        $update['description'] = strip_tags($task_description);
        NoiCore::app()->db()->update($update, "tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        return "Задача успешно изменена!";
    }

    /**
     * @WebMethod
     * @param string $company_name
     * @param string $company_type
     * @param array $company_users
     * @param string $email_owner
     * @return wrapper $CompanyReturn @className=CompanyReturn
     */
    public function CreateCompany($company_name, $company_type, $email_owner, $company_users = array()) {
        $errorreturn = new ErrorReturn();
        $taskreturn = new CompanyReturn();
        $taskreturn->id_company = 0;
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода CreateCompany', "soap");
        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_owner . " некорректный", "soap");



            $errorreturn->message = ' email_owner ' . $email_owner . " некорректный";
            return $errorreturn;
        }
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            $errorreturn->message = 'Пользователь не найден c email_owner ' . $email_owner;
            return $errorreturn;
        }


        $types = array("ООО", "ИП", "ОАО");
        if (!(isset($company_name) and is_string($company_name) and strlen($company_name) > 1)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр company_name имеет  неверное значение', "soap");
            $errorreturn->message = ' Параметр company_name имеет  неверное значение';
            return $errorreturn;
        }

        $taskreturn->name = $company_name;

        if (!(isset($company_type) and is_string($company_type) and in_array($company_type, $types))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр company_type имеет  неверное значение', "soap");
            $errorreturn->message = ' Параметр company_type имеет  неверное значение';
            return $errorreturn;
        }
        $users = array();
        $taskreturn->type = $company_type;
        if (isset($company_users) and is_array($company_users) and count($company_users)) {
            foreach ($company_users as $user_id) {
                $tmp = \companys\models\CompanyModel::getUser($user_id);
                if (is_array($tmp)) {

                    $users['id_' . $tmp['last_id']] = $tmp;
                }
            }
        }

        if (isset($company_users) and isset($company_users->user) and is_array($company_users->user) and count($company_users->user) > 0) {

            foreach ($company_users->user as $user_id) {

                $tmp = \companys\models\CompanyModel::getUser($user_id);
                if (is_array($tmp)) {

                    $users['id_' . $tmp['last_id']] = $tmp;
                } else {
                    $errorreturn->message = 'Пользователь с email ' . $user_id . " не найден";
                    return $errorreturn;
                }
            }
        } else if (isset($company_users) and isset($company_users->user) and is_string($company_users->user)) {

            $tmp = \companys\models\CompanyModel::getUser($company_users->user);
            if (is_array($tmp)) {

                $users['id_' . $tmp['last_id']] = $tmp;
            } else {
                $errorreturn->message = 'Пользователь с email ' . $user_id . " не найден";
                return $errorreturn;
            }
        }



        if (count($users) == 0) {
//            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр company_users не может быть пустым', "soap");
//            $errorreturn->message = ' Параметр company_users не может быть пустым';
//            return $errorreturn;
        }



        $array_insert = array();
        $array_insert['date'] = new MongoDate();
        $array_insert['date_update'] = new MongoDate();
        $array_insert['creator'] = $owners[0];
        $array_insert['name'] = strip_tags($company_name);
        $array_insert['type'] = $company_type;
        $array_insert['inn'] = "";
        $array_insert['ogrn'] = "";
        $array_insert['kpp'] = strip_tags("");
        $array_insert['phone'] = "";
        $array_insert['adress'] = "";
        $array_insert['users'] = $users;

        $array_insert = NoiCore::app()->db()->insert($array_insert, "companys", true);
        $taskreturn = new CompanyReturn();
        $taskreturn->id_company = $array_insert['last_id'];

        $taskreturn->message = "Компания успешно создана!";
        $newusers = array();
        if (count($users)) {
            foreach ($users as $user) {
                $newusers[] = $user['email'];
            }
        }
        $taskreturn->users = $newusers;
        return $taskreturn;
    }

    /**
     * @WebMethod
     * @param string $email
     * @param string $name
     * @param array $tasks
     * @param array $companies
     * @param string $hobby
     * @param string $adres
     * @param string $name1    
     * @param string $surname1  
     * @param string $fathername1  
     * @param string $cat  
     * @param string $dog
     * @param string $parrot
     * @param string $cavy
     * @param string $hamster
     * @param string $squirrel
     * @param string $phone
     * @param string $inn
     * @param string $gender
     * @param string $birthday
     * @param string $date_start


     * @return wrapper $UserReturnTask @className=UserReturnTask
     */
    public function CreateUser($email, $name, $tasks, $companies = null, $hobby = null, $adres = null, $name1 = null, $surname1 = null, $fathername1 = null, $cat = null, $dog = null, $parrot = null, $cavy = null, $hamster = null, $squirrel = null, $phone = null, $inn = null, $gender = null, $birthday = null, $date_start = null) {
        $return = new UserReturnTask;
        $error = new ErrorReturn;

        if (is_object($companies)) {
            if (is_string($companies->company)) {
                $companies = array($companies->company);
            } else if (is_array($companies->company)) {
                $companies = $companies->company;
            }
        }

        if (is_object($tasks)) {
            if (is_string($tasks->task)) {
                $tasks = array($tasks->task);
            } else if (is_array($tasks->task)) {
                $tasks = $tasks->task;
            }
        }

        $email_users = NoiCore::app()->plugin_values("tasks", "users");
        $soap_owner = null;
        if (isset($email_users[0]['soap'])) {
            $tmp = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_users[0]['soap'])));
            if (isset($tmp[0]) and isset($tmp[0]['last_id'])) {
                $soap_owner = $tmp[0];
            }
        }
        if (is_null($soap_owner)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . "пользователь soap owner не найден.Добавьте его из админки.", "soap");
            $error->message = "пользователь soap owner не найден.Добавьте его из админки.";
            return $error;
        }


        $count_name = NoiCore::app()->db()->count("cms_users", array('name' => $name));
        if ($count_name > 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . " имя " . $name . " уже есть в БД", "soap");


            $error->message = " имя " . $name . " уже есть в БД";
            return $error;
        }



        if (!(isset($companies) and is_array($companies) and count($companies) > 0)) {
//            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр companies должен быть в виде массива', "soap");
//
//            $return->message_error = "параметр companies должен быть в виде массива";
//            return $return;
        }

        if ((isset($companies) and is_array($companies) and count($companies) > 0)) {
            if (count($companies) > 3) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'параметр companies в нем размер массива должен быть не больше 3', "soap");

                $error->message = "параметр companies в нем размер массива должен быть не больше 3";
                return $error;
            }
            $condition = array();
            $condition['$or'] = array();
            foreach ($companies as $company_id) {
                $condition['$or'][] = array("last_id" => (int) $company_id);
            }
            $companies_rows = NoiCore::app()->db()->query(array(), "companys", $condition);
            if (count($companies_rows) == 0) {
                $companies = array();
                //  Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'компании не найдены', "soap");
                //   $error->message = "компании не найдены";
                //   return $error;
            }
        }







        if (!(isset($tasks) and is_array($tasks) and count($tasks) > 0)) {
//            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр tasks должен быть в виде массива', "soap");
//
//
//            $return->message_error = "параметр tasks должен быть в виде массива";
//            return $return;
        }


        if (isset($tasks) and is_array($tasks) and count($tasks) > 0) {
            if (count($tasks) > 5) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'параметр tasks в нем размер массива должен быть не больше 5', "soap");


                $error->message = "параметр tasks в нем размер массива должен быть не больше 5";
                return $error;
            }


            $condition = array();
//    $condition['user'] = array('$exists' => false);
            $condition['$or'] = array();

            foreach ($tasks as $task_id) {
                $condition['$or'][] = array("last_id" => (int) $task_id);
            }
            $tasks_rows = NoiCore::app()->db()->query(array(), "tasks", $condition);
            if (count($tasks_rows) == 0) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'задачи не найдены', "soap");


                $error->message = "задачи не найдены";
                return $error;
            }
//     
        }


        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");


            $error->message = "email неправильный";
            return $error;
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " уже существует", "soap");
            $error->message = "пользователь уже существует";
            return $error;
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");
        }


        if (!(isset($adres) and is_string($adres))) {
//            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $adres . " некорректное", "soap");
//            $return->message_error = ' Значение ' . $adres . " некорректное,должна быть только строка";
//            return $return;
            $adress = "";
        }
        if (!(isset($hobby) and is_string($hobby))) {
//            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hobby . " некорректное", "soap");
//            $return->message_error = ' З!начение ' . $hobby . " некорректное,должна быть только строка";
//            return $return;
            $hobby = "";
        }


        if (!(isset($name) and is_string($name))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name . " некорректное", "soap");
            $error->message = ' Значение ' . $name . " некорректное,должна быть только строка";
            return $error;
        }
        if (!is_null($name1)) {
            if (!(isset($name1) and is_string($name1))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name1 . " некорректное", "soap");
                $error->message = ' Значение ' . $name1 . " некорректное,должна быть только строка";
                return $error;
            }
        }
        if (!is_null($surname1)) {
            if (!(isset($surname1) and is_string($surname1))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $surname1 . " некорректное", "soap");
                $error->message = ' Значение ' . $surname1 . " некорректное,должна быть только строка";
                return $error;
            }
        }
        if (!is_null($fathername1)) {
            if (!(isset($fathername1) and is_string($fathername1))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $fathername1 . " некорректное", "soap");
                $error->message = ' Значение ' . $fathername1 . " некорректное,должна быть только строка";
                return $error;
            }
        }
        if (!is_null($cat)) {
            if (!(isset($cat) and is_string($cat))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cat . " некорректное", "soap");


                $return->message_error = ' Значение ' . $cat . " некорректное,должна быть только строка";
                return $return;
            }
        }
        if (!is_null($dog)) {
            if (!(isset($dog) and is_string($dog))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $dog . " некорректное", "soap");



                $error->message = ' Значение ' . $dog . " некорректное,должна быть только строка";
                return $error;
            }
        }
        if (!is_null($parrot)) {
            if (!(isset($parrot) and is_string($parrot))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $parrot . " некорректное", "soap");


                $error->message = ' Значение ' . $parrot . " некорректное,должна быть только строка";
                return $error;
            }
        }
        if (!is_null($cavy)) {
            if (!(isset($cavy) and is_string($cavy))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cavy . " некорректное", "soap");

                $error->message = ' Значение ' . $cavy . " некорректное,должна быть только строка";
                return $error;
            }
        }

        if (!is_null($hamster)) {
            if (!(isset($hamster) and is_string($hamster))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hamster . " некорректное", "soap");


                $error->message = ' Значение ' . $hamster . " некорректное,должна быть только строка";
                return $error;
            }
        }

        if (!is_null($squirrel)) {
            if (!(isset($squirrel) and is_string($squirrel))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $squirrel . " некорректное", "soap");


                $error->message = ' Значение ' . $squirrel . " некорректное,должна быть только строка";
                return $error;
                //$squirrel = "";
            }
        }
        if (!is_null($phone)) {
            if (!(isset($phone) and is_string($phone))) {
//            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $phone . " некорректное", "soap");
//
//
//            $return->message_error = ' Значение ' . $phone . " некорректное,должна быть только строка";
//            return $return;
                $phone = "";
            }
        }
        if (!is_null($inn)) {
            if (isset($inn) and is_string($inn) and strlen($inn) > 1) {
                if (is_numeric($inn) and strlen($inn) == 12) {
                    
                } else {
//                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $inn . " некорректное", "soap");
//
//
//                $return->message_error = ' Значение ' . $inn . " ИНН ФЛ должен содержать 12 цифр";
//                return $return;
                    $inn = "";
                }
            }
        }


        if (!is_null($birthday)) {
            if (!(bool) strtotime($birthday)) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $birthday . " некорректное", "soap");


                $error->message = ' Значение ' . $birthday . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ";
                return $error;
            }
        }

        if (!is_null($date_start)) {
            if (!(bool) strtotime($date_start)) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $date_start . " некорректное", "soap");


                $error->message = ' Значение ' . $date_start . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ";
                return $error;
            }
        }

        $new_user = array();
        $new_user['email'] = $email;
        $new_user['name'] = $name;
        if (!is_null($name1)) {
            $new_user['name1'] = $name1;
        }
        if (!is_null($hobby)) {
            $new_user['hobby'] = $hobby;
        }
        if (!is_null($surname1)) {
            $new_user['surname1'] = $surname1;
        }
        if (!is_null($fathername1)) {
            $new_user['fathername1'] = $fathername1;
        }
        if (!is_null($cat)) {
            $new_user['cat'] = $cat;
        }
        if (!is_null($dog)) {
            $new_user['dog'] = $dog;
        }
        if (!is_null($parrot)) {
            $new_user['parrot'] = $parrot;
        }
        if (!is_null($cavy)) {
            $new_user['cavy'] = $cavy;
        }
        if (!is_null($hamster)) {
            $new_user['hamster'] = $hamster;
        }
        if (!is_null($squirrel)) {
            $new_user['squirrel'] = $squirrel;
        }
        if (!is_null($phone)) {
            $new_user['phone'] = $phone;
        }

        if (!is_null($adres)) {
            $new_user['adres'] = $adres;
        }
        if (!is_null($gender)) {
            $new_user['gender'] = $gender;
        }
        if (!is_null($date_start)) {
            $new_user['date_start'] = new MongoDate(strtotime($date_start));
        }
        if (!is_null($birthday)) {
            $new_user['birthday'] = new MongoDate(strtotime($birthday));
        }









        $new_user['role'] = array("user");
        $new_user['date_register'] = new MongoDate();
        $new_user['date_updated'] = new MongoDate();
        $new_user['date'] = date('Y-m-d');
        $new_user['user_active'] = 0;
        $new_user['enable_account'] = 1;
        $new_user['total_deposits'] = 0;
        $new_user['with_vznos'] = 0;
        $new_user['with_outvznos'] = 0;
        $new_user['structure_vznos'] = 0;
        $new_user['user_money'] = 0;
        $new_user['by_user'] = $soap_owner;


        $new_user = NoiCore::app()->db()->insert($new_user, "cms_users", true);

        if (isset($new_user['by_user'])) {
            unset($new_user['by_user']);
        }
        if (isset($companies_rows) and is_array($companies_rows) and count($companies_rows) > 0) {
            foreach ($companies_rows as $company_row) {
                $users = array();
                if (isset($company_row['users'])) {
                    $users = $company_row['users'];
                }

                $users['id_' . $new_user['last_id']] = $new_user;
                $update = array();
                $update['users'] = $users;
                if (isset($update['users']) and is_array($update['users']) and count($update['users']) > 0) {
                    foreach ($update['users'] as $key => $row) {
                        if (isset($row['by_user'])) {
                            unset($row['by_user']);
                        }
                        $update['users'][$key] = $row;
                    }
                }

                NoiCore::app()->db()->update($update, "companys", array('last_id' => $company_row['last_id']));
            }
        }

        if (isset($tasks_rows) and is_array($tasks_rows) and count($tasks_rows)) {
            foreach ($tasks_rows as $task_row) {

                $update = array();
                $update['user'] = $new_user;
                NoiCore::app()->db()->update($update, "tasks", array('last_id' => $task_row['last_id']));
            }

            foreach ($tasks_rows as $key => $el) {
                $tasks_rows[$key] = $el['last_id'];
            }
            $new_user['tasks'] = $tasks_rows;
        }

        if (isset($companies_rows) and is_array($companies_rows) and count($companies_rows) > 0) {
            foreach ($companies_rows as $key => $el) {
                $companies_rows[$key] = $el['last_id'];
            }

            $new_user['companies'] = $companies_rows;
        }







        foreach ($new_user as $key => $val) {

            if (property_exists('UserReturnTask', $key)) {
                $return->$key = $val;
            }
        }


        return $return;
    }

    /**
     * @WebMethod
     * @param string $email
     * @param string $name
     * @param array $tasks
     * @param array $companies
     * @param string $hobby
     * @param string $adres
     * @param string $name1    
     * @param string $surname1  
     * @param string $fathername1  
     * @param string $cat  
     * @param string $dog
     * @param string $parrot
     * @param string $cavy
     * @param string $hamster
     * @param string $squirrel
     * @param string $phone
     * @param string $inn
     * @param string $gender
     * @param string $birthday
     * @param string $date_start
     * 

     * @return wrapper $UserReturnTask @className=UserReturnTask
     */
    public function CreateUserWithTasks($email, $name, $tasks, $companies = null, $adres = null, $hobby = null, $name1 = null, $surname1 = null, $fathername1 = null, $cat = null, $dog = null, $parrot = null, $cavy = null, $hamster = null, $squirrel = null, $phone = null, $inn = null, $gender = null, $birthday = null, $date_start = null) {
        $return = new UserReturnTask;
        $error = new ErrorReturn;
        if (is_object($companies)) {
            if (is_string($companies->company)) {
                $companies = array($companies->company);
            } else if (is_array($companies->company)) {
                $companies = $companies->company;
            }
        }



        if (is_object($tasks)) {
            if (is_object($tasks->task)) {
                $newres = array();
                $newarr = array();
                if (isset($tasks->task->task_title)) {
                    $newarr['title'] = $tasks->task->task_title;
                }
                if (isset($tasks->task->task_description)) {
                    $newarr['description'] = $tasks->task->task_description;
                }
                if (count($newarr) > 0) {
                    $newres[] = $newarr;
                }

                $tasks = $newres;
            } else if (is_array($tasks->task)) {
                $newres = array();
                foreach ($tasks->task as $obj) {
                    $newarr = array();
                    if (isset($obj->task_title)) {
                        $newarr['title'] = $obj->task_title;
                    }
                    if (isset($obj->task_description)) {
                        $newarr['description'] = $obj->task_description;
                    }
                    if (count($newarr) > 0) {
                        $newres[] = $newarr;
                    }
                }
                $tasks = $newres;
            }
        }

        $email_users = NoiCore::app()->plugin_values("tasks", "users");
        $soap_owner = null;
        if (isset($email_users[0]['soap'])) {
            $tmp = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_users[0]['soap'])));
            if (isset($tmp[0]) and isset($tmp[0]['last_id'])) {
                $soap_owner = $tmp[0];
            }
        }
        if (is_null($soap_owner)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . "пользователь soap owner не найден.Добавьте его из админки.", "soap");


            $error->message = "пользователь soap owner не найден.Добавьте его из админки.";
            return $error;
        }



        if (!(isset($companies) and is_array($companies) and count($companies) > 0)) {
            $companies = array();
            //  Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр companies должен быть в виде массива', "soap");
            //   $error->message_error = "параметр companies должен быть в виде массива";
            // return $error;
        }

        if (count($companies) > 3) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'параметр companies в нем размер массива должен быть не больше 3', "soap");

            $error->message = "параметр companies в нем размер массива должен быть не больше 3";
            return $error;
        }

        if (count($companies)) {
            $condition = array();
            $condition['$or'] = array();
            foreach ($companies as $company_id) {
                $condition['$or'][] = array("last_id" => (int) $company_id);
            }
            $companies_rows = NoiCore::app()->db()->query(array(), "companys", $condition);
            if (count($companies_rows) == 0) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'компании не найдены', "soap");


                $error->message = "компании не найдены";
                return $error;
            }
        }





        if (!(isset($tasks) and is_array($tasks) and count($tasks) > 0)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр tasks должен быть в виде массива', "soap");


            $error->message = "параметр tasks должен быть в виде массива";
            return $error;
        }

        if (count($tasks) > 5) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'параметр tasks в нем размер массива должен быть не больше 5', "soap");


            $error->message = "параметр tasks в нем размер массива должен быть не больше 5";
            return $error;
        }



//     





        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");


            $error->message = "email неправильный";
            return $error;
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " уже существует", "soap");
            $error->message = "пользователь уже существует";
            return $error;
        } else {
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");
        }


        if (!(isset($adres) and is_string($adres))) {
            $adress = null;
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $adres . " некорректное", "soap");
            // // $error->message = ' Значение ' . $adres . " некорректное,должна быть только строка";
            //  return $error;
        }
        if (!(isset($hobby) and is_string($hobby))) {
            $hobby = null;
            //   Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hobby . " некорректное", "soap");
            // $error->message = ' Значение ' . $hobby . " некорректное,должна быть только строка";
            //  return $error;
        }
        if (!(isset($name) and is_string($name))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name . " некорректное", "soap");
            $error->message = ' Значение ' . $name . " некорректное,должна быть только строка";
            return $error;
        }

        $count_name = NoiCore::app()->db()->count("cms_users", array('name' => $name));
        if ($count_name > 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . " имя " . $name . " уже есть в БД", "soap");


            $error->message = " имя " . $name . " уже есть в БД";
            return $error;
        }
        if (!(isset($name1) and is_string($name1))) {
            $name1 = null;
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name1 . " некорректное", "soap");
            // $error->message = ' Значение ' . $name1 . " некорректное,должна быть только строка";
            // return $error;
        }
        if (!(isset($surname1) and is_string($surname1))) {
            $surname1 = null;
            //Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $surname1 . " некорректное", "soap");
            //$error->message = ' Значение ' . $surname1 . " некорректное,должна быть только строка";
            //return $error;
        }
        if (!(isset($fathername1) and is_string($fathername1))) {
            $fathername1 = null;
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $fathername1 . " некорректное", "soap");
            // $error->message = ' Значение ' . $fathername1 . " некорректное,должна быть только строка";
            // return $error;
        }
        if (!(isset($cat) and is_string($cat))) {
            $cat = null;
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cat . " некорректное", "soap");
            // $error->message = ' Значение ' . $cat . " некорректное,должна быть только строка";
            // return $error;
        }
        if (!(isset($dog) and is_string($dog))) {
            $dog = null;
            //    Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $dog . " некорректное", "soap");
            //  $error->message = ' Значение ' . $dog . " некорректное,должна быть только строка";
            //  return $error;
        }

        if (!(isset($parrot) and is_string($parrot))) {
            $parrot = null;
            //Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $parrot . " некорректное", "soap");
            // $error->message = ' Значение ' . $parrot . " некорректное,должна быть только строка";
            //return $return;
        }

        if (!(isset($cavy) and is_string($cavy))) {
            $cavy = null;
            //   Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cavy . " некорректное", "soap");
            //  $error->message = ' Значение ' . $cavy . " некорректное,должна быть только строка";
            //  return $error;
        }

        if (!(isset($hamster) and is_string($hamster))) {
            $hamster = null;
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hamster . " некорректное", "soap");
            // $error->message = ' Значение ' . $hamster . " некорректное,должна быть только строка";
            //  return $error;
        }

        if (!(isset($squirrel) and is_string($squirrel))) {
            $squirrel = null;
            //  Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $squirrel . " некорректное", "soap");
            //  $error->message = ' Значение ' . $squirrel . " некорректное,должна быть только строка";
            //  return $return;
        }

        if (!(isset($phone) and is_string($phone))) {
            $phone = null;
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $phone . " некорректное", "soap");
            // $error->message = ' Значение ' . $phone . " некорректное,должна быть только строка";
            // return $error;
        }

        if (isset($inn) and is_string($inn) and strlen($inn) > 1) {
            if (is_numeric($inn) and strlen($inn) == 12) {
                
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $inn . " некорректное", "soap");


                $error->message = ' Значение ' . $inn . " ИНН ФЛ должен содержать 12 цифр";
                return $error;
            }
        }

        if (!(bool) strtotime($birthday)) {
            $birthday = null;
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $birthday . " некорректное", "soap");
            //  $error->message = ' Значение ' . $birthday . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ";
            //  return $error;
        }

        if (!(bool) strtotime($date_start)) {
            $date_start = null;
            //Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $date_start . " некорректное", "soap");
            //$error->message = ' Значение ' . $date_start . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ";
            //return $error;
        }

        $new_user = array();
        $new_user['email'] = $email;
        $new_user['name'] = $name;
        if (isset($name1)) {
            $new_user['name1'] = $name1;
        }
        if (isset($hobby)) {
            $new_user['hobby'] = $hobby;
        }
        if (isset($surname1)) {
            $new_user['surname1'] = $surname1;
        }
        if (isset($fathername1)) {
            $new_user['fathername1'] = $fathername1;
        }
        if (isset($cat)) {
            $new_user['cat'] = $cat;
        }
        if (isset($dog)) {
            $new_user['dog'] = $dog;
        }
        if (isset($parrot)) {
            $new_user['parrot'] = $parrot;
        }
        if (isset($cavy)) {
            $new_user['cavy'] = $cavy;
        }
        if (isset($hamster)) {
            $new_user['hamster'] = $hamster;
        }
        if (isset($squirrel)) {
            $new_user['squirrel'] = $squirrel;
        }
        if (isset($phone)) {
            $new_user['phone'] = $phone;
        }
        if (isset($adres)) {
            $new_user['adres'] = $adres;
        }
        if (isset($gender)) {
            $new_user['gender'] = $gender;
        }
        if (isset($date_start)) {
            $new_user['date_start'] = new MongoDate(strtotime($date_start));
        }
        $new_user['date_updated'] = new MongoDate();
        if (isset($birthday)) {
            $new_user['birthday'] = new MongoDate(strtotime($birthday));
        }
        $new_user['role'] = array("user");
        $new_user['date_register'] = new MongoDate();
        $new_user['date'] = date('Y-m-d');
        $new_user['user_active'] = 0;
        $new_user['enable_account'] = 1;
        $new_user['total_deposits'] = 0;
        $new_user['with_vznos'] = 0;
        $new_user['with_outvznos'] = 0;
        $new_user['structure_vznos'] = 0;
        $new_user['user_money'] = 0;
        $new_user['by_user'] = $soap_owner;

        $tasks_rows = array();
        if (!(isset($tasks) and is_array($tasks) and count($tasks) > 0)) {


            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . " tasks должен состоять из массива,который содержит массивы (title=>'задача','description=>'описание')", "soap");
            $error->message = "tasks должен состоять из массива,который содержит массивы (task_title=>'задача','task_description=>'описание')";
            return $error;
        }

        foreach ($tasks as $key => $task) {
            if (!(isset($task['title']) and is_string($task['title']) and strlen($task['title']) > 0)) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' tasks.title не может быть пустым', "soap");


                $error->message = ' tasks.task.task_title не может быть пустым';
                return $return;
            }
            if (!(isset($task['description']) and is_string($task['description']) and strlen($task['description']) > 0)) {
                $tasks[$key]['description'] = "";
            }
        }
        $new_user = NoiCore::app()->db()->insert($new_user, "cms_users", true);
        foreach ($tasks as $task) {
            $array_insert = array();
            $array_insert['date'] = new \MongoDate();
            $array_insert['creator'] = $soap_owner;
            $array_insert['user'] = $new_user;
            $array_insert['name'] = strip_tags($task['title']);
            $array_insert['description'] = strip_tags($task['description']);
            $array_insert = NoiCore::app()->db()->insert($array_insert, "tasks", true);
            $tasks_rows[] = $array_insert;
        }

        if (isset($companies_rows) and count($companies_rows) > 0) {
            foreach ($companies_rows as $company_row) {
                $users = array();
                if (isset($company_row['users'])) {
                    $users = $company_row['users'];
                }
                $users['id_' . $new_user['last_id']] = $new_user;
                $update = array();
                $update['users'] = $users;
                NoiCore::app()->db()->update($update, "companys", array('last_id' => $company_row['last_id']));
            }


            foreach ($companies_rows as $key => $el) {
                $companies_rows[$key] = $el['last_id'];
            }
        } else {
            $companies_rows = array();
        }

        foreach ($tasks_rows as $key => $el) {
            $tasks_rows[$key] = $el['last_id'];
        }


        $new_user['companies'] = $companies_rows;
        $new_user['tasks'] = $tasks_rows;

        foreach ($new_user as $key => $val) {
            if (property_exists('UserReturnTask', $key)) {
                if ($key == "birthday" or $key == "date_start") {
                    $val = date('d.m.Y', $val->sec);
                }

                $return->$key = $val;
            }
        }
        return $return;
    }

    /**
     * @WebMethod
     * @param string $task_title
     * @param string $task_description
     * @param string $email_owner
     * @param string $email_assign
     * @return wrapper $TaskReturn @className=TaskReturn
     */
    public function CreateTask($task_title, $task_description, $email_owner, $email_assign) {
        $taskreturn = new TaskReturn();
        $taskreturn->id_task = 0;
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода CreateTask', "soap");
        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_owner . " некорректный", "soap");



            $taskreturn->message = ' email_owner ' . $email_owner . " некорректный";
            return $taskreturn;
        }
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            $taskreturn->message = 'Пользователь не найден c email_owner ' . $email_owner;
            return $taskreturn;
        }

        if (!(isset($email_assign) and is_string($email_assign) and filter_var($email_assign, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_assign . " некорректный", "soap");

            $taskreturn->message = "email_owner неправильный!";
            return $taskreturn;
        }
        $email_assign = strtolower($email_assign);
        $assigns = NoiCore::app()->db()->query(array(), "cms_users", array('email' => $email_assign));

        if (isset($assigns[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_assign ' . $email_assign . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_assign ' . $email_assign, "soap");

            $taskreturn->message = 'Пользователь не найден c email_assign ' . $email_assign;
            return $taskreturn;
        }
        if (!(isset($task_title) and is_string($task_title) and strlen($task_title))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_title имеет  неверное значение', "soap");
            $taskreturn->message = ' Параметр task_title имеет  неверное значение';
            return $taskreturn;
        }
        if (!(isset($task_description) and is_string($task_description) and strlen($task_description))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_description имеет  неверное значение', "soap");
            $taskreturn->message = ' Параметр task_description имеет  неверное значение';
            return $taskreturn;
        }
        $array_insert = array();
        $array_insert['date'] = new \MongoDate();
        $array_insert['creator'] = $owners[0];
        $array_insert['user'] = $assigns[0];
        $array_insert['name'] = strip_tags($task_title);
        $array_insert['description'] = strip_tags($task_description);
        $array_insert = NoiCore::app()->db()->insert($array_insert, "tasks", true);
        $taskreturn = new TaskReturn();
        $taskreturn->id_task = $array_insert['last_id'];
        $taskreturn->message = "Задача успешно создана!";
        return $taskreturn;
    }

    /**
     * @WebMethod
     * @param string $email
     * @return string  $result
     */
    public function DeleteUser($email) {
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода DeleteUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");

            return "email неправильный!";
        }
        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

            return "Пользователь с таким email не найден!";
        }
        NoiCore::app()->db()->delete("cms_users", array('email' => strtolower($email)));
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно удален", "soap");

        return "Пользователь с email " . $email . " успешно удален";
    }

    /**
     * @WebMethod
     * @param string $email
     * @param string $field
     * @param string $value

     * @return string  $result
     */
    public function UpdateUserOneField($email, $field, $value) {
        $array_of_fields = array();

        $available_fields = array('hobby', 'name', 'name1', 'surname1', 'fathername1', 'cat', 'dog', 'parrot', 'cavy', 'hamster', 'squirrel', 'phone', 'adres', 'birthday', 'gender', 'date_start', 'inn');
        if (!(isset($field) and is_string($field) and in_array($field, $available_fields))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Название Поля неверное', "soap");

            return 'Название поля ' . $field . ' неверное .Доступные поля ' . implode(",", $available_fields);
        }

        if (!(isset($value) and is_string($value))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");

            return ' Значение ' . $value . " некорректное,должна быть только строка";
        }
        if ($field == "gender" and $value != "m" and $value != "f") {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");

            return ' Значение ' . $value . " некорректное,должна быть либо m либо f";
        }
        if (($field == "birthday" or $field == "date_start") and ! (bool) strtotime($value)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");

            return ' Значение ' . $value . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ";
        }
        if ($field == "inn") {
            if (isset($value) and is_string($value) and strlen($value) > 1) {
                if (is_numeric($value) and strlen($value) == 12) {
                    
                } else {
                    Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");

                    return ' Значение ' . $value . " некорректное,ИНН ФЛ должен содержать 12 цифр";
                }
            }
        }




        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");

            return "email неправильный!";
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

            return "Пользователь с таким email не найден!";
        }





        $update = array();
        $update[$field] = $value;
        if ($field == "birthday" or $field == "date_start") {
            $update[$field] = new MongoDate(strtotime($value));
        }



        // $update[$field]=$value;
        NoiCore::app()->db()->update($update, "cms_users", array('email' => $email));
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . "Поле " . $field . " успешно изменено на " . $value . " у пользователя с email " . $email, "soap");

        return "Поле " . $field . " успешно изменено на " . $value . " у пользователя с email " . $email;
    }

    /**
     * @WebMethod
     * @param string $email
     * @param string $hobby
     * @param string $name
     * @param string $name1
     * @param string $surname1
     * @param string $fathername1
     * @param string $cat
     * @param string $dog
     * @param string $parrot
     * @param string $cavy
     * @param string $hamster
     * @param string $squirrel
     * @param string $phone
     * @param string $adres
     * @param string $gender
     * @param string $birthday
     * @param string $date_start
     * @param string $inn
     * @return wrapper $userReturn @className=UserReturn
     */
    public function FullUpdateUser($email, $hobby, $name, $name1, $surname1, $fathername1, $cat, $dog, $parrot, $cavy, $hamster, $squirrel, $phone, $adres, $gender, $birthday, $date_start, $inn) {
        $domain = $_SERVER['HTTP_HOST'];
        $array_of_fields = array();

        $available_fields = array('hobby', 'name', 'name1', 'surname1', 'fathername1', 'cat', 'dog', 'parrot', 'cavy', 'hamster', 'squirrel', 'phone', 'adres');
        $values = func_get_args();
        if (isset($values[0])) {
            unset($values[0]);
            array_values($values);
        }

        if ($gender != "m" and $gender != "f") {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $gender . " некорректное", "soap");

            return ' Значение ' . $gender . " некорректное,должна быть либо m либо f";
        }

        if (!(bool) strtotime($birthday)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $birthday . " некорректное", "soap");

            return ' Значение ' . $birthday . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ";
        }

        if (!(bool) strtotime($date_start)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $date_start . " некорректное", "soap");

            return ' Значение ' . $date_start . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ";
        }

        if (count($values) == 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Вы не ввели значения для всех полей', "soap");
            $result = new stdClass();
            $result->type = "error";
            $result->message = 'Вы не ввели значения для всех полей';
            return $result;
        }
        if (count($values)) {
            foreach ($values as $value) {
                if (!(isset($value) and is_string($value))) {
                    Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");
                    $result = new stdClass();
                    $result->type = "error";
                    $result->message = ' Значение ' . $value . " некорректное,должна быть только строка";
                    return $result;
                }
            }
        }


        if (isset($inn) and is_string($inn) and strlen($inn) > 1) {
            if (is_numeric($inn) and strlen($inn) == 12) {
                
            } else {

                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $inn . " ИНН ФЛ должен содержать 12 цифр", "soap");
                $result = new stdClass();
                $result->type = "error";
                $result->message = ' Значение ' . $inn . " ИНН ФЛ должен содержать 12 цифр";
                return $result;
            }
        }



        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");
            $result = new stdClass();
            $result->type = "error";
            $result->message = "email неправильный!";
            return $result;
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");
            $result = new stdClass();
            $result->type = "error";
            $result->message = "Пользователь с таким email не найден!";
            return $result;
        }





        $update = array();
        $update['name'] = $name;
        $update['name1'] = $name1;
        $update['hobby'] = $hobby;
        $update['surname1'] = $surname1;
        $update['fathername1'] = $fathername1;
        $update['cat'] = $cat;
        $update['dog'] = $dog;
        $update['parrot'] = $parrot;
        $update['cavy'] = $cavy;
        $update['hamster'] = $hamster;
        $update['squirrel'] = $squirrel;
        $update['phone'] = $phone;
        $update['adres'] = $adres;
        $update['gender'] = $gender;
        $update['date_start'] = new MongoDate(strtotime($date_start));
        $update['birthday'] = new MongoDate(strtotime($birthday));



        // $update[$field]=$value;
        NoiCore::app()->db()->update($update, "cms_users", array('email' => $email));
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . "Пользователь с  email " . $email . " обновлен", "soap");
        $query = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email)));
        $newuser = $query[0];
        $userreturn = new UserReturn();
        $userreturn->name = $newuser['name'];
        $userreturn->avatar = "http://" . $domain . "/" . $newuser['avatar'];
        $userreturn->email = $newuser['email'];
        $userreturn->password = $newuser['password'];
        $userreturn->birthday = 0;
        if (isset($newuser['birthday']->sec)) {
            $userreturn->birthday = date('d.m.Y', $newuser['birthday']->sec);
        }
        $userreturn->gender = "";
        if (isset($newuser['gender'])) {
            $userreturn->gender = $newuser['gender'];
        }
        $userreturn->date_start = 0;
        if (isset($newuser['date_start']->sec)) {
            $userreturn->date_start = date('d.m.Y', $newuser['date_start']->sec);
        }
        $userreturn->hobby = "";
        if (isset($newuser['hobby'])) {
            $userreturn->hobby = "";
        }
        if (isset($newuser['name1'])) {
            $userreturn->name1 = $newuser['name1'];
        }
        if (isset($newuser['surname1'])) {
            $userreturn->surname1 = $newuser['surname1'];
        }
        if (isset($newuser['fathername1'])) {
            $userreturn->fathername1 = $newuser['fathername1'];
        }

        if (isset($newuser['cat'])) {
            $userreturn->cat = $newuser['cat'];
        }
        if (isset($newuser['dog'])) {
            $userreturn->dog = $newuser['dog'];
        }
        if (isset($newuser['parrot'])) {
            $userreturn->parrot = $newuser['parrot'];
        }
        if (isset($newuser['cavy'])) {
            $userreturn->cavy = $newuser['cavy'];
        }
        if (isset($newuser['hamster'])) {
            $userreturn->hamster = $newuser['hamster'];
        }
        if (isset($newuser['squirrel'])) {
            $userreturn->squirrel = $newuser['squirrel'];
        }
        if (isset($newuser['phone'])) {
            $userreturn->phone = $newuser['phone'];
        }
        if (isset($newuser['adres'])) {
            $userreturn->adres = $newuser['adres'];
        }
        if (isset($newuser['inn'])) {
            $userreturn->inn = $newuser['inn'];
        }
        return $userreturn;
    }

    /**
     * @WebMethod
     * @param string $email
     * @param string $password
     * @return bool  $result
     */
    public function doLogin($email, $password) {
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода doLogin', "soap");

        $result = false;

        if (isset($email) and isset($password) and is_string($password) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email), 'password' => hash("sha512", $password)));
            if ($count == 1) {
                Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
                return true;
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

                return false;
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Переменные email и password неправильные', "soap");
            return false;
        }
    }

    /**
     * @WebMethod
     * @param int $id_company
     * @return wrapper $companyReturn @className=CompanyReturn
     */
    public function getCompany($id_company) {
        $error_return = new ErrorReturn();
        $domain = $_SERVER['HTTP_HOST'];
        $result = false;
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода getCompany', "soap");

        $condition = array();
        $condition['$or'] = array();
        $condition['$or'][] = array("name" => (string) $id_company);
        $condition['$or'][] = array("inn" => (string) $id_company);
        $condition['$or'][] = array("last_id" => (int) $id_company);

        $query = NoiCore::app()->db()->query(array(), "companys", $condition);
        if (isset($query[0]['_id'])) {
            $result = $query[0];
        }
        if (is_array($result)) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Кампания с ID ' . $id_company . " успешно найден", "soap");

            $newuser = $query[0];
            $userreturn = new CompanyReturn();
            $userreturn->name = $result['name'];
            $userreturn->type = $result['type'];
            $userreturn->inn = $result['inn'];
            $userreturn->kpp = $result['kpp'];
            $userreturn->ogrn = $result['ogrn'];
            $userreturn->phone = $result['phone'];
            $userreturn->adress = $result['adress'];
            $userreturn->id_company = $result['last_id'];


            $users = array();
            if (isset($result['users']) and count($result['users']) > 0) {
                foreach ($result['users'] as $user) {
                    $users[] = $user['email'];
                }
            }
            $userreturn->users = $users;
            return $userreturn;
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' компания не найдена', "soap");
            $result = new stdClass();
            $result->type = "error";
            $error_return->message = "компания не найдена";
            return $error_return;
        }
    }

    /**
     * @WebMethod
     * @param string $email
     * @return wrapper $userReturnFull @className=UserReturnFull
     */
    public function getUserFull($email) {
        $domain = $_SERVER['HTTP_HOST'];
        $result = false;
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода getUser', "soap");

        if (isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email)));

            if (isset($query[0]['_id'])) {
                Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
                $tasks = NoiCore::app()->db()->query2(array(), "tasks", array('user.last_id' => $query[0]['last_id']));
                $newtasks = array();
                if (isset($tasks[0]['last_id'])) {
                    foreach ($tasks as $task) {
                        $newtasks[] = array("name" => $task['name'], "id_task" => $task['last_id']);
                    }
                    $tasks = $newtasks;
                }

                $companys = NoiCore::app()->db()->query2(array(), "companys", array('users.id_' . $query[0]['last_id'] . ".last_id" => $query[0]['last_id']));

                $newcompanys = array();
                if (isset($companys[0]['last_id'])) {
                    foreach ($companys as $company) {
                        $newcompanys[] = array("name" => $company['name'], "id_company" => $company['last_id']);
                    }
                    $companys = $newcompanys;
                }


                $newuser = $query[0];
                $userreturn = new UserReturnFull();
                $userreturn->name = $newuser['name'];
                $userreturn->avatar = "http://" . $domain . "/" . $newuser['avatar'];
                $userreturn->email = $newuser['email'];
                $userreturn->password = $newuser['password'];
                $userreturn->birthday = 0;
                if (isset($newuser['birthday']->sec)) {
                    $userreturn->birthday = date('d.m.Y', $newuser['birthday']->sec);
                }
                $userreturn->gender = "";
                if (isset($newuser['gender'])) {
                    $userreturn->gender = $newuser['gender'];
                }
                $userreturn->date_start = 0;
                if (isset($newuser['date_start']->sec)) {
                    $userreturn->date_start = date('d.m.Y', $newuser['date_start']->sec);
                }
                $userreturn->hobby = "";
                if (isset($newuser['hobby'])) {
                    $userreturn->hobby = "";
                }
                if (isset($newuser['name1'])) {
                    $userreturn->name1 = $newuser['name1'];
                }
                if (isset($newuser['surname1'])) {
                    $userreturn->surname1 = $newuser['surname1'];
                }
                if (isset($newuser['fathername1'])) {
                    $userreturn->fathername1 = $newuser['fathername1'];
                }

                if (isset($newuser['cat'])) {
                    $userreturn->cat = $newuser['cat'];
                }
                if (isset($newuser['dog'])) {
                    $userreturn->dog = $newuser['dog'];
                }
                if (isset($newuser['parrot'])) {
                    $userreturn->parrot = $newuser['parrot'];
                }
                if (isset($newuser['cavy'])) {
                    $userreturn->cavy = $newuser['cavy'];
                }
                if (isset($newuser['hamster'])) {
                    $userreturn->hamster = $newuser['hamster'];
                }
                if (isset($newuser['squirrel'])) {
                    $userreturn->squirrel = $newuser['squirrel'];
                }
                if (isset($newuser['phone'])) {
                    $userreturn->phone = $newuser['phone'];
                }
                if (isset($newuser['adres'])) {
                    $userreturn->adres = $newuser['adres'];
                }

                $userreturn->tasks = $tasks;
                $userreturn->companys = $companys;
                return $userreturn;
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");
                $result = new stdClass();
                $result->type = "error";
                $result->message = ' Пользователь не найден ' . $email;
                return $result;
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Переменные email и password неправильные', "soap");
            $result = new stdClass();
            $result->type = "error";
            $result->message = "Вы ввели неправильный email";
            return $result;
        }
    }

    /**
     * @WebMethod
     * @param string $email
     * @return wrapper $userReturn @className=UserReturn
     */
    public function getUser($email) {
        $domain = $_SERVER['HTTP_HOST'];
        $result = false;
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода getUser', "soap");

        if (isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email)));

            if (isset($query[0]['_id'])) {
                Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");

                $newuser = $query[0];
                $userreturn = new UserReturn();
                $userreturn->name = $newuser['name'];
                $userreturn->avatar = "http://" . $domain . "/" . $newuser['avatar'];
                $userreturn->email = $newuser['email'];
                $userreturn->password = $newuser['password'];
                $userreturn->birthday = 0;
                if (isset($newuser['birthday']->sec)) {
                    $userreturn->birthday = date('d.m.Y', $newuser['birthday']->sec);
                }
                $userreturn->gender = "";
                if (isset($newuser['gender'])) {
                    $userreturn->gender = $newuser['gender'];
                }
                $userreturn->date_start = 0;
                if (isset($newuser['date_start']->sec)) {
                    $userreturn->date_start = date('d.m.Y', $newuser['date_start']->sec);
                }
                $userreturn->hobby = "";
                if (isset($newuser['hobby'])) {
                    $userreturn->hobby = "";
                }
                if (isset($newuser['name1'])) {
                    $userreturn->name1 = $newuser['name1'];
                }
                if (isset($newuser['surname1'])) {
                    $userreturn->surname1 = $newuser['surname1'];
                }
                if (isset($newuser['fathername1'])) {
                    $userreturn->fathername1 = $newuser['fathername1'];
                }

                if (isset($newuser['cat'])) {
                    $userreturn->cat = $newuser['cat'];
                }
                if (isset($newuser['dog'])) {
                    $userreturn->dog = $newuser['dog'];
                }
                if (isset($newuser['parrot'])) {
                    $userreturn->parrot = $newuser['parrot'];
                }
                if (isset($newuser['cavy'])) {
                    $userreturn->cavy = $newuser['cavy'];
                }
                if (isset($newuser['hamster'])) {
                    $userreturn->hamster = $newuser['hamster'];
                }
                if (isset($newuser['squirrel'])) {
                    $userreturn->squirrel = $newuser['squirrel'];
                }
                if (isset($newuser['phone'])) {
                    $userreturn->phone = $newuser['phone'];
                }
                if (isset($newuser['adres'])) {
                    $userreturn->adres = $newuser['adres'];
                }

                if (isset($newuser['inn'])) {
                    $userreturn->inn = $newuser['inn'];
                }


                return $userreturn;
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");
                $result = new stdClass();
                $result->type = "error";
                $result->message = ' Пользователь не найден ' . $email;
                return $result;
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Переменные email и password неправильные', "soap");
            $result = new stdClass();
            $result->type = "error";
            $result->message = "Вы ввели неправильный email";
            return $result;
        }
    }

    /**
     * @WebMethod
     * @param string $email
     * @param string $name
     * @param string $password
     * @return wrapper $userReturn @className=UserReturn
     */
    public function doRegister($email, $name, $password) {
        $domain = $_SERVER['HTTP_HOST'];
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода doRegister', "soap");

        if (isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
            if ($count == 0) {
                if (isset($name) and is_string($name) and strlen($name) > 0) {
                    $count_name = NoiCore::app()->db()->count("cms_users", array('name' => $name));
                    if ($count_name == 0) {
                        if (isset($name) and is_string($name) and strlen($name) > 0) {
                            $array_insert = array();
                            $array_insert['name'] = strip_tags($name);
                            $array_insert['password'] = hash("sha512", $password);
                            $array_insert['email'] = $email;
                            $array_insert['role'] = array('user');
                            $array_insert['date_register'] = new MongoDate();
                            $array_insert['date'] = date('Y-m-d');
                            $array_insert['user_active'] = 0;
                            $array_insert['enable_account'] = 1;
                            $array_insert['avatar'] = "/tmp/default_avatar.jpg";
                            $array_insert['user_money'] = 0;
                            $array_insert['date_updated'] = new MongoDate();
                            $array_insert['by_user'] = array('name' => 'soap', 'email' => 'soap');
                            $newuser = NoiCore::app()->db()->insert($array_insert, "cms_users", true);

                            if (isset($newuser['last_id'])) {
                                $userreturn = new UserReturn();
                                $userreturn->name = $newuser['name'];
                                $userreturn->avatar = "http://" . $domain . "/" . $newuser['avatar'];
                                $userreturn->password = $newuser['password'];
                                $userreturn->birthday = 0;
                                $userreturn->email = $newuser['email'];
                                if (isset($newuser['birthday']->sec)) {
                                    $userreturn->birthday = $newuser['birthday']->sec;
                                }
                                $userreturn->gender = "";
                                if (isset($newuser['gender'])) {
                                    $userreturn->gender = $newuser['gender'];
                                }
                                $userreturn->date_start = 0;
                                if (isset($newuser['date_start']->sec)) {
                                    $userreturn->date_start = $newuser['date_start']->sec;
                                }
                                $userreturn->hobby = "";
                                if (isset($newuser['hobby'])) {
                                    $userreturn->hobby = "";
                                }
                                return $userreturn;
                            } else {
                                $result = new stdClass();
                                $result->type = "error";
                                $result->code = 0;
                                $result->message = ' Пользователь не был создан,произошла ошибка! ';
                                return $result;
                            }
                        } else {
                            $result = new stdClass();
                            $result->type = "error";
                            $result->code = 0;
                            $result->message = 'Поле name должно быть больше нуля ';
                            return $result;
                        }
                    } else {
                        Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Текущее ФИО ' . $name . " уже есть в базе", "soap");
                        $result = new stdClass();
                        $result->type = "error";
                        $result->code = 0;
                        $result->message = ' Текущее ФИО ' . $name . " уже есть в базе";
                        return $result;
                    }
                } else {
                    Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' поле фио является обязательным ', "soap");

                    $result = new stdClass();
                    $result->type = "error";
                    $result->code = 0;
                    $result->message = 'поле фио является обязательным';
                    return $result;
                }
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email ' . $email . " уже есть в базе", "soap");
                $result = new stdClass();
                $result->type = "error";
                $result->code = 0;
                $result->message = ' email ' . $email . " уже есть в базе";
                return $result;
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Некоректный  email' . $email . "", "soap");
            $result = new stdClass();
            $result->type = "error";
            $result->code = 0;
            $result->message = ' Некоректный  email ' . $email;
            return $result;
        }
    }

}
