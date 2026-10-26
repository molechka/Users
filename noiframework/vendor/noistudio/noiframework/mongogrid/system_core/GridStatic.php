<?php

namespace noicms\mongogrid\system_core;

use NoiCore;
use MongoId;

class GridStatic {

    public static function getbyID($condition, $mg) {
        if (is_array($condition)) {
            $result = MGQuery::execute(array(), $mg->collection, $condition, $mg->sort, 1, 0);

            if (isset($result[0]['_id'])) {
                return $result[0];
            } else {
                return false;
            }
        }
    }

    public static function eventClone($mg) {
        $result = GridStatic::eventShow($mg);
        if (isset($result[0]['_id'])) {
            $new_insert = $result[0];
            $new_insert['_id'] = new MongoId();
            if (isset($new_insert['last_id'])) {
                unset($new_insert['last_id']);
            }
            NoiCore::app()->db()->insert($new_insert, $mg->collection, true);
            $mg->status->old_result = $new_insert;
            $mg->status->new_result = $new_insert;

            $mg->fields->row = $new_insert;
            $mg->view->rerender = false;
            $mg->view->route = "/list/1";
            $mg->view->message_notify = NoiCore::app()->lang('mongogrid_create_notify') . " <a href='" . $mg->url . "'> " . NoiCore::app()->lang('mongogrid_return_back') . "</a>";
            NoiCore::app()->setNotify("Успешно склонировано!");
            NoiCore::app()->redirect($mg->url);
            exit;
            return true;
        }
        return true;
    }

    public static function eventCreate($mg) {
        $operation = $mg->operations->default_operation;
        $mg->status->operation = "create";
        $mg->status->status = 0;

        if (isset($_POST['act_create_' . $mg->name_short])) {
            $validate = $mg->fields->getArrayQuery(true);

//         if($this->name_short=="image_5277d42c951d9b9463000001"){
//
//        }

            if ((isset($validate['status'])) or ( is_array($validate))) {
                $array_insert = $validate;
                $continue_insert = true;
                if (isset($validate['status']) and $validate['status'] == false) {
                    $continue_insert = false;
                }
                if ($continue_insert == true or ! isset($validate['message_notify'])) {
                    $mg->status->status = 1;
                    if (!isset($array_insert['_id'])) {
                        $array_insert['_id'] = new \MongoId();
                    }
                    NoiCore::app()->db()->insert($array_insert, $mg->collection, true);
                    $mg->status->old_result = $array_insert;
                    $mg->status->new_result = $array_insert;

                    $mg->fields->row = $array_insert;
                    $mg->view->rerender = false;
                    $newuri = $_SERVER['REQUEST_URI'];
                    $newuri = str_replace("path_grid", "asdasd", $newuri);


                    NoiCore::app()->redirect($newuri);
                    exit;
                    $mg->view->message_notify = NoiCore::app()->lang('mongogrid_create_notify') . " <a href='" . $mg->url . "'> " . NoiCore::app()->lang('mongogrid_return_back') . "</a>";
                    return true;
                } else {
                    $mg->status->status = 0;
                    $mg->view->message_notify = $validate['message_notify'];
                    NoiCore::app()->setNotify($validate['message_notify']);
                    return false;
                }
            } else {
                if (isset($validate['message_notify'])) {
                    $mg->view->message_notify = $validate['message_notify'];
                    $mg->view->route = $validate['route'];
                    $mg->view->rerender = true;
                    $mg->status->status = 0;
                } else {
                    $mg->view->route = "/" . $mg->operations->default_operation . "/1";
                }
                $mg->view->rerender = true;
                return false;
            }
        }

        return true;
    }

    public static function update_entry_blog($mg) {
        if (isset($mg->fields->row['tags']) and is_array($mg->fields->row['tags']) and count($mg->fields->row['tags']) > 0) {
            $new_tags = $mg->fields->row['tags'];
            foreach ($new_tags as $tag) {
                $tag = strtolower($tag);
                $count = NoiCore::app()->db()->count("blog_tags", array('tag' => $tag));
                if ($count == 0) {
                    $array_tag = array();
                    $array_tag['tag'] = $tag;
                    NoiCore::app()->db()->insert($array_tag, "blog_tags");
                }
            }
        }
    }

