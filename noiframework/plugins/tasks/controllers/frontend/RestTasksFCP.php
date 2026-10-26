<?php

use yii\web\UploadedFile;

class RestTasksFCP extends CoreFrontendControllerPlugin {

    public function __construct($route, &$cur) {
        parent::__construct("tasks", $cur, $route);
    }

    public function actionIndex($name_method) {
        $error = array();
        $error['type'] = "error";
        $name_method = strtolower($name_method);
        $error['message'] = "Метод не существует.Доступные методы для вызова deletetask,addtaskincron,updatetask,createtask,deleteuser,updateUseronefield,fullupdateuser,dologin,getuser,doregister";
        $method = "rest" . lcfirst($name_method);
        if (method_exists($this, $method)) {
            $result = $this->$method();
            if (isset($_SERVER["CONTENT_TYPE"]) and $_SERVER["CONTENT_TYPE"] == "application/xml") {
                return $this->xml($result);
            } else {
                return $this->json($result);
            }
        } else {
            return $this->json($error);
        }
    }

    public function param($key, $isfile = false, $check = true) {
        if (!$isfile) {
            $entityBody = file_get_contents('php://input');



            $jsonobj = json_decode($entityBody, true);

            $result = null;
            if (isset($_GET[$key])) {
                return $_GET[$key];
            }
            if (isset($_POST[$key])) {
                return $_POST[$key];
            }
            if (isset($jsonobj[$key])) {
                return $jsonobj[$key];
            }
            try {
                $xml = simplexml_load_string($entityBody, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);
                if (isset($array) and is_array($array)) {
                    if (isset($array[$key])) {
                        return $array[$key];
                    }
                }
            } catch (\Exception $e) {
                
            }
        } else {
            if (isset($_FILES[$key])) {
                return $_FILES[$key];
            }
        }
        if ($check == true) {

            echo $this->json($this->toArr("Параметр " . $key . " является обязательным!"));
            exit;
        } else {
            return null;
        }
        return $result;
    }

    public function restDeletetask() {
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода DeleteTask', "rest");
        $email_owner = $this->param("email_owner");
        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . " email_owner  некорректный", "rest");


            $error = array();
            $error['type'] = "error";
            $error['message'] = ' email_owner  это обязательный параметр';

