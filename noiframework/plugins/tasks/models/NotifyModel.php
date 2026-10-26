<?php

namespace tasks\models;

use MongoDate;
use NoiCore;

class NotifyModel
{
    public static function returntologin()
    {
        $backlink=$_SERVER['QUERY_STRING'];

        NoiCore::app()->setSession("backlink", $backlink);
        NoiCore::app()->redirect("/user/login/index");
    }
    public static function doAdd($task, $title, $user=array())
    {
        if (!isset($user['_id'])) {
            $user=NoiCore::user()->load();
        }
        $array=array();
        $array['task']=$task;
        $array['title']=$title;
        $array['date']=new MongoDate();
        $array['user']=$user;
        NoiCore::app()->db()->insert($array, "notify_list");
    }
    public static function count()
    {
        $user=NoiCore::user()->load();
        $condition=array();
        if (isset($user['ismanager']) and (int)$user['ismanager']==1) {
        } else {
            $condition['user._id']=$user['_id'];
        }
        $condition['read']=array('$ne'=>1);
        $count=NoiCore::app()->db()->count("notify_list", $condition);
        return $count;
    }
}