    public static function eventUpdate($mg) {
        return GridStatic::eventUpdate2($mg);
        $mg->status->operation = "update";
        $mg->status->status = 0;
        if (isset($_POST['act_update'])) {
            $operation = $mg->operations->default_operation;

            $validate = $mg->fields->getArrayQuery(true);


            if (is_array($validate) and ! isset($validate['message_notify']) and ! isset($validate['route'])) {
                $collection = $query = new EDMSQuery($mg->collection);
                $condition = $mg->condition;
                if (isset($condition['_id'])) {
                    if (DB_TYPE == "mongodb") {
                        $condition['_id'] = new \MongoId($mg->operations->default_value);
                    }
                    if (DB_TYPE == "mongolite") {
                        $condition['_id'] = $mg->operations->default_value;
                    }
                }
                $mg->result = GridStatic::getbyID($condition, $mg);

                MGQuery::update($validate, $mg->collection, $condition);
                $mg->view->message_notify = NoiCore::app()->lang('mongogrid_create_notify') . " <a href='" . $mg->url . "'> " . NoiCore::app()->lang('mongogrid_return_back') . "</a>";
                $mg->view->route = "/" . $mg->operations->default_operation . "/1";
            } else {
                if (isset($validate['message_notify'])) {
                    $mg->view->message_notify = $validate['message_notify'];
                    $mg->view->route = $validate['route'];
                    $mg->view->rerender = true;
                } else {
                    $mg->view->route = "/" . $mg->operations->default_operation . "/1";
                }
            }
        } else {
            
        }
        if (DB_TYPE == "mongodb") {
            $criteria = array('_id' => new \MongoId($mg->operations->default_value));
        }
        if (DB_TYPE == "mongolite") {
            $criteria = array('_id' => ($mg->operations->default_value));
        }
        $result = $mg->fields->model->getList($mg->fields->array_fields, $mg->collection, $criteria, 1, 0);

        return $result;
    }

    public static function eventUpdate2($mg) {
        $mg->status->operation = "update";
        $mg->status->status = 0;

        $condition = $mg->condition;
        if (!isset($condition['_id'])) {
            if (DB_TYPE == "mongodb") {
                $condition['_id'] = new \MongoId($mg->operations->default_value);
            }
            if (DB_TYPE == "mongolite") {
                $condition['_id'] = $mg->operations->default_value;
            }
        }
        $mg->status->old_result = GridStatic::getbyID($condition, $mg);

        if (isset($_POST['act_update'])) {
            $operation = $mg->operations->default_operation;

            $validate = $mg->fields->getArrayQuery(true);


            $result = MGQuery::execute($mg->fields->array_fields, $mg->collection, $condition, array('_id' => -1), 1, 0);
            $mg->status->old_result = $result[0];
            $mg->fields->row = $result[0];
            if (!NoiCore::app()->isAdmin()) {
                if (isset($_POST['noibiz_inn']) and is_string($_POST['noibiz_inn']) and strlen($_POST['noibiz_inn']) > 1) {
                    if (is_numeric($_POST['noibiz_inn']) and strlen($_POST['noibiz_inn']) == 12) {
                        
                    } else {

                        NoiCore::app()->setNotify("ИНН ФЛ должен содержать 12 цифр");
                        NoiCore::app()->returnback();
                        exit;
                    }
                }
            }


            if (is_array($validate) and ! isset($validate['message_notify']) and ! isset($validate['route'])) {
                NoiCore::app()->db()->update($validate, $mg->collection, $condition);
                $mg->status->status = 1;
                $newurl = $mg->url;

                $session_test = NoiCore::app()->getSession("mongogrid_" . $mg->name_short);
                if ($session_test != false) {
                    $newurl = $session_test;
                }
                $mg->view->message_notify = NoiCore::app()->lang('mongogrid_create_notify') . " <a href='" . $newurl . "'> " . NoiCore::app()->lang('mongogrid_return_back') . "</a>";
                $mg->view->route = "/" . $mg->operations->default_operation . "/1";
                $mg->view->rerender = false;

                $newuri = $_SERVER['REQUEST_URI'];
                $newuri = str_replace("/", "_", $newuri);
                $referer = NoiCore::app()->getSession("link_");
                if (is_string($referer)) {
                    NoiCore::app()->redirect($referer);
                } else {
                    NoiCore::app()->redirect($mg->url);
                }
            } else {
                if (isset($validate['message_notify'])) {
                    $mg->status->status = 0;
                    $mg->view->message_notify = $validate['message_notify'];

                    NoiCore::app()->setNotify($validate['message_notify']);
                    NoiCore::app()->returnback();
                    exit;
                    $mg->view->route = $validate['route'];
                    $mg->view->rerender = true;
                } else {
                    $mg->view->route = "/" . $mg->operations->default_operation . "/1";
                }
            }
        } else {
            if (isset($_SERVER['HTTP_REFERER'])) {
                $referer = $_SERVER['HTTP_REFERER'];
                $referer = str_replace("http://", "", $referer);
                $referer = str_replace("https://", "", $referer);
                $referer = str_replace($_SERVER['HTTP_HOST'], "", $referer);
                if ($_SERVER['REQUEST_URI'] != $referer) {
                    $newuri = $_SERVER['REQUEST_URI'];
                    $newuri = str_replace("/", "_", $newuri);
                    NoiCore::app()->setSession("link_", $referer);
                }
            }
        }

        //   $criteria=array('_id'=>new MongoId($mg->operations->default_value));
        //$result=$mg->fields->model->getList($mg->fields->array_fields, $mg->collection,$criteria,1,0);

        $result = MGQuery::execute($mg->fields->array_fields, $mg->collection, $condition, array('_id' => -1), 1, 0);
//    var_dump($result);
//    exit;
        $mg->status->new_result = $result[0];
        $mg->view->rerender = false;
        return $result;
    }

