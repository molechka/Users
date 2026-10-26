<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Widgets
 *
 * @author backdoor
 */
class Widgets {
    
    public function runAction($cur){
     $site=NoiCore::app()->site_data['_id']->__toString();
     if(isset($_SERVER['REQUEST_URI'])){
    $route_tmp=str_replace("/widgets/","",$_SERVER['REQUEST_URI']);
    $explode_tmp=explode("/",$route_tmp);
    if(isset($explode_tmp[0]) and isset($explode_tmp[1])){
      $site_data=NoiCore::app()->db()->query(array(),"widget_user_sites",array('_id'=>new MongoId($site)));
      if(isset($site_data[0]['_id'])){
       $site_data=$site_data[0];
      if(isset($site_data['theme_components']['widgets']['position'][$explode_tmp[0]][$explode_tmp[1]])){
        $cur_route=array();
        if(isset($explode_tmp[3]) and isset($explode_tmp[2])){
         $new_i=3;
         while(isset($explode_tmp[$new_i])){
           $cur_route[]=$explode_tmp[$new_i];
             $new_i++;
         }
        }
               $cur_route=implode("/",$cur_route);

          $plugin_name=$explode_tmp[2];
          $param=$cur_route;
          $iswidget=1;
          $widget=array('position'=>$explode_tmp[0],"number"=>$explode_tmp[1]);
   return      NoiCore::c("plugins")->run($plugin_name,$param,$iswidget,$widget,$cur);
      }
      }
    }


     }   
    }

}
