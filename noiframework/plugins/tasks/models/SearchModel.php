<?php

namespace tasks\models;

use MongoDate;
use NoiCore;

class SearchModel {

    static function findUser($query, $fullSimilarity = false, $taskStatus = null, $include = null, $maxCount = 5) {

        $condition = array();
        $condition['$or'] = array();
        $condition['$or'][] = array("name" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("name1" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("surname1" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("fathername1" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("phone" => array('$options' => 'i', '$regex' => $query));

        $condition['$or'][] = array("inn" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("email" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("email" => $query);

        $query_arrays = explode(" ", $query);
        if (count($query_arrays) > 0) {
            foreach ($query_arrays as $one_query) {
                if (strlen($one_query) > 0) {
                    $condition['$or'][] = array("name" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("name1" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("surname1" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("fathername1" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("phone" => array('$options' => 'i', '$regex' => $one_query));

                    $condition['$or'][] = array("inn" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("email" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("email" => $one_query);
                }
            }
        }



        if (isset($fullSimilarity) and is_bool($fullSimilarity) and $fullSimilarity == true) {
            $condition = array();
            $condition['$or'] = array();
            $condition['$or'][] = array("name" => $query);
            $condition['$or'][] = array("name1" => $query);
            $condition['$or'][] = array("surname1" => $query);
            $condition['$or'][] = array("fathername1" => $query);
            $condition['$or'][] = array("phone" => $query);

            $condition['$or'][] = array("inn" => $query);
            $condition['$or'][] = array("email" => $query);
        }

        if ((bool) strtotime($query)) {

            $condition['$or'][] = array("birthday" => new MongoDate(strtotime($query)));
        }

        $result = \noicms\mongogrid\system_core\MongoQuery::execute(array(), "cms_users", $condition, array('last_id' => -1), $maxCount, 0);

        $total_count = \noicms\mongogrid\system_core\MongoQuery::count("cms_users", $condition);

        if (isset($result[0]['last_id'])) {
            
        } else {
            $result = false;
        }

        if (($include == "ALL" or $include == "USER") or ( is_array($include) and ( in_array("ALL", $include) or in_array("USER", $include)))) {
            
        } else {
            if (is_array($result)) {
                $newresult = array();
                foreach ($result as $user) {
                    $tmp = array();
                    $tmp['last_id'] = $user['last_id'];
                    if (isset($user['name'])) {
                        $tmp['name'] = $user['name'];
                    }
                    $tmp['email'] = $user['email'];
                    $newresult[] = $tmp;
                }
                $result = $newresult;
            }
        }


        if (is_array($result)) {
            $or_cond = array();
            foreach ($result as $user) {
                $or_cond[] = array("user.last_id" => $user['last_id']);
            }


            if (($include == "ALL" or $include == "TASK") or ( is_array($include) and ( in_array("ALL", $include) or in_array("TASK", $include)))) {

                $or_cond = array();
                foreach ($result as $user) {

                    if (isset($taskStatus) and ! is_null($taskStatus) and $taskStatus == "ACTUAL") {
                        //$or_cond[] = array("cron.time.sec" => array('$gte' => time()), "user.last_id" => $user['last_id']);
                        //$or_cond[] = array("cron.time" => array('$gte' => new \MongoDate()), "user.last_id" => $user['last_id']);
                        // $or_cond[] = array("cron.time" => array('$exists' => false), "user.last_id" => $user['last_id']);
                        $or_cond[] = array("user.last_id" => $user['last_id']);
                    } else {
                        $or_cond[] = array("user.last_id" => $user['last_id']);
                    }
                }

                $condition['$or'] = $or_cond;

                if (!is_null($taskStatus)) {
                    if ($taskStatus == "ACTUAL") {
                        $condition = array();
                        //$condition['cron.time.sec'] = array('$gte' => time());
                        $condition['complete'] = array('$ne' => 1);
                    } else if ($taskStatus == "COMPLETE") {
                        $condition['complete'] = 1;
                    } else if ($taskStatus == "FAIL") {

                        $condition = array();
                        $condition['cron.time.sec'] = array('$lte' => time());
                        $condition['complete'] = array('$ne' => 1);
                        $condition['fail'] = 1;
                    } else if ($taskStatus == "ALL") {
                        
                    }
                }

                $tasks = \noicms\mongogrid\system_core\MongoQuery::execute2(array(), "tasks", $condition, array('last_id' => -1));

                if (isset($tasks[0]['last_id'])) {
                    
                } else {
                    $tasks = false;
                    //$result = false;
                }

                if (is_array($tasks)) {
                    $newtasks = array();
                    foreach ($tasks as $key => $task) {
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
                        if (!is_null($taskStatus)) {
                            if ($taskStatus == "ACTUAL" and $status == "ACTUAL") {
                                $newtasks[] = $task;
                            } else if ($taskStatus == "COMPLETE" and $status == "COMPLETE") {
                                $newtasks[] = $task;
                            } else if ($taskStatus == "FAIL") {

                                $newtasks[] = $task;
                            } else if ($taskStatus == "ALL") {
                                $newtasks[] = $task;
                            }
                        } else {
                            $newtasks[] = $task;
                        }
                    }
                    $tasks = $newtasks;
                }
                if (isset($tasks[0]['last_id'])) {
                    
                } else {
                    $tasks = false;
                    //$result = false;
                }



                if (is_array($tasks)) {
                    $newres = array();
                    foreach ($result as $res) {
                        $newres['id_' . $res['last_id']] = $res;
                    }
                    $result = $newres;
                    $users_final = array();
                    foreach ($tasks as $task) {
                        if (isset($task['user']['last_id']) and isset($result['id_' . $task['user']['last_id']])) {
                            if (!isset($result['id_' . $task['user']['last_id']]['tasks'])) {
                                $result['id_' . $task['user']['last_id']]['tasks'] = array();
                            }
                            $result['id_' . $task['user']['last_id']]['tasks'][] = $task;
                        }
                    }

                    foreach ($tasks as $task) {
                        if (isset($task['user']['last_id']) and isset($result['id_' . $task['user']['last_id']])) {
                            $users_final[] = $result['id_' . $task['user']['last_id']];
                            unset($result['id_' . $task['user']['last_id']]);
                        }
                    }
                    $result = $users_final;
                }
            }


            if (!is_null($include)) {
                if (($include == "ALL" or $include == "COMPANY") or ( is_array($include) and ( in_array("ALL", $include) or in_array("COMPANY", $include)))) {
                    $condition = array();
                    $condition['$or'] = array();
                    $companys_users = array();
                    foreach ($result as $row) {
                        $condition['$or'][] = array('users.id_' . $row['last_id'] . ".last_id" => $row['last_id']);

                        $companys_users[(int) $row['last_id']] = array();
                    }
                    $companys = false;
                    if (count($condition['$or']) > 0) {
                        $companys = \noicms\mongogrid\system_core\MongoQuery::execute2(array(), "companys", $condition, array('last_id' => -1));
                    }
                    if (isset($companys[0]['last_id'])) {
                        
                    } else {
                        $companys = false;
                    }

                    if (is_array($companys)) {


                        foreach ($companys as $comp) {
                            foreach ($companys_users as $userid => $tm) {
                                if (isset($comp['users']['id_' . $userid]['last_id'])) {
                                    $newcomp = $comp;
                                    unset($newcomp['users']);
                                    $companys_users[$userid][] = $newcomp;
                                }
                            }
                            foreach ($result as $key => $res) {
                                $result[$key]['companies'] = $companys_users[$res['last_id']];
                            }
                        }
                    }
                }
            }

            if (($include == "ALL" or $include == "WHY") or ( is_array($include) and ( in_array("ALL", $include) or in_array("WHY", $include)))) {
                $fields_list = array('name', 'name1', 'surname1', 'fathername1', 'phone', 'inn', 'email');


                foreach ($result as $key => $res) {
                    $why_block = array();
                    foreach ($fields_list as $field) {
                        if (isset($res[$field])) {
                            $tmp = str_replace($query, "", $res[$field]);
                            if ($res[$field] == $query) {
                                $why_block[] = array('field' => $field, 'value' => $res[$field]);
                            } else if ($tmp != $res[$field]) {
                                $why_block[] = array('field' => $field, 'value' => $res[$field]);
                            } else {
                                if (count($query_arrays) > 0) {
                                    foreach ($query_arrays as $one_query) {
                                        if (strlen($one_query) > 0) {
                                            $tmp = str_replace($one_query, "", $res[$field]);
                                            if ($tmp != $res[$field]) {
                                                $why_block[] = array('field' => $field, 'value' => $res[$field]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $res['why_block'] = $why_block;
                    $result[$key] = $res;
                }
            }
        }



        $answer['result'] = $result;
        $answer['count'] = $total_count;
//        $newcount = 0;
//        if (is_array($result) and count($result) > 0) {
//            foreach ($result as $key => $res) {
//                if (isset($res['tasks']) and count($res['tasks'])) {
//                    $newcount += count($res['tasks']);
//                }
//                if (isset($res['companies']) and count($res['companies'])) {
//                    $newcount += count($res['companies']);
//                }
//            }
//        }
//        $answer['count'] += $newcount;
        return $answer;
    }

    static function findCompany($query, $fullSimilarity = false, $taskStatus = null, $include = null, $maxCount = 5) {
        $condition = array();
        $condition['$or'] = array();
        $condition['$or'][] = array("name" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("inn" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("ogrn" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("kpp" => array('$options' => 'i', '$regex' => $query));
        $condition['$or'][] = array("adress" => array('$options' => 'i', '$regex' => $query));

        $condition['$or'][] = array("phone" => array('$options' => 'i', '$regex' => $query));

        $query_arrays = explode(" ", $query);
        if (count($query_arrays) > 0) {
            foreach ($query_arrays as $one_query) {
                if (strlen($one_query) > 0) {
                    $condition['$or'][] = array("name" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("inn" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("ogrn" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("kpp" => array('$options' => 'i', '$regex' => $one_query));
                    $condition['$or'][] = array("adress" => array('$options' => 'i', '$regex' => $one_query));

                    $condition['$or'][] = array("phone" => array('$options' => 'i', '$regex' => $one_query));
                }
            }
        }

        if (isset($fullSimilarity) and is_bool($fullSimilarity) and $fullSimilarity == true) {
            $condition = array();
            $condition['$or'] = array();
            $condition['$or'][] = array("name" => $query);
            $condition['$or'][] = array("inn" => $query);
            $condition['$or'][] = array("ogrn" => $query);
            $condition['$or'][] = array("kpp" => $query);
            $condition['$or'][] = array("adress" => $query);

            $condition['$or'][] = array("phone" => $query);
        }


        $result = \noicms\mongogrid\system_core\MongoQuery::execute(array(), "companys", $condition, array('last_id' => -1), $maxCount, 0);
        $total_count = \noicms\mongogrid\system_core\MongoQuery::count("companys", $condition);

        if (isset($result[0]['last_id'])) {
            
        } else {
            $result = false;
        }

        if (is_array($result)) {
//            if (count($result) > $maxCount) {
//                $arr = array_chunk($result, $maxCount);
//                $result = $arr[0];
//            }
            $or_cond = array();


            foreach ($result as $company) {
                if (isset($company['users']) and is_array($company['users']) and count($company['users'])) {
                    foreach ($company['users'] as $user) {
                        $or_cond[] = array("user.last_id" => $user['last_id']);
                    }
                }
            }

            if (!is_null($taskStatus)) {
                if (count($or_cond) > 0) {
                    $condition['$or'] = $or_cond;
                }
                if ($taskStatus == "ACTUAL") {
                    $condition = array();
                    // $condition['cron.time'] = array('$gte' => new MongoDate());
                    $condition['complete'] = array('$ne' => 1);
                } else if ($taskStatus == "COMPLETE") {
                    $condition['complete'] = 1;
                } else if ($taskStatus == "FAIL") {
                    $condition = array();
                    // $condition['cron.time'] = array('$lte' => new MongoDate());
                    $condition['fail'] = 1;
                    $condition['complete'] = array('$ne' => 1);
                } else if ($taskStatus == "ALL") {
                    
                }

                $tasks = \noicms\mongogrid\system_core\MongoQuery::execute2(array(), "tasks", $condition, array('last_id' => -1));
                if (isset($tasks[0]['last_id'])) {
                    
                } else {
                    $tasks = false;
                    //  $result = false;
                }


                if (is_array($tasks)) {
                    $newtasks = array();
                    foreach ($tasks as $key => $task) {
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
                        if (!is_null($taskStatus)) {
                            if ($taskStatus == "ACTUAL" and $status == "ACTUAL") {
                                $newtasks[] = $task;
                            } else if ($taskStatus == "COMPLETE" and $status == "COMPLETE") {
                                $newtasks[] = $task;
                            } else if ($taskStatus == "FAIL") {

                                $newtasks[] = $task;
                            } else if ($taskStatus == "ALL") {
                                $newtasks[] = $task;
                            }
                        } else {
                            $newtasks[] = $task;
                        }
                    }
                    $tasks = $newtasks;
                }
                if (isset($tasks[0]['last_id'])) {
                    
                } else {
                    $tasks = false;
                    //$result = false;
                }


                if (is_array($tasks)) {
                    $newres = array();
                    $companys = $result;

                    foreach ($result as $company) {
                        if (isset($company['users']) and is_array($company['users']) and count($company['users'])) {
                            foreach ($company['users'] as $user) {

                                $newres['id_' . $user['last_id']] = $user;
                            }
                        }
                    }
                    $result = $newres;
                    $users_final = array();
                    foreach ($tasks as $task) {
                        if (isset($task['user']['last_id']) and isset($result['id_' . $task['user']['last_id']])) {
                            if (!isset($result['id_' . $task['user']['last_id']]['tasks'])) {
                                $result['id_' . $task['user']['last_id']]['tasks'] = array();
                            }
                            $result['id_' . $task['user']['last_id']]['tasks'][] = $task;
                        }
                    }

                    foreach ($tasks as $task) {
                        if (isset($task['user']['last_id']) and isset($result['id_' . $task['user']['last_id']])) {
                            $users_final[] = $result['id_' . $task['user']['last_id']];
                            unset($result['id_' . $task['user']['last_id']]);
                        }
                    }
                    $result = $users_final;

                    foreach ($companys as $key => $company) {
                        $company['tasks'] = array();
                        if (isset($company['users']) and is_array($company['users']) and count($company['users']) > 0) {
                            foreach ($result as $user) {
                                if (isset($company['users']['id_' . $user['last_id']]) and isset($user['tasks']) and count($user['tasks']) > 0) {
                                    foreach ($user['tasks'] as $task) {
                                        $company['tasks'][] = $task;
                                    }
                                }
                            }
                        }
                        $companys[$key] = $company;
                    }

                    $result = $companys;
                }
            }

            if (!is_null($include)) {
                if (($include == "ALL" or $include == "USER") or ( is_array($include) and ( in_array("ALL", $include) or in_array("USER", $include)))) {
                    $condition = array();
                    $condition['$or'] = array();

                    foreach ($result as $row) {
                        $company = $row;
                        if (isset($company['users']) and is_array($company['users']) and count($company['users']) > 0) {
                            foreach ($company['users'] as $user) {
                                $condition['$or'][] = array("last_id" => $user['last_id']);
                            }
                        }
                    }
                    $users = false;
                    if (count($condition['$or']) > 0) {
                        $users = \noicms\mongogrid\system_core\MongoQuery::execute2(array(), "cms_users", $condition, array('last_id' => -1));
                    }
                    if (isset($users[0]['last_id'])) {
                        
                    } else {
                        $users = false;
                    }

                    if (is_array($users)) {

                        foreach ($result as $key => $company) {
                            if (isset($company['users']) and is_array($company['users']) and count($company['users']) > 0) {
                                foreach ($users as $user) {
                                    if (isset($company['users']['id_' . $user['last_id']])) {
                                        $company['users']['id_' . $user['last_id']] = $user;
                                    }
                                }
                            }
                            $result[$key] = $company;
                        }
                    }
                } else {
                    foreach ($result as $key => $company) {
                        if (isset($company['users'])) {
                            unset($company['users']);
                        }
                        $result[$key] = $company;
                    }
                }
            }

            if (($include == "ALL" or $include == "WHY") or ( is_array($include) and ( in_array("ALL", $include) or in_array("WHY", $include)))) {
                $fields_list = array('name', 'inn', 'ogrn', 'kpp', 'adress', 'phone');


                foreach ($result as $key => $res) {
                    $why_block = array();
                    foreach ($fields_list as $field) {
                        if (isset($res[$field])) {
                            $tmp = str_replace($query, "", $res[$field]);
                            if ($res[$field] == $query) {
                                $why_block[] = array('field' => $field, 'value' => $res[$field]);
                            } else if ($tmp != $res[$field]) {
                                $why_block[] = array('field' => $field, 'value' => $res[$field]);
                            } else {
                                if (count($query_arrays) > 0) {
                                    foreach ($query_arrays as $one_query) {
                                        if (strlen($one_query) > 0) {
                                            $tmp = str_replace($one_query, "", $res[$field]);
                                            if ($tmp != $res[$field]) {
                                                $why_block[] = array('field' => $field, 'value' => $res[$field]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $res['why_block'] = $why_block;
                    $result[$key] = $res;
                }
            }
        }

        $answer['result'] = $result;
        $answer['count'] = $total_count;

//        $newcount = 0;
//        if (is_array($result) and count($result) > 0) {
//            foreach ($result as $key => $res) {
//                if (isset($res['tasks']) and count($res['tasks'])) {
//                    $newcount += count($res['tasks']);
//                }
//                if (isset($res['users']) and count($res['users'])) {
//                    $newcount += count($res['users']);
//                }
//            }
//        }
//        $answer['count'] += $newcount;
        return $answer;
    }

}