    public static function eventShow($mg) {
        $criteria = $mg->condition;
        if (!isset($criteria['_id'])) {
            if (DB_TYPE == "mongodb") {
                $criteria = array('_id' => new \MongoId($mg->operations->default_value));
            }
            if (DB_TYPE == "mongolite") {
                $criteria = array('_id' => $mg->operations->default_value);
            }
            $criteria = array('_id' => new \MongoId($mg->operations->default_value));
        }
        $result = MGQuery::execute($mg->fields->array_fields, $mg->collection, $criteria, array('_id' => -1), $mg->page_item, $mg->offset);
        return $result;
    }

    public static function eventDelete($mg) {
        $mg->status->operation = "delete";
        $mg->status->status = 0;
        $operation = $mg->operations->default_operation;

        if (isset($mg->condition['_id'])) {
            $array_remove = $mg->condition;
        } else {
            $array_remove = array('_id' => new \MongoId($mg->operations->default_value));
            if (DB_TYPE == "mongodb") {
                $array_remove = array('_id' => new \MongoId($mg->operations->default_value));
            }
            if (DB_TYPE == "mongolite") {
                $array_remove = array('_id' => $mg->operations->default_value);
            }
        }

        $mg->status->old_result = GridStatic::getbyID($array_remove, $mg);
        $mg->fields->clearAfter();

        if (count($mg->condition) > 0) {
            foreach ($mg->condition as $key => $value) {
                $array_remove[$key] = $value;
            }
        }



        $mg->status->status = 1;
        NoiCore::app()->db()->delete($mg->collection, $array_remove);
        $mg->view->message_notify = NoiCore::app()->lang('mongogrid_create_notify') . " <a href='" . $mg->url . "'> " . NoiCore::app()->lang('mongogrid_return_back') . "</a>";
        $mg->view->route = "/" . $mg->operations->default_operation . "/1";
        $mg->view->rerender = true;

        $mg->fields->clearTrash();
        NoiCore::app()->setNotify("Успешно удалено!");
        if (NoiCore::app()->isAdmin()) {
            NoiCore::app()->redirect($mg->clearUrl());
            exit;
        }
        return false;
    }

    public static function eventList($mg) {

        // $mg->offset=NoiCore::c("ppaginator")->getOffset($mg->page_item);


        $result = MGQuery::execute(array(), $mg->collection, $mg->condition, $mg->sort, $mg->page_item, $mg->offset);
        if (!isset($result[0]['_count_'])) {
            $result[0]['_count_'] = 0;
        }
        NoiCore::app()->setSession("mongogrid_" . $mg->name_short, NoiCore::route()->get());
        return $result;
    }

}