            return $error;
        }
        $task_id = $this->param("task_id");
        if (!(isset($task_id) and is_string($task_id) and is_numeric($task_id))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' task_id  некорректный', "rest");


            $error = array();
            $error['type'] = "error";
            $error['message'] = ' task_id это обязательный параметр  некорректный';

            return $error;
        }
        $email_owner = strtolower($email_owner);
        $id_task = (int) $task_id;
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "rest");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "rest");
            $error = array();
            $error['type'] = "error";
            $error['message'] = 'Пользователь не найден c email_owner ' . $email_owner;

            return $error;
        }
        $tasks = NoiCore::app()->db()->query(array(), "tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        if (!isset($tasks[0]['_id'])) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " не найдена", "rest");
            $error = array();
            $error['type'] = "error";
            $error['message'] = ' Задача с ID ' . $id_task . " не найдена";

            return $error;
        }

        NoiCore::app()->db()->delete("tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " успешно удалена", "rest");
        $error = array();
        $error['type'] = "success";
        $error['message'] = ' Задача с ID ' . $id_task . " успешно удалена";

        return $error;
    }

    public function restAddTaskincron() {
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода AddTaskInCron', "rest");
        $email_owner = $this->param("email_owner");
        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner  это обязательный параметр', "rest");


            $error = array();
            $error['type'] = "error";
            $error['message'] = ' email_owner  это обязательный параметр';

            return $error;
        }
        $task_id = $this->param("task_id");
        if (!(isset($task_id) and is_string($task_id) and is_numeric($task_id))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' task_id  это обязательный параметр', "rest");


            $error = array();
            $error['type'] = "error";
            $error['message'] = 'task_id  это обязательный параметр';

            return $error;
        }
        $id_task = (int) $task_id;
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "rest");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "rest");

            return $this->toArr('Пользователь не найден c email_owner ' . $email_owner);
        }
        $tasks = NoiCore::app()->db()->query(array(), "tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        if (!isset($tasks[0]['_id'])) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " не найдена", "rest");

            return $this->toArr(' Задача с ID ' . $id_task . " не найдена");
        }

        $hours = $this->param("hours");
        $minutes = $this->param("minutes");
        $month = $this->param("month");
        $days = $this->param("days");
        $day_weeks = $this->param("day_weeks");


        if (isset($hours) and ( $hours == "*" or ( is_numeric($hours) and (int) $hours >= 1 and (int) $hours < 25))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' hours имеет неправильное значение ', "rest");
            return $this->toArr("hours имеет неправильное значение");
        }

        if (isset($minutes) and ( $minutes == "*" or ( is_numeric($minutes) and (int) $minutes >= 0 and (int) $minutes < 61))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' minutes имеет неправильное значение ', "soap");
            return $this->toArr("minutes имеет неправильное значение");
        }

        if (isset($month) and ( $month == "*" or ( is_numeric($month) and (int) $month > 0 and (int) $month < 13))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' month имеет неправильное значение ', "soap");
            return $this->toArr("month имеет неправильное значение");
        }

        if (isset($days) and ( $days == "*" or ( is_numeric($days) and (int) $days > 0 and (int) $days < 32))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' days имеет неправильное значение ', "soap");
            return $this->toArr("days имеет неправильное значение");
        }
        if (isset($day_weeks) and ( $day_weeks == "*" or ( is_numeric($day_weeks) and (int) $day_weeks > 0 and (int) $day_weeks < 8))) {
            
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' day_weeks имеет неправильное значение ', "soap");
            return $this->toArr("day_weeks имеет неправильное значение");
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
        return $this->toArr("Расписание успешно добавлено в задачу " . $id_task . " Следущая дата запуска " . date('d.m.Y H:i', $nexttime), "success");
    }

    public function restUpdatetask() {
        $email_owner = $this->param("email_owner");
        $email_assign = $this->param("email_assign");
        $id_task = $this->param("id_task");
        $task_title = $this->param('task_title');
        $task_description = $this->param("task_description");

        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateTask', "rest");

        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_owner . " некорректный", "soap");



            return $this->toArr(' email_owner ' . $email_owner . " некорректный");
        }
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            return $this->toArr('Пользователь не найден c email_owner ' . $email_owner);
        }


        if (!(isset($email_assign) and is_string($email_assign) and filter_var($email_assign, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_assign ' . $email_assign . " некорректный", "soap");



            return $this->toArr(' email_assign ' . $email_owner . " некорректный");
        }
        $email_assign = strtolower($email_assign);
        $assigns = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_assign)));
        if (isset($assigns[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_assign ' . $email_assign . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_assign ' . $email_assign, "soap");

            return $this->toArr('Пользователь не найден c email_assign ' . $email_owner);
        }


        $count = NoiCore::app()->db()->count("tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        if ($count == 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Задача с ID ' . $id_task . " не найдена", "soap");

            return $this->toArr(' Задача с id_task ' . $id_task . " не найдена");
        }
        if (!(isset($task_title) and is_string($task_title) and strlen($task_title))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_title имеет  неверное значение', "soap");
            return $this->toArr(' Параметр task_title имеет  неверное значение');
        }
        if (!(isset($task_description) and is_string($task_description) and strlen($task_description))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_description имеет  неверное значение', "soap");
            return $this->toArr(' Параметр task_description имеет  неверное значение');
        }
        $update = array();
        $update['name'] = strip_tags($task_title);
        $update['user'] = $assigns[0];
        $update['description'] = strip_tags($task_description);
        NoiCore::app()->db()->update($update, "tasks", array('creator.email' => $email_owner, 'last_id' => (int) $id_task));
        return $this->toArr("Задача успешно изменена!", "success");
    }

    public function restDeleteuser() {
        $email = $this->param("email");
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода DeleteUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");

            return $this->toArr("email неправильный!");
        }
        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

            return $this->toArr("Пользователь с таким email не найден!");
        }
        NoiCore::app()->db()->delete("cms_users", array('email' => strtolower($email)));
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно удален", "soap");

        return $this->toArr("Пользователь с email " . $email . " успешно удален");
    }

    public function restDologin() {
        $array_no = array();
        $array_no['result'] = false;
        $array_yes = array();
        $array_yes['result'] = true;
        $email = $this->param("email");
        $password = $this->param("password");
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода doLogin', "soap");

        $result = false;

        if (isset($email) and isset($password) and is_string($password) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email), 'password' => hash("sha512", $password)));
            if ($count == 1) {
                Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
                return $array_yes;
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

                return $array_no;
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Переменные email и password неправильные', "soap");
            return $array_no;
        }
    }

    public function restGetcompany() {
        $id_company = $this->param("id_company");
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
            if (isset($result['_id'])) {
                unset($result['_id']);
            }

            if (isset($result['creator'])) {
                unset($result['creator']);
            }
            if (isset($result['last_id'])) {
                $result['id_company'] = $result['last_id'];
                unset($result['last_id']);
            }

            if (isset($result['date'])) {
                unset($result['date']);
            }

            if (isset($result['date_update'])) {
                unset($result['date_update']);
            }

            if (isset($result['site_id'])) {
                unset($result['site_id']);
            }

            if (isset($result['order_last_id'])) {
                unset($result['order_last_id']);
            }


            return $result;
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Компания с  id_company =  ' . $id_company . " не найдена", "soap");
            return $this->toArr(' Компания с  id_company =  ' . $id_company . " не найдена");
        }
    }

    public function restGetuser() {
        $email = $this->param("email");
        $domain = $_SERVER['HTTP_HOST'];
        $result = false;
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода getUser', "soap");

        if (isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email)));

            if (isset($query[0]['_id'])) {
                Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");

                $newuser = $query[0];
                $userreturn = array();
                $userreturn['name'] = $newuser['name'];
                $userreturn['avatar'] = "http://" . $domain . "/" . $newuser['avatar'];
                $userreturn['email'] = $newuser['email'];
                $userreturn['password'] = $newuser['password'];
                $userreturn['birthday'] = 0;
                if (isset($newuser['birthday']->sec)) {
                    $userreturn['birthday'] = date('d.m.Y', $newuser['birthday']->sec);
                }
                $userreturn['gender'] = "";
                if (isset($newuser['gender'])) {
                    $userreturn['gender'] = $newuser['gender'];
                }
                $userreturn['date_start'] = 0;
                if (isset($newuser['date_start']->sec)) {
                    $userreturn['date_start'] = date('d.m.Y', $newuser['date_start']->sec);
                }
                $userreturn['hobby'] = "";
                if (isset($newuser['hobby'])) {
                    $userreturn['hobby'] = "";
                }
                if (isset($newuser['name1'])) {
                    $userreturn['name1'] = $newuser['name1'];
                }
                if (isset($newuser['surname1'])) {
                    $userreturn['surname1'] = $newuser['surname1'];
                }
                if (isset($newuser['fathername1'])) {
                    $userreturn['fathername1'] = $newuser['fathername1'];
                }

                if (isset($newuser['cat'])) {
                    $userreturn['cat'] = $newuser['cat'];
                }
                if (isset($newuser['dog'])) {
                    $userreturn['dog'] = $newuser['dog'];
                }
                if (isset($newuser['parrot'])) {
                    $userreturn['parrot'] = $newuser['parrot'];
                }
                if (isset($newuser['cavy'])) {
                    $userreturn['cavy'] = $newuser['cavy'];
                }
                if (isset($newuser['hamster'])) {
                    $userreturn['hamster'] = $newuser['hamster'];
                }
                if (isset($newuser['squirrel'])) {
                    $userreturn['squirrel'] = $newuser['squirrel'];
                }
                if (isset($newuser['phone'])) {
                    $userreturn['phone'] = $newuser['phone'];
                }
                if (isset($newuser['adres'])) {
                    $userreturn['adres'] = $newuser['adres'];
                }
                if (isset($newuser['inn'])) {
                    $userreturn['inn'] = $newuser['inn'];
                }
                return $userreturn;
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

                return $this->toArr(' Пользователь не найден ' . $email);
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Переменные email и password неправильные', "soap");
            return $this->toArr("Вы ввели неправильный email");
        }
    }

    public function restGetuserfull() {
        $email = $this->param("email");
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
                $userreturn = array();
                $userreturn['name'] = $newuser['name'];
                $userreturn['avatar'] = "http://" . $domain . "/" . $newuser['avatar'];
                $userreturn['email'] = $newuser['email'];
                $userreturn['password'] = $newuser['password'];
                $userreturn['birthday'] = 0;

                if (isset($newuser['birthday']->sec)) {
                    $userreturn['birthday'] = date('d.m.Y', $newuser['birthday']->sec);
                }
                $userreturn['gender'] = "";
                if (isset($newuser['gender'])) {
                    $userreturn['gender'] = $newuser['gender'];
                }
                $userreturn['date_start'] = 0;
                if (isset($newuser['date_start']->sec)) {
                    $userreturn['date_start'] = date('d.m.Y', $newuser['date_start']->sec);
                }
                $userreturn['hobby'] = "";
                if (isset($newuser['hobby'])) {
                    $userreturn['hobby'] = "";
                }
                if (isset($newuser['name1'])) {
                    $userreturn['name1'] = $newuser['name1'];
                }
                if (isset($newuser['surname1'])) {
                    $userreturn['surname1'] = $newuser['surname1'];
                }
                if (isset($newuser['fathername1'])) {
                    $userreturn['fathername1'] = $newuser['fathername1'];
                }

                if (isset($newuser['cat'])) {
                    $userreturn['cat'] = $newuser['cat'];
                }
                if (isset($newuser['dog'])) {
                    $userreturn['dog'] = $newuser['dog'];
                }
                if (isset($newuser['parrot'])) {
                    $userreturn['parrot'] = $newuser['parrot'];
                }
                if (isset($newuser['cavy'])) {
                    $userreturn['cavy'] = $newuser['cavy'];
                }
                if (isset($newuser['hamster'])) {
                    $userreturn['hamster'] = $newuser['hamster'];
                }
                if (isset($newuser['squirrel'])) {
                    $userreturn['squirrel'] = $newuser['squirrel'];
                }
                if (isset($newuser['phone'])) {
                    $userreturn['phone'] = $newuser['phone'];
                }
                if (isset($newuser['adres'])) {
                    $userreturn['adres'] = $newuser['adres'];
                }
                if (isset($newuser['inn'])) {
                    $userreturn['inn'] = $newuser['inn'];
                }

                $userreturn['tasks'] = $tasks;
                $userreturn['companys'] = $companys;
                return $userreturn;
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

                return $this->toArr(' Пользователь не найден ' . $email);
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Переменные email и password неправильные', "soap");
            return $this->toArr("Вы ввели неправильный email");
        }
    }

    public function restAddAvatar() {
        $email = $this->param("email");
        $user_found = null;

        $user_datas = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email)));
        if (isset($user_datas[0]['last_id'])) {
            $user_found = $user_datas[0];
        }

        if (isset($user_found) and is_array($user_found)) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $user_found['email'] . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

            return $this->toArr("Пользователь с таким email не найден!");
        }

        $avatar = $this->param("avatar", true);
        //  $avatar_data = fopen("php://input", "r");
//        if (!(isset($avatar_data))) {
//            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'Вы не загрузили аватар ', "soap");
//
//            return $this->toArr("Вы не загрузили аватар ");
//        }
//
//        /* Открываем файл на запись */
//        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/tmp/files/avatar_" . $user_found['last_id'] . ".jpg", "w");
//
//        /* Читаем 1 KB данных за один раз
//          и пишем в файл */
//        while ($data = fread($avatar_data, 1024))
//            fwrite($fp, $data);
//
//        /* Закрываем потоки */
//        fclose($fp);
//        fclose($avatar_data);
//        $update = array();
//        $update['avatar'] = "/tmp/files/avatar_" . $user_found['last_id'] . ".jpg";
//        NoiCore::app()->db()->update($update, "cms_users", array("last_id" => $user_found['last_id']));
//        return array("status" => 'ok');

        $uploadimage = new \user\models\UploadImage();

        if (Yii::$app->request->isPost) {
            $uploadimage->avatar = UploadedFile::getInstanceByName('avatar');
            $avatar = $uploadimage->upload();

            if (!is_bool($avatar)) {
                $update = array();
                $update['avatar'] = $avatar;
                NoiCore::app()->db()->update($update, "cms_users", array("email" => strtolower($email)));
                return array("status" => 'ok');
            } else {
                return array("error" => 'maximum file size 150kb');
            }
        }
    }

    public function restDeleteAvatar() {
        $email = $this->param("email");
        $user = NoiCore::app()->db()->query(array(), "cms_users", array("email" => (string) $email));
        if (isset($user[0]['last_id'])) {
            $user = $user[0];
        } else {
            $user = null;
        }
        if (isset($user) and is_array($user)) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $user['email'] . " успешно найден", "soap");

            // 
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c id ' . $id_user, "soap");

            return $this->toArr(' Пользователь не найден c id ' . $id_user);
        }
        $update = array();
        $update['avatar'] = '/tmp/default_avatar.jpg';
        NoiCore::app()->db()->update($update, "cms_users", array("last_id" => (int) $user['last_id']));
        return array("status" => 'ok');
    }

    public function restCreateUserWithTasks() {

        $soap_owner = null;


        $email_users = NoiCore::app()->plugin_values("tasks", "users");

        if (isset($email_users[0]['rest'])) {
            $tmp = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_users[0]['soap'])));
            if (isset($tmp[0]) and isset($tmp[0]['last_id'])) {
                $soap_owner = $tmp[0];
            }
        }
        if (is_null($soap_owner)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . "пользователь rest owner не найден.Добавьте его из админки.", "soap");

            return $this->toArr("пользователь rest owner не найден.Добавьте его из админки.");
        }


        $companies = $this->param("companies", false, false);
        if (!(isset($companies) and is_array($companies) and count($companies) > 0)) {
            $companies = array();
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр companies должен быть в виде массива', "soap");
            // return $this->toArr("параметр companies должен быть в виде массива");
        }

        if (count($companies) > 3) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'параметр companies в нем размер массива должен быть не больше 3', "soap");

            return $this->toArr("параметр companies в нем размер массива должен быть не больше 3");
        }


        $condition = array();
        $condition['$or'] = array();
        if (count($companies)) {
            foreach ($companies as $company_id) {
                $condition['$or'][] = array("last_id" => (int) $company_id);
            }

            $companies_rows = NoiCore::app()->db()->query(array(), "companys", $condition);
            if (count($companies_rows) == 0) {
                //   Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'компании не найдены', "soap");
                //   return $this->toArr("компании не найдены");
            }
        }

        $tasks = $this->param("tasks");


        $email = $this->param("email");
        $hobby = $this->param("hobby", false, false);
        $name = $this->param("name");
        $name1 = $this->param("name1", false, false);
        $surname1 = $this->param("surname1", false, false);
        $fathername1 = $this->param("fathername1", false, false);
        $cat = $this->param("cat", false, false);
        $dog = $this->param("dog", false, false);
        $parrot = $this->param("parrot", false, false);
        $cavy = $this->param("cavy", false, false);
        $hamster = $this->param("hamster", false, false);
        $squirrel = $this->param("squirrel", false, false);
        $phone = $this->param("phone", false, false);
        $inn = $this->param("inn", false, false);
        $gender = $this->param("gender", false, false);
        $birthday = $this->param("birthday", false, false);
        $date_start = $this->param("date_start", false, false);
        $adres = $this->param("adres", false, false);
        if (isset($adres) and strlen($adres) > 0) {
            if (!(isset($adres) and is_string($adres))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $adres . " некорректное", "soap");

                return $this->toArr(' Значение ' . $adres . " некорректное,должна быть только строка");
            }
        }

        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");

            return $this->toArr("email неправильный!");
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " уже существует", "soap");
            return $this->toArr("Пользователь с таким email уже существует ");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");
        }

        if (isset($hobby) and strlen($hobby) > 0) {
            if (!(isset($hobby) and is_string($hobby))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hobby . " некорректное", "soap");

                return $this->toArr(' Значение ' . $hobby . " некорректное,должна быть только строка");
            }
        }

        if (!(isset($name) and is_string($name))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name . " некорректное", "soap");

            return $this->toArr(' Значение ' . $name . " некорректное,должна быть только строка");
        }
        if (isset($name1) and strlen($name1) > 0) {
            if (!(isset($name1) and is_string($name1))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name1 . " некорректное", "soap");

                return $this->toArr(' Значение ' . $name1 . " некорректное,должна быть только строка");
            }
        }

        $count_name = NoiCore::app()->db()->count("cms_users", array('name' => $name));
        if ($count_name > 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . " имя " . $name . " уже есть в БД", "soap");



            return $this->toArr(" имя " . $name . " уже есть в БД");
        }
        if (isset($surname1) and strlen($surname1) > 0) {
            if (!(isset($surname1) and is_string($surname1))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $surname1 . " некорректное", "soap");

                return $this->toArr(' Значение ' . $surname1 . " некорректное,должна быть только строка");
            }
        }
        if (isset($fathername1) and strlen($fathername1) > 0) {
            if (!(isset($fathername1) and is_string($fathername1))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $fathername1 . " некорректное", "soap");

                return $this->toArr(' Значение ' . $fathername1 . " некорректное,должна быть только строка");
            }
        }
        if (isset($cat) and strlen($cat) > 0) {
            if (!(isset($cat) and is_string($cat))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cat . " некорректное", "soap");

                return $this->toArr(' Значение ' . $cat . " некорректное,должна быть только строка");
            }
        }
        if (isset($dog) and strlen($dog) > 0) {
            if (!(isset($dog) and is_string($dog))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $dog . " некорректное", "soap");

                return $this->toArr(' Значение ' . $dog . " некорректное,должна быть только строка");
            }
        }

        if (isset($parrot) and strlen($parrot) > 0) {
            if (!(isset($parrot) and is_string($parrot))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $parrot . " некорректное", "soap");

                return $this->toArr(' Значение ' . $parrot . " некорректное,должна быть только строка");
            }
        }
        if (isset($cavy) and strlen($cavy) > 0) {
            if (!(isset($cavy) and is_string($cavy))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cavy . " некорректное", "soap");

                return $this->toArr(' Значение ' . $cavy . " некорректное,должна быть только строка");
            }
        }
        if (isset($hamster) and strlen($hamster) > 0) {
            if (!(isset($hamster) and is_string($hamster))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hamster . " некорректное", "soap");

                return $this->toArr(' Значение ' . $hamster . " некорректное,должна быть только строка");
            }
        }
        if (isset($squirrel) and strlen($squirrel) > 0) {
            if (!(isset($squirrel) and is_string($squirrel))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $squirrel . " некорректное", "soap");

                return $this->toArr(' Значение ' . $squirrel . " некорректное,должна быть только строка");
            }
        }
        if (isset($phone) and strlen($phone) > 0) {
            if (!(isset($phone) and is_string($phone))) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $phone . " некорректное", "soap");

                return $this->toArr(' Значение ' . $phone . " некорректное,должна быть только строка");
            }
        }

        if (isset($inn) and is_string($inn) and strlen($inn) > 1) {
            if (is_numeric($inn) and strlen($inn) == 12) {
                
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $inn . " некорректное", "soap");

                return $this->toArr(' Значение ' . $inn . " ИНН ФЛ должен содержать 12 цифр");
            }
        }
        if (isset($birthday) and strlen($birthday) > 0) {
            if (!(bool) strtotime($birthday)) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $birthday . " некорректное", "soap");

                return $this->toArr(' Значение ' . $birthday . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ");
            }
        }
        if (isset($birthday) and strlen($birthday) > 0) {
            if (!(bool) strtotime($date_start)) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $date_start . " некорректное", "soap");

                return $this->toArr(' Значение ' . $date_start . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ");
            }
        }

        $new_user = array();
        $new_user['name'] = $name;
        if (isset($name1) and strlen($name1) > 0) {
            $new_user['name1'] = $name1;
        }
        if (isset($hobby) and strlen($hobby) > 0) {
            $new_user['hobby'] = $hobby;
        }
        if (isset($surname1) and strlen($surname1) > 0) {
            $new_user['surname1'] = $surname1;
        }
        if (isset($fathername1) and strlen($fathername1) > 0) {
            $new_user['fathername1'] = $fathername1;
        }
        if (isset($cat) and strlen($cat) > 0) {
            $new_user['cat'] = $cat;
        }
        if (isset($dog) and strlen($dog) > 0) {
            $new_user['dog'] = $dog;
        }
        if (isset($parrot) and strlen($parrot) > 0) {
            $new_user['parrot'] = $parrot;
        }
        if (isset($cavy) and strlen($cavy) > 0) {
            $new_user['cavy'] = $cavy;
        }
        if (isset($hamster) and strlen($hamster) > 0) {
            $new_user['hamster'] = $hamster;
        }
        if (isset($squirrel) and strlen($squirrel) > 0) {
            $new_user['squirrel'] = $squirrel;
        }
        if (isset($phone) and strlen($phone) > 0) {
            $new_user['phone'] = $phone;
        }
        if (isset($adres) and strlen($adres) > 0) {
            $new_user['adres'] = $adres;
        }
        if (isset($gender) and strlen($gender) > 0) {
            $new_user['gender'] = $gender;
        }
        if (isset($date_start) and strlen($date_start) > 0) {
            $new_user['date_start'] = new MongoDate(strtotime($date_start));
        }

        $new_user['date_updated'] = new MongoDate();
        if (isset($birthday) and strlen($birthday) > 0) {
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
        $new_user['email'] = $email;
        $new_user['by_user'] = $soap_owner;

        $tasks_rows = array();
        if (!(isset($tasks) and is_array($tasks) and count($tasks) > 0)) {


            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . " tasks должен состоять из массива,который содержит массивы (title=>'задача','description=>'описание')", "soap");

            return $this->toArr("tasks должен состоять из массива,который содержит массивы (title=>'задача','description=>'описание')");
        }

        foreach ($tasks as $key => $task) {
            if (!(isset($task['title']) and is_string($task['title']) and strlen($task['title']) > 0)) {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' tasks.title не может быть пустым', "soap");

                return $this->toArr(' tasks.title не может быть пустым');
            }
            if (!(isset($task['description']) and is_string($task['description']) and strlen($task['description']) > 0)) {
                $tasks[$key]['description'] = "";
            }
        }





