<?php

namespace noicms\mongogrid\system_core;

use noicms\mongogrid\system_core\MongoQuery;
use Yii;
use yii\mongodb\Query;
use noicms\core\StrInput;
use yii\data\ActiveDataProvider;
use NoiCore;

if (class_exists("MGQuery") != true) {

    if (!defined('DB_TYPE')) {
        define("DB_TYPE", "mongodb");
    }

    class MGQuery {

        static public function execute($select, $collection, $condition = array(), $sort = array('_id' => -1), $limit = 25, $offset = 0) {

            if (isset(NoiCore::app()->site_data['_id']) and $collection != "session") {
                if (NoiCore::app()->db()->canAdd()) {
                    if ($collection != "widget_user_sites" and $collection != "template_page") {
                        if (is_array($select) and count($select) > 0) {
                            $select[] = "site_id";
                        }
                        //$condition['site_id']=NoiCore::app()->site_data['_id']->__toString();
                    }
                }
            }


// if($collection=="template_page"){
////   var_dump($condition);
////   exit;
// }

            if (DB_TYPE == "mongodb") {

                return MongoQuery::execute($select, $collection, $condition, $sort, $limit, $offset);
            }
            if (DB_TYPE == "mongolite") {
                return LiteQuery::execute($select, $collection, $condition, $sort, $limit, $offset);
            }
        }

        static public function execute_one($select, $collection, $condition) {
            if (isset(NoiCore::app()->site_data['_id']) and StrInput::is_Id(NoiCore::app()->site_data['_id'])) {
                if (NoiCore::app()->db()->canAdd()) {
                    if ($collection != "widget_user_sites") {
                        if (is_array($select) and count($select) > 0) {
                            $select[] = "site_id";
                        }
                        $condition['site_id'] = NoiCore::app()->site_data['_id']->__toString();
                    }
                }
            }
            if (DB_TYPE == "mongodb") {
                return MongoQuery::execute_one($select, $collection, $condition);
            }
            if (DB_TYPE == "mongolite") {
                return LiteQuery::execute_one($select, $collection, $condition);
            }
        }

        static public function execute2($select, $collection, $condition = array(), $sort = array('_id' => -1)) {
            if (isset(NoiCore::app()->site_data['_id']) and $collection != "session") {
                if (NoiCore::app()->db()->canAdd()) {
                    if ($collection != "widget_user_sites") {
                        if (is_array($select) and count($select) > 0) {
                            $select[] = "site_id";
                        }
                        //$condition['site_id'] = NoiCore::app()->site_data['_id']->__toString();
                    }
                }
            }
            if (DB_TYPE == "mongodb") {
                return MongoQuery::execute2($select, $collection, $condition, $sort);
            }
            if (DB_TYPE == "mongolite") {
                return LiteQuery::execute2($select, $collection, $condition, $sort);
            }
        }

        static public function count($collection, $condition) {

            if (DB_TYPE == "mongodb") {
                $array_cond = $condition;
                return MongoQuery::count($collection, $array_cond);
            }
            if (DB_TYPE == "mongolite") {
                return LiteQuery::count($collection, $condition);
            }
        }

        static public function update($array, $collection, $condition, $multiple = false, $modifier = '$set') {

            if (isset(NoiCore::app()->site_data['_id']) and $modifier == '$set') {
                if (NoiCore::app()->db()->canAdd()) {
                    if ($collection != "widget_user_sites") {
                        //  $array['site_id'] = NoiCore::app()->site_data['_id']->__toString();
                        // $condition['site_id'] = NoiCore::app()->site_data['_id']->__toString();
                    }
                }
            }

// if($collection=="stats_plugin"){
//   var_dump($array);
//   exit;
// }

            if (DB_TYPE == "mongodb") {
                return MongoQuery::update($array, $collection, $condition, $multiple, $modifier);
            }
            if (DB_TYPE == "mongolite") {
                return LiteQuery::update($array, $collection, $condition, $multiple, $modifier);
            }
        }

        static public function insert($array, $collection, $isreturn = false) {


            if (isset(NoiCore::app()->site_data['_id'])) {
                if (NoiCore::app()->db()->canAdd()) {
                    if ($collection != "widget_user_sites") {

                        $array['site_id'] = NoiCore::app()->site_data['_id']->__toString();
                    }
                }
            }
            if (DB_TYPE == "mongodb") {
                return MongoQuery::insert($array, $collection, $isreturn);
            }
            if (DB_TYPE == "mongolite") {
                return LiteQuery::insert($array, $collection);
            }
        }

        static public function delete($collection, $criteria) {

            if (isset(NoiCore::app()->site_data['_id']) and $collection != "session") {
                if (NoiCore::app()->db()->canAdd()) {
                    if ($collection != "widget_user_sites") {

                        $criteria['site_id'] = NoiCore::app()->site_data['_id']->__toString();
                    }
                }
            }
            if (DB_TYPE == "mongodb") {
                return MongoQuery::delete($collection, $criteria);
            }
            if (DB_TYPE == "mongolite") {
                return LiteQuery::delete($collection, $criteria);
            }
        }

        public static function getCollection($collection) {
            return Yii::$app->mongodb->getCollection($collection);
        }

        public static function getDB($collection) {
            return EDMSQuery::instance($collection)->getDb();
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

}
?>