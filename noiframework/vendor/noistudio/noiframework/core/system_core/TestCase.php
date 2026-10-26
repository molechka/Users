<?php

namespace noicms\core;
use noicms\mongogrid\system_core\MGQuery;
class TestCase extends \Codeception\TestCase\Test
{
     protected function _before()
    {
     $result=MGQuery::execute2(array(), "widget_user_sites", array());
      if(isset($result[0]['_id'])){
      $array_result=$result[0];    
  //  yii::setPathOfAlias('render_site_tmp', YII_COMPONENT_PATH);
   // yii::import("render_site_tmp.view.*");
          if(!isset($array_result['route'])){
   $array_result['route']=array();
    }
    $array_result['route'][]=array('seo'=>'/sitemap.xml',"normal"=>"/sitemap/get");
    \NoiCoreSet::add($array_result);
    
    


    }
    }
}