//        foreach ($tasks_rows as $task_row) {
//            $update = array();
//            $update['user'] = $new_user;
//            NoiCore::app()->db()->update($update, "tasks", array('last_id' => $task_row['last_id']));
//        }

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
        if (isset($companies_rows) and count($companies_rows)) {
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
        }
        $new_user['companies'] = $companies_rows;
        $new_user['tasks'] = $tasks_rows;


        if (isset($new_user['by_user'])) {
            $new_user['by_user'] = $new_user['by_user']['email'];
        }
        unset($new_user['user_money']);
        unset($new_user['structure_vznos']);
        unset($new_user['with_outvznos']);
        unset($new_user['with_vznos']);
        unset($new_user['total_deposits']);
        unset($new_user['enable_account']);
        unset($new_user['user_active']);
        if (isset($new_user['site_id'])) {
            unset($new_user['site_id']);
        }
        if (isset($new_user['order_last_id'])) {
            unset($new_user['order_last_id']);
        }
        if (isset($new_user['last_id'])) {
            unset($new_user['last_id']);
        }
        if (count($new_user['companies'])) {
            $new_comp = array();
            foreach ($new_user['companies'] as $comp) {
                $new_comp[] = array("name" => $comp['name'], "id" => $comp['last_id']);
            }
            $new_user['companies'] = $new_comp;
        }

        if (count($new_user['tasks'])) {
            $new_comp = array();
            foreach ($new_user['tasks'] as $comp) {
                $new_comp[] = array("name" => $comp['name'], "id" => $comp['last_id']);
            }
            $new_user['tasks'] = $new_comp;
        }
        return $new_user;
    }

    public function restMagicsearch() {
        $alltypes = array("ALL", "USER", "COMPANY");
        $allstatuses = array("ALL", "ACTUAL", "COMPLETE", "FAIL");
        $allinclude = array("ALL", "USER", "COMPANY", "TASK", "WHY");
        $query = $this->param("query", false, false);
        $partyType = $this->param("partyType", false, false);
        $fullSimilarity = $this->param("fullSimilarity", false, false);

        $taskStatus = $this->param("taskStatus", false, false);
        $include = $this->param("include", false, false);
        $maxCount = $this->param("maxCount", false, false);
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

        $answer = array();
        $answer['foundCount'] = $total;
        $answer['results'] = $total_result;

        return $answer;
    }

    public function restCreateUser() {
        $companies = $this->param("companies");
        if (!(isset($companies) and is_array($companies) and count($companies) > 0)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр companies должен быть в виде массива', "soap");

            return $this->toArr("параметр companies должен быть в виде массива");
        }

        if (count($companies) > 3) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'параметр companies в нем размер массива должен быть не больше 3', "soap");

            return $this->toArr("параметр companies в нем размер массива должен быть не больше 3");
        }


        $condition = array();
        $condition['$or'] = array();
        foreach ($companies as $company_id) {
            $condition['$or'][] = array("last_id" => (int) $company_id);
        }
        $companies_rows = NoiCore::app()->db()->query(array(), "companys", $condition);
        if (count($companies_rows) == 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'компании не найдены', "soap");

            return $this->toArr("компании не найдены");
        }



        $tasks = $this->param("tasks");

        if (!(isset($tasks) and is_array($tasks) and count($tasks) > 0)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' параметр tasks должен быть в виде массива', "soap");

            return $this->toArr("параметр tasks должен быть в виде массива");
        }

        if (count($tasks) > 5) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'параметр tasks в нем размер массива должен быть не больше 5', "soap");

            return $this->toArr("параметр tasks в нем размер массива должен быть не больше 5");
        }


        $condition = array();

        $condition['$or'] = array();
        foreach ($tasks as $task_id) {
            $condition['$or'][] = array("last_id" => (int) $task_id);
        }
        $tasks_rows = NoiCore::app()->db()->query(array(), "tasks", $condition);
        if (count($tasks_rows) == 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . 'задачи не найдены', "soap");

            return $this->toArr("задачи не найдены");
        }
