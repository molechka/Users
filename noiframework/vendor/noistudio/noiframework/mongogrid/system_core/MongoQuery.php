<?php

namespace noicms\mongogrid\system_core;

use Yii;
use MongoDate;
use NoiCore;
use MongoId;
use Exception;
use yii\data\ActiveDataProvider;

class MongoQuery {

    static public function execute($select, $collection, $condition = array(), $sort = array('_id' => -1), $limit = 25, $offset = 0) {
        $criteria = $condition;

        $query = new Query;
        $query->sort = $sort;
        $query->off2 = $offset;
        $query->from($collection)->where($condition)->offset($limit)->limit($limit);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
            ]
        ]);
        $models = $provider->getModels();

        return $models;
    }

    static public function execute_one($select, $collection, $condition) {
        $result = MongoQuery::execute($select, $collection, $condition);
        $result_one = array();
        if (isset($result[0])) {
            $result_one = $result[0];
        }
        return $result_one;
    }

    static public function execute2($select, $collection, $condition = array(), $sort = array('_id' => -1)) {
        $criteria = $condition;


        $query = new Query;
        $query->sort = $sort;
        $query->from($collection)->where($condition);


        return $query->all();
    }

    static public function count($collection, $condition) {
        if (isset($collection) and is_array($condition)) {

            //  $count=EDMSQuery::instance($collection)->findCount($condition);
            $query = new Query;
            $query->from($collection)->where($condition);

            return $query->count();
        } else {

            return 0;
        }
    }

    static public function update($array, $collection, $condition, $multiple = false, $modifier = '$set') {
        if (isset($array) and isset($collection) and isset($condition)) {

            if ($collection != "history_collection_updates") {
                if ($collection != "stats_plugin" and $collection != "widget_user_sites") {
                    if ($collection == "cms_users" and ( !isset($array['last_update_time']) and ! isset($array['status_user']))) {
                        $e = new Exception;

                        $array_ins = array();
                        $array_ins['_id'] = new MongoId();
                        $array_ins['collection'] = $collection;
                        $array_ins['condition'] = $condition;
                        $array_ins['date'] = new MongoDate();
                        $array_ins['update'] = $array;

                        $result_trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 5);
                        $new_result = array();
                        if (count($result_trace) > 0) {
                            foreach ($result_trace as $tr) {
                                if (isset($tr['file'])) {
                                    $newfile = str_replace("vendor/noicms", "", $tr['file']);
                                    if ($tr['file'] == $newfile) {
                                        $new_result[] = array('file' => $tr['file'], "line" => $tr['line'], "function" => $tr['function']);
                                    }
                                }
                            }
                        }
                        $array_ins['trace'] = $new_result;
                        MongoQuery::insert($array_ins, 'history_collection_updates');
                    }
                }
            }
            // $collection=new EDMSQuery($collection);
            $collection = Yii::$app->mongodb->getCollection($collection);
            $action = is_array($modifier) ? $modifier : array($modifier => $array);
            $options = array();
            if ($multiple == true) {
                $options['multiple'] = true;
            }

            return $collection->update($condition, $action, $options);
        }
    }

    static public function getLastId($collection) {
        if ($collection == "cms_users") {
            $last_id = rand(111111, 999999);
            $count = MongoQuery::count($collection, array('last_id' => $last_id));
            while ($count > 0) {
                $last_id = rand(111111, 999999);
                $count = MongoQuery::count($collection, array('last_id' => $last_id));
            }
            return $last_id;
        } else {
            $name_collection = $collection;

            $name = "userid";
            $collection = Yii::$app->mongodb->getCollection("noicms_counters");
            $retval = $collection->findAndModify(
                    array('last_id' => $name_collection . "_" . $name), array('$inc' => array("seq" => 1)), null, array(
                "new" => true,
                    )
            );

            if ($retval === NULL or ( isset($retval) and ! isset($retval['seq']))) {
                $result = MongoQuery::execute(array(), $name_collection, array(), array('_id' => -1), 1);
                if (isset($result[0]['last_id'])) {
                    $array_insert = array();
                    $array_insert['last_id'] = $name_collection . "_" . $name;
                    $array_insert['seq'] = $result[0]['last_id'];
                } else {
                    $array_insert = array();
                    $array_insert['last_id'] = $name_collection . "_" . $name;
                    $array_insert['seq'] = 1;
                }
                MongoQuery::insert($array_insert, "noicms_counters");
                return MongoQuery::getLastId($name_collection);
            } else {

                return $retval['seq'];
            }
        }
    }

    static public function insert(&$array, $collection, $isreturn = false) {
        if (is_array($array) and isset($collection)) {
            $name_collection = $collection;
            $collection = Yii::$app->mongodb->getCollection($collection);
            if (!isset($array['last_id']) and $name_collection != "noicms_counters") {

                $last_id = MongoQuery::getLastId($name_collection);
                if (is_null($last_id)) {
                    $last_id = 1;
                }
                $array['last_id'] = $last_id;
            }
            if (isset($array['last_id'])) {
                $array['order_last_id'] = $array['last_id'];
            }

            $result_op = $collection->insert($array);
            if ($isreturn == true) {
                return $array;
            } else {
                return $result_op;
            }

            //return true;
        } else {
            return false;
        }
    }

    static public function delete($collection, $criteria) {
        $name_collection = $collection;
        if (isset($collection) and is_array($criteria)) {
            if ($collection == "trash_collection" or $collection == "stats_load" and ! NoiCore::app()->isAdmin()) {

                $collection = Yii::$app->mongodb->getCollection($collection);
                $options = array();




                return $collection->remove($criteria);
            } else {
                if ($name_collection == "cms_users") {
                    $users = MongoQuery::execute(array(), "cms_users", $criteria);
                    var_dump($users);
                    if (isset($users[0]['last_id'])) {
                        $user = $users[0];

                        $res = NoiCore::app()->db()->update(array('user' => true), "tasks", array("user.last_id" => (int) $user['last_id']), true, '$unset');

                        $companys = MongoQuery::execute2(array(), 'companys', array('users.id_' . $user['last_id'] . ".last_id" => $user['last_id']));
                        if (isset($companys[0]['last_id'])) {
                            foreach ($companys as $company) {
                                $update = array();
                                $update['users'] = $company['users'];
                                unset($update['users']['id_' . $user['last_id']]);
                                MongoQuery::update($update, 'companys', array('last_id' => $company['last_id']));
                            }
                        }
                    }
                }
                $collection_new = Yii::$app->mongodb->getCollection("trash_collection");
                $query = new Query;
                $query->sort = array('_id' => -1);

                $query->from($collection)->where($criteria)->offset(0)->limit(1);
                $provider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 1,
                    ]
                ]);
                $models = $provider->getModels();
                if (isset($models[0]['_id'])) {
                    $new_array = array();
                    $new_array['row'] = $models[0];
                    $new_array['collection'] = $collection;
                    $new_array['date'] = new MongoDate;
                    $collection_new->insert($new_array);
                    $collection = Yii::$app->mongodb->getCollection($collection);
                    $options = array();




                    return $collection->remove($criteria);
                }
            }
        }
    }

    public function getList($fields, $collection, $where = array(), $limit = 25, $offset = 0) {
        $criteria = $where;
        if (isset($this->search_value) and isset($this->search_field)) {
            $criteria[$this->search_field] = $this->search_value;
        }


        $select = $fields;
        $sort = array('_id' => -1); //age desc



        $result = EDMSQuery::instance($collection)->findArray($criteria, array(), $sort, $limit, $offset);
        $count = EDMSQuery::instance($collection)->findCountBy(array('_id'), $criteria);
        $result[0]['_count_'] = count($count);
        return $result;
    }

}

?>