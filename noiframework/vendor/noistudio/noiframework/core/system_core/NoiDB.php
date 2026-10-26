<?php

/*
 *  
 * @package NoiCore
 *
 *
 */

namespace noicms\core;

use noicms\mongogrid\system_core\MGQuery;
use NoiCore;
use Yii;

class NoiDB {

    /**
     * @var string id site in string mongoId
     *
     */
    public $site_id = false;

    public function __construct($site_id) {
        $this->site_id = $site_id;
    }

    /**
     *  
     * NoiCore::app()->canAdd();
     *
     * @return bool
     *
     *
     */
    public function canAdd() {
        $result = NoiCore::app()->getParam("disable_auto_db");
        if (isset($result) and $result == 1) {
            return false;
        } else {
            return true;
        }
    }

    public function all($collection, $condition) {
        $collection = Yii::$app->mongodb->getCollection($collection);
        return $collection->find($condition);
    }

    /**
     * NoiCore::app()->db()->query($select,$collection,$condition,$sort,$limit,$offset);
     * @param  array $select  sample  array(); array('field1','field2');
     * @param  string $collection  name of collection  sample : name_collection
     * @param  array  $condition  sample array(); array('field1'=>'test');
     * @param  array  $sort sample array('_id'=>-1),array('_id'=>1)
     * @param  int    $limit
     * @param   int   $offset
     * @return array
     *
     * array(
     * array('field1'=>'123'),
     * array('field1'=>'124'),
     * )
     *
     *
     */
    public function query($select, $collection, $condition = array(), $sort = array('_id' => -1), $limit = 25, $offset = 0) {
        if (NoiCore::app()->db()->canAdd()) {
            if ($collection != "widget_user_sites") {
                //  $condition['site_id'] = $this->site_id;
            } else {
                $condition['_id'] = new MongoId($this->site_id);
            }
        }
        return MGQuery::execute($select, $collection, $condition, $sort, $limit, $offset);
    }

    /**
     * NoiCore::app()->db()->query2($select,$collection,$condition,$sort);
     * @param  array $select sample  array(); array('field1','field2');
     * @param  string $collection name of collection  sample : name_collection
     * @param  array  $condition  sample array(); array('field1'=>'test');
     * @param  array  $sort  sample array('_id'=>-1),array('_id'=>1)
     * @return array
     *
     * array(
     * array('field1'=>'123'),
     * array('field1'=>'124'),
     * )
     *
     *
     */
    public function query2($select, $collection, $condition = array(), $sort = array('_id' => -1)) {
        if (NoiCore::app()->db()->canAdd()) {
            if ($collection != "widget_user_sites") {
                // $condition['site_id'] = $this->site_id;
            } else {
                $condition['_id'] = new MongoId($this->site_id);
            }
        }
        return MGQuery::execute2($select, $collection, $condition, $sort);
    }

    /**
     *
     * NoiCore::app()->db()->insert($array,$collection);
     * @param array  $array data for insert
     * @param string $collection name of collection
     * @return array() inserted array
     *
     *
     *
     */
    public function insert($array, $collection, $isreturn = false) {
        if (NoiCore::app()->db()->canAdd()) {
            if ($collection != "widget_user_sites") {
                $array['site_id'] = $this->site_id;
            } else {
                $array['_id'] = new MongoId($this->site_id);
            }
        }

        return MGQuery::insert($array, $collection, $isreturn);
    }

    /**
     * NoiCore::app()->db()->count($collection,$condition);
     * @param  string $collection name of collection
     * @param  array  $condition mongodb condition
     * @return int
     *
     *
     */
    public function count($collection, $condition = array()) {
        if (NoiCore::app()->db()->canAdd()) {
            if ($collection != "widget_user_sites") {
                $condition['site_id'] = $this->site_id;
            } else {
                $condition['_id'] = new MongoId($this->site_id);
            }
        }

        return MGQuery::count($collection, $condition);
    }

    /**
     * NoiCore::app()->db()->update($array,$collection,$condition,$multiple)
     * @param array $array  data for update
     * @param string $collection  name of collection
     * @param array $condition  mongodb conditions
     * @param bool   $multiple   update 1 or all
     * @return void
     *
     */
    public function update($array, $collection, $condition, $multiple = false, $modifier = '$set') {
        if (NoiCore::app()->db()->canAdd()) {
            if ($collection != "widget_user_sites") {

                // $array['site_id'] = $this->site_id;
                //  $condition['site_id'] = $this->site_id;
            } else {
                $condition['_id'] = new MongoId($this->site_id);
            }
        }

        return MGQuery::update($array, $collection, $condition, $multiple, $modifier);
    }

    /**
     *
     * NoiCore::app()->db()->delete($collection,$criteria)
     * @param  string  $collection  name of collection
     * @param  array  $criteria  mongodb conditions
     *
     *
     */
    public function delete($collection, $criteria) {
        if (NoiCore::app()->db()->canAdd()) {
            if ($collection != "widget_user_sites") {
                $criteria['site_id'] = $this->site_id;
            } else {
                $criteria['_id'] = new MongoId($this->site_id);
            }
        }

        return MGQuery::delete($collection, $criteria);
    }

    public function distinct_count($collection, $field, $condition = array()) {
        $collection = Yii::$app->mongodb->getCollection($collection);
        $result = $collection->distinct($field, $condition);

        return count($result);
    }

}