//     

        $email = $this->param("email", false, true);
        $hobby = $this->param("hobby", false, false);
        $name = $this->param("name", false, true);
        $name1 = $this->param("name1", false, false);
        $surname1 = $this->param("surname1", false, false);
        $fathername1 = $this->param("fathername1", false, false);
        $cat = $this->param("cat", false, false);
        $dog = $this->param("dog", false, false);
        $parrot = $this->param("parrot", false, false);
        $cavy = $this->param("cavy", false, false);
        $hamster = $this->param("hamster", false, false);
        $squirrel = $this->param("squirrel", false, false);
        $phone = $this->param("phone", false, false);
        $inn = $this->param("inn", false, false);
        $gender = $this->param("gender", false, false);
        $birthday = $this->param("birthday", false, false);
        $date_start = $this->param("date_start", false, false);
        $adres = $this->param("adres", false, false);
        if (!(isset($adres) and is_string($adres))) {
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $adres . " некорректное", "soap");
            //  return $this->toArr(' Значение ' . $adres . " некорректное,должна быть только строка");
            $adress = "";
        }

        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");

            return $this->toArr("email неправильный!");
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " уже существует", "soap");
            return $this->toArr("Пользователь с таким email уже существует ");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");
        }


        $email_users = NoiCore::app()->plugin_values("tasks", "users");
        $soap_owner = null;
        if (isset($email_users[0]['rest'])) {
            $tmp = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_users[0]['rest'])));
            if (isset($tmp[0]) and isset($tmp[0]['last_id'])) {
                $soap_owner = $tmp[0];
            }
        }
        if (is_null($soap_owner)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . "пользователь rest owner не найден.Добавьте его из админки.", "soap");

            return $this->toArr("пользователь soap owner не найден.Добавьте его из админки.");
        }


        if (!(isset($hobby) and is_string($hobby))) {
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hobby . " некорректное", "soap");
            // return $this->toArr(' Значение ' . $hobby . " некорректное,должна быть только строка");
            $hobby = "";
        }
        if (!(isset($name) and is_string($name))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name . " некорректное", "soap");

            return $this->toArr(' Значение ' . $name . " некорректное,должна быть только строка");
        }

        $count_name = NoiCore::app()->db()->count("cms_users", array('name' => $name));
        if ($count_name > 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . " имя " . $name . " уже есть в БД", "soap");



            return $this->toArr(" имя " . $name . " уже есть в БД");
        }
        if (!(isset($name1) and is_string($name1))) {
            //Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name1 . " некорректное", "soap");
            //return $this->toArr(' Значение ' . $name1 . " некорректное,должна быть только строка");
            $name1 = "";
        }
        if (!(isset($surname1) and is_string($surname1))) {
            //Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $surname1 . " некорректное", "soap");
            // return $this->toArr(' Значение ' . $surname1 . " некорректное,должна быть только строка");
            $surname1 = "";
        }
        if (!(isset($fathername1) and is_string($fathername1))) {
            //Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $fathername1 . " некорректное", "soap");
            // return $this->toArr(' Значение ' . $fathername1 . " некорректное,должна быть только строка");
            $fathername1 = "";
        }
        if (!(isset($cat) and is_string($cat))) {
            //  Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cat . " некорректное", "soap");
            //return $this->toArr(' Значение ' . $cat . " некорректное,должна быть только строка");
            $cat = "";
        }
        if (!(isset($dog) and is_string($dog))) {
            //  Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $dog . " некорректное", "soap");
            //  return $this->toArr(' Значение ' . $dog . " некорректное,должна быть только строка");
            $dog = "";
        }

        if (!(isset($parrot) and is_string($parrot))) {
            //     Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $parrot . " некорректное", "soap");
            //   return $this->toArr(' Значение ' . $parrot . " некорректное,должна быть только строка");
            $parrot = "";
        }

        if (!(isset($cavy) and is_string($cavy))) {
            //  Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cavy . " некорректное", "soap");
            // return $this->toArr(' Значение ' . $cavy . " некорректное,должна быть только строка");
            $cavy = "";
        }

        if (!(isset($hamster) and is_string($hamster))) {
            //   Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hamster . " некорректное", "soap");
            // return $this->toArr(' Значение ' . $hamster . " некорректное,должна быть только строка");
            $hamster = "";
        }

        if (!(isset($squirrel) and is_string($squirrel))) {
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $squirrel . " некорректное", "soap");
            // return $this->toArr(' Значение ' . $squirrel . " некорректное,должна быть только строка");
            $squirrel = "";
        }

        if (!(isset($phone) and is_string($phone))) {
            //   Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $phone . " некорректное", "soap");
            //  return $this->toArr(' Значение ' . $phone . " некорректное,должна быть только строка");
            $phone = "";
        }

        if (isset($inn) and is_string($inn) and strlen($inn) > 1) {
            if (is_numeric($inn) and strlen($inn) == 12) {
                
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $inn . " некорректное", "soap");

                return $this->toArr(' Значение ' . $inn . " ИНН ФЛ должен содержать 12 цифр");
            }
        }

        if (!(bool) strtotime($birthday)) {
            //  Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $birthday . " некорректное", "soap");
            //  return $this->toArr(' Значение ' . $birthday . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ");
            $birthday = null;
        }

        if (!(bool) strtotime($date_start)) {
            // Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $date_start . " некорректное", "soap");
            //  return $this->toArr(' Значение ' . $date_start . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ");
            $date_start = null;
        }

        $new_user = array();
        $new_user['email'] = $email;
        $new_user['name'] = $name;
        $new_user['name1'] = $name1;
        $new_user['hobby'] = $hobby;
        $new_user['surname1'] = $surname1;
        $new_user['fathername1'] = $fathername1;
        $new_user['cat'] = $cat;
        $new_user['dog'] = $dog;
        $new_user['parrot'] = $parrot;
        $new_user['cavy'] = $cavy;
        $new_user['hamster'] = $hamster;
        $new_user['squirrel'] = $squirrel;
        $new_user['phone'] = $phone;
        $new_user['adres'] = $adres;
        $new_user['gender'] = $gender;
        $new_user['date_start'] = new MongoDate(strtotime($date_start));
        $new_user['date_updated'] = new MongoDate();
        $new_user['birthday'] = new MongoDate(strtotime($birthday));
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

        $new_user = NoiCore::app()->db()->insert($new_user, "cms_users", true);

        foreach ($companies_rows as $company_row) {
            $users = array();

            if (isset($company_row['users']) and is_array($company_row['users']) and count($company_row['users'])) {
                $users = $company_row['users'];
            }
            $users['id_' . $new_user['last_id']] = $new_user;
            $update = array();
            $update['users'] = $users;
            NoiCore::app()->db()->update($update, "companys", array('last_id' => $company_row['last_id']));
        }

        foreach ($tasks_rows as $task_row) {
            $update = array();
            $update['user'] = $new_user;
            NoiCore::app()->db()->update($update, "tasks", array('last_id' => $task_row['last_id']));
        }
        $new_user['companies'] = $companies_rows;
        $new_user['tasks'] = $tasks_rows;
        if (isset($new_user['by_user'])) {
            $new_user['by_user'] = $new_user['by_user']['email'];
        }
        unset($new_user['user_money']);
        unset($new_user['structure_vznos']);
        unset($new_user['with_outvznos']);
        unset($new_user['with_vznos']);
        unset($new_user['total_deposits']);
        unset($new_user['enable_account']);
        unset($new_user['user_active']);
        if (isset($new_user['site_id'])) {
            unset($new_user['site_id']);
        }
        if (isset($new_user['order_last_id'])) {
            unset($new_user['order_last_id']);
        }
        if (isset($new_user['last_id'])) {
            unset($new_user['last_id']);
        }
        if (count($new_user['companies'])) {
            $new_comp = array();
            foreach ($new_user['companies'] as $comp) {
                $new_comp[] = array("name" => $comp['name'], "id" => $comp['last_id']);
            }
            $new_user['companies'] = $new_comp;
        }

        if (count($new_user['tasks'])) {
            $new_comp = array();
            foreach ($new_user['tasks'] as $comp) {
                $new_comp[] = array("name" => $comp['name'], "id" => $comp['last_id']);
            }
            $new_user['tasks'] = $new_comp;
        }

        return $new_user;
    }

    public function restFullupdateuser() {
        $email = $this->param("email");
        $hobby = $this->param("hobby");
        if (!(isset($hobby) and is_string($hobby))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hobby . " некорректное", "soap");

            return $this->toArr(' Значение ' . $hobby . " некорректное,должна быть только строка");
        }
        $name = $this->param("name");
        if (!(isset($name) and is_string($name))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name . " некорректное", "soap");

            return $this->toArr(' Значение ' . $name . " некорректное,должна быть только строка");
        }
        $name1 = $this->param("name1");
        if (!(isset($name1) and is_string($name1))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $name1 . " некорректное", "soap");

            return $this->toArr(' Значение ' . $name1 . " некорректное,должна быть только строка");
        }
        $surname1 = $this->param("surname1");
        if (!(isset($surname1) and is_string($surname1))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $surname1 . " некорректное", "soap");

            return $this->toArr(' Значение ' . $surname1 . " некорректное,должна быть только строка");
        }
        $fathername1 = $this->param("fathername1");
        if (!(isset($fathername1) and is_string($fathername1))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $fathername1 . " некорректное", "soap");

            return $this->toArr(' Значение ' . $fathername1 . " некорректное,должна быть только строка");
        }
        $cat = $this->param("cat");

        if (!(isset($cat) and is_string($cat))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cat . " некорректное", "soap");

            return $this->toArr(' Значение ' . $cat . " некорректное,должна быть только строка");
        }
        $dog = $this->param("dog");

        if (!(isset($dog) and is_string($dog))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $dog . " некорректное", "soap");

            return $this->toArr(' Значение ' . $dog . " некорректное,должна быть только строка");
        }
        $parrot = $this->param("parrot");
        if (!(isset($parrot) and is_string($parrot))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $parrot . " некорректное", "soap");

            return $this->toArr(' Значение ' . $parrot . " некорректное,должна быть только строка");
        }
        $cavy = $this->param("cavy");

        if (!(isset($cavy) and is_string($cavy))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $cavy . " некорректное", "soap");

            return $this->toArr(' Значение ' . $cavy . " некорректное,должна быть только строка");
        }
        $hamster = $this->param("hamster");
        if (!(isset($hamster) and is_string($hamster))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $hamster . " некорректное", "soap");

            return $this->toArr(' Значение ' . $hamster . " некорректное,должна быть только строка");
        }
        $squirrel = $this->param("squirrel");
        if (!(isset($squirrel) and is_string($squirrel))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $squirrel . " некорректное", "soap");

            return $this->toArr(' Значение ' . $squirrel . " некорректное,должна быть только строка");
        }
        $phone = $this->param("phone");
        if (!(isset($phone) and is_string($phone))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $phone . " некорректное", "soap");

            return $this->toArr(' Значение ' . $phone . " некорректное,должна быть только строка");
        }
        $inn = $this->param("inn");
        $update = array();
        if (isset($inn) and is_string($inn) and strlen($inn) > 1) {
            if (is_numeric($inn) and strlen($inn) == 12) {
                $update['inn'] = $inn;
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $inn . " некорректное", "soap");

                return $this->toArr(' Значение ' . $inn . " ИНН ФЛ должен содержать 12 цифр");
            }
        }

        $adres = $this->param("adres");
        if (!(isset($adres) and is_string($adres))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $adres . " некорректное", "soap");

            return $this->toArr(' Значение ' . $adres . " некорректное,должна быть только строка");
        }
        $gender = $this->param("gender");
        $birthday = $this->param("birthday");
        $date_start = $this->param("date_start");










        $domain = $_SERVER['HTTP_HOST'];
        $array_of_fields = array();

        $available_fields = array('hobby', 'name', 'name1', 'surname1', 'fathername1', 'cat', 'dog', 'parrot', 'cavy', 'hamster', 'squirrel', 'phone', 'adres');
        $values = func_get_args();


        if ($gender != "m" and $gender != "f") {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $gender . " некорректное", "soap");

            return $this->toArr(' Значение ' . $gender . " некорректное,должна быть либо m либо f");
        }

        if (!(bool) strtotime($birthday)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $birthday . " некорректное", "soap");

            return $this->toArr(' Значение ' . $birthday . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ");
        }

        if (!(bool) strtotime($date_start)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $date_start . " некорректное", "soap");

            return $this->toArr(' Значение ' . $date_start . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ");
        }





        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");

            return $this->toArr("email неправильный!");
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

            return $this->toArr("Пользователь с таким email не найден!");
        }






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
        $userreturn = array();
        $userreturn['name'] = $newuser['name'];
        $userreturn['avatar'] = "http://" . $domain . "/" . $newuser['avatar'];
        $userreturn['email'] = $newuser['email'];
        $userreturn['password'] = $newuser['password'];
        $userreturn['birthday'] = 0;
        if (isset($newuser['birthday']->sec)) {
            $userreturn['birthday'] = date('d.m.Y', $newuser['birthday']->sec);
        }
        $userreturn['gender'] = "";
        if (isset($newuser['gender'])) {
            $userreturn['gender'] = $newuser['gender'];
        }
        $userreturn['date_start'] = 0;
        if (isset($newuser['date_start']->sec)) {
            $userreturn['date_start'] = date('d.m.Y', $newuser['date_start']->sec);
        }
        $userreturn['hobby'] = "";
        if (isset($newuser['hobby'])) {
            $userreturn['hobby'] = "";
        }
        if (isset($newuser['name1'])) {
            $userreturn['name1'] = $newuser['name1'];
        }
        if (isset($newuser['surname1'])) {
            $userreturn['surname1'] = $newuser['surname1'];
        }
        if (isset($newuser['fathername1'])) {
            $userreturn['fathername1'] = $newuser['fathername1'];
        }

        if (isset($newuser['cat'])) {
            $userreturn['cat'] = $newuser['cat'];
        }
        if (isset($newuser['dog'])) {
            $userreturn['dog'] = $newuser['dog'];
        }
        if (isset($newuser['parrot'])) {
            $userreturn['parrot'] = $newuser['parrot'];
        }
        if (isset($newuser['cavy'])) {
            $userreturn['cavy'] = $newuser['cavy'];
        }
        if (isset($newuser['hamster'])) {
            $userreturn['hamster'] = $newuser['hamster'];
        }
        if (isset($newuser['squirrel'])) {
            $userreturn['squirrel'] = $newuser['squirrel'];
        }
        if (isset($newuser['phone'])) {
            $userreturn['phone'] = $newuser['phone'];
        }
        if (isset($newuser['adres'])) {
            $userreturn['adres'] = $newuser['adres'];
        }
        if (isset($newuser['inn'])) {
            $userreturn['inn'] = $newuser['inn'];
        }
        return $userreturn;
    }

    public function restUseronefield() {
        $array_of_fields = array();
        $email = $this->param("email");
        $field = $this->param("field");
        $value = $this->param("value");
        $available_fields = array('hobby', 'name', 'name1', 'surname1', 'fathername1', 'cat', 'dog', 'parrot', 'cavy', 'hamster', 'squirrel', 'phone', 'adres', 'birthday', 'gender', 'date_start', 'inn');
        if (!(isset($field) and is_string($field) and in_array($field, $available_fields))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Название Поля неверное', "soap");

            return $this->toArr('Название поля ' . $field . ' неверное .Доступные поля ' . implode(",", $available_fields));
        }

        if (!(isset($value) and is_string($value))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");

            return $this->toArr(' Значение ' . $value . " некорректное,должна быть только строка");
        }
        if ($field == "gender" and $value != "m" and $value != "f") {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");

            return $this->toArr(' Значение ' . $value . " некорректное,должна быть либо m либо f");
        }
        if (($field == "birthday" or $field == "date_start") and ! (bool) strtotime($value)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное", "soap");

            return $this->toArr(' Значение ' . $value . " некорректное,должна быть дата в формате ДД.ММ.ГГГГ");
        }
        if ($field == "inn") {
            if (isset($value) and is_string($value) and strlen($value) > 1) {
                if (is_numeric($value) and strlen($value) == 12) {
                    
                } else {
                    Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Значение ' . $value . " некорректное INN", "soap");

                    return $this->toArr(' Значение ' . $value . " некорректное,ИНН ФЛ должен содержать 12 цифр");
                }
            }
        }




        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода UpdateUser', "soap");
        if (!(isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Email ' . $email . " некорректный", "soap");

            return $this->toArr("email неправильный!");
        }

        $email = strtolower($email);
        $count = NoiCore::app()->db()->count("cms_users", array('email' => strtolower($email)));
        if ($count == 1) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email ' . $email . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден ' . $email, "soap");

            return $this->toArr("Пользователь с таким email не найден!");
        }





        $update = array();
        $update[$field] = $value;
        if ($field == "birthday" or $field == "date_start") {
            $update[$field] = new MongoDate(strtotime($value));
        }



        // $update[$field]=$value;
        NoiCore::app()->db()->update($update, "cms_users", array('email' => $email));
        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . "Поле " . $field . " успешно изменено на " . $value . " у пользователя с email " . $email, "soap");

        return $this->toArr("Поле " . $field . " успешно изменено на " . $value . " у пользователя с email " . $email);
    }

    public function restList() {
        $results = array();
        $results['resources'] = array();
        $methods = get_class_methods($this);
        if (count($methods)) {
            foreach ($methods as $method) {
                $name = str_replace("rest", "", $method);
                if ($name != $method) {
                    $name = strtolower($name);
                    $url = "http://" . $_SERVER['HTTP_HOST'] . "/tasks/rest/" . $name;
                    $results['resources'][] = array('name_method' => $name, 'url' => $url);
                }
            }
        }
        return $results;
    }

    public function restDoregister() {
        $domain = $_SERVER['HTTP_HOST'];
        $email = $this->param("email");
        $name = $this->param("name");
        $password = $this->param("password");
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
                            $array_insert['by_user'] = array('name' => 'rest', 'email' => 'rest');
                            $newuser = NoiCore::app()->db()->insert($array_insert, "cms_users", true);

                            if (isset($newuser['last_id'])) {
                                $userreturn = array();
                                $userreturn['name'] = $newuser['name'];
                                $userreturn['avatar'] = "http://" . $domain . "/" . $newuser['avatar'];
                                $userreturn['password'] = $newuser['password'];
                                $userreturn['birthday'] = 0;
                                $userreturn['email'] = $newuser['email'];
                                if (isset($newuser['birthday']->sec)) {
                                    $userreturn['birthday'] = $newuser['birthday']->sec;
                                }
                                $userreturn['gender'] = "";
                                if (isset($newuser['gender'])) {
                                    $userreturn['gender'] = $newuser['gender'];
                                }
                                $userreturn['date_start'] = 0;
                                if (isset($newuser['date_start']->sec)) {
                                    $userreturn['date_start'] = $newuser['date_start']->sec;
                                }
                                $userreturn['hobby'] = "";
                                if (isset($newuser['hobby'])) {
                                    $userreturn['hobby'] = "";
                                }
                                return $userreturn;
                            } else {
                                return $this->toArr(' Пользователь не был создан,произошла ошибка! ');
                            }
                        } else {
                            return $this->toArr('Поле name должно быть больше нуля ');
                        }
                    } else {
                        Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Текущее ФИО ' . $name . " уже есть в базе", "soap");

                        return $this->toArr(' Текущее ФИО ' . $name . " уже есть в базе");
                    }
                } else {
                    Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' поле фио является обязательным ', "soap");


                    return $this->toArr('поле фио является обязательным');
                }
            } else {
                Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email ' . $email . " уже есть в базе", "soap");

                return $this->toArr(' email ' . $email . " уже есть в базе");
            }
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Некоректный  email' . $email . "", "soap");

            return $this->toArr(' Некоректный  email ' . $email);
        }
    }

    public function restCreateCompany() {
        $email_owner = $this->param("email_owner");
        $company_name = $this->param("company_name");


        $company_type = $this->param("company_type");
        $company_users = $this->param("company_users");
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            return $this->toArr('Пользователь не найден c email_owner ' . $email_owner);
        }
        if (!(isset($company_name) and is_string($company_name) and strlen($company_name) > 1)) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' company_name некорректный', "soap");



            return $this->toArr(' company_name некорректный');
        }
        $types = array("ООО", "ИП", "ОАО");
        $users = array();
        if (!(isset($company_type) and is_string($company_type) and in_array($company_type, $types))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' company_type ' . $company_type . ' некорректный', "soap");



            return $this->toArr(' company_type ' . $company_type . ' некорректный');
        }

        if (isset($company_users) and is_array($company_users) and count($company_users)) {
            foreach ($company_users as $user_id) {
                $tmp = \companys\models\CompanyModel::getUser($user_id);
                if (is_array($tmp)) {

                    $users['id_' . $tmp['last_id']] = $tmp;
                }
            }
        }
        if (count($users) == 0) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' company_users  не указаны сотрудники', "soap");



            return $this->toArr(' company_users  не указаны сотрудники');
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


        $taskreturn = array();
        $taskreturn['type'] = "success";
        $taskreturn['id_company'] = $array_insert['last_id'];
        $newusers = array();
        if (count($users) > 0) {
            foreach ($users as $user) {
                $newusers[] = $user['email'];
            }
            $array_insert['users'] = $newusers;
        }
        unset($array_insert['creator']);
        unset($array_insert['date']);
        unset($array_insert['date_update']);
        unset($array_insert['site_id']);
        unset($array_insert['order_last_id']);
        unset($array_insert['last_id']);
        $taskreturn['company'] = $array_insert;
        return $taskreturn;
    }

    public function restCreatetask() {
        $task_title = $this->param("task_title");
        $task_description = $this->param("task_description");
        $email_owner = $this->param("email_owner");
        $email_assign = $this->param("email_assign");


        Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Начало выполнения метода CreateTask', "soap");
        if (!(isset($email_owner) and is_string($email_owner) and filter_var($email_owner, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_owner . " некорректный", "soap");



            return $this->toArr(' email_owner ' . $email_owner . " некорректный");
        }
        $email_owner = strtolower($email_owner);
        $owners = NoiCore::app()->db()->query(array(), "cms_users", array('email' => strtolower($email_owner)));
        if (isset($owners[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_owner ' . $email_owner . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_owner ' . $email_owner, "soap");

            return $this->toArr('Пользователь не найден c email_owner ' . $email_owner);
        }

        if (!(isset($email_assign) and is_string($email_assign) and filter_var($email_assign, FILTER_VALIDATE_EMAIL))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' email_owner ' . $email_assign . " некорректный", "soap");

            return $this->toArr("email_owner неправильный!");
        }
        $email_assign = strtolower($email_assign);
        $assigns = NoiCore::app()->db()->query(array(), "cms_users", array('email' => $email_assign));

        if (isset($assigns[0]['_id'])) {
            Yii::info('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь с email_assign ' . $email_assign . " успешно найден", "soap");
        } else {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Пользователь не найден c email_assign ' . $email_assign, "soap");

            return $this->toArr('Пользователь не найден c email_assign ' . $email_assign);
        }
        if (!(isset($task_title) and is_string($task_title) and strlen($task_title))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_title имеет  неверное значение', "soap");
            return $this->toArr(' Параметр task_title имеет  неверное значение');
        }
        if (!(isset($task_description) and is_string($task_description) and strlen($task_description))) {
            Yii::error('IP ' . $_SERVER['REMOTE_ADDR'] . ' Параметр task_description имеет  неверное значение', "soap");
            return $this->toArr(' Параметр task_description имеет  неверное значение');
        }
        $array_insert = array();
        $array_insert['date'] = new \MongoDate();
        $array_insert['creator'] = $owners[0];
        $array_insert['user'] = $assigns[0];
        $array_insert['name'] = strip_tags($task_title);
        $array_insert['description'] = strip_tags($task_description);
        $array_insert = NoiCore::app()->db()->insert($array_insert, "tasks", true);
        $taskreturn = array();
        $taskreturn['type'] = "success";
        $taskreturn['id_task'] = $array_insert['last_id'];
        $taskreturn['message'] = "Задача успешно создана!";
        return $taskreturn;
    }

    public function json($array) {
        header('Content-Type: application/json');
        $code = http_response_code();
        if ($code > 400) {
            header("HTTP/1.1 " . http_response_code() . " ERROR");
        } else {
            header("HTTP/1.1 " . http_response_code() . " OK");
        }


        echo json_encode($array);
        exit;
    }

    public function xml($data, $root = null) {
        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement($root ? '<' . $root . '/>' : '<root/>');
        array_walk_recursive($data, function($value, $key)use($xml) {
            $xml->addChild($key, $value);
        });
        echo $xml->asXML();
        exit;
    }

    public function toArr($str, $type = "error") {
        $error = array();
        $error['type'] = $type;
        $error['message'] = $str;

        return $error;
    }

}
