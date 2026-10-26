<?php
/*
 *
 * @package NoiCore
 *
 *
 */
namespace noicms\core;
use NoiCore;
use Yii;
class NoiRoute{
    /**
     *
     * @var array of site_data
     */
     public $site_data=false;
      /**
      * @var string id site in string mongoId
      *
      */
     public $site_id=false;
     public $route="";
      public function __construct($site_data) {
     if(isset($site_data) and is_array($site_data) and isset($site_data['_id'])){
     $this->site_id=$site_data['_id']->__toString();
     $this->site_data=$site_data;
     }
     }
   public function replace($return){
      $site_data=NoiCore::app()->site_data;
      $this->site_data=$site_data;

      if(isset($this->site_data['route']) and is_array($this->site_data['route']) and count($this->site_data['route'])>0){

       foreach($this->site_data['route'] as $route){

       if(isset($route['seo']) and isset($route['normal'])){

       $return=str_replace($route['normal'],$route['seo'],$return);
       if(isset($_SERVER['REQUEST_URI'])){

       $_SERVER['REQUEST_URI']=str_replace($route['seo'],$route['normal'],$_SERVER['REQUEST_URI']);

       }
       }
       }
      }

      return $return;
     }
     public function set($path_route){
      $this->route=$path_route;
     }
     public function get(){
       if(!NoiCore::app()->isAdmin()){
        return $this->route;   
       }else {
        if(isset($_SERVER['REQUEST_URI'])){
            return $_SERVER['REQUEST_URI'];
        }else {
            return "";
        }
       }  
       
     }
}

