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
use MongoId;
include PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/JsonDB.class.php";
class NoiJson{
    private $db;
    private $type_storage="mongodb";
     function __construct() {
      require_once (DOCUMENT_ROOT."/conf/config.php");
   if(isset($config['sitestorage']) and ($config['sitestorage']=="mongodb" or $config['sitestorage']=="json")){
    $this->type_storage=$config['sitestorage'];
   }
if($this->isJson()){
         $this->db = new JsonDB(PATH_TO_ENGINE."/data/json/"); //parameter => directory to your json files
}
     }
     public function ttt(){
       return "1";
     }
     /**
      * @internal
      * NoiCore::json()->isJson();
      * @return bool
      *
      *
      */
     public function isJson(){
      if($this->type_storage=="json"){
       return true;
      }else {
        return false;
      }
     }
     /**
      * @internal
      * Insert data
      *
      * NoiCore::json()->insert($data)
      * @param array   $data  for inserting
      *
      *
      */
    public function insert($array){
    if($this->isJson()){
        $this->db -> insert ( "mysite",$array);
    }else {
        $array['_id']=new MongoId($array['_id']);
        MGQuery::insert($array,"widget_user_sites");
    }
    }
    /**
     *  
     * NoiCore::json()->get();
     *
     * @return array of data
     *
     *
     */
    public function get(){
if($this->isJson()){
        $result=$this->db ->selectAll("mysite");
        if(isset($result[0])){
          return $result[0];
        }else {
          return array();
        }
}else {
    $result=  MGQuery::execute(array(), "widget_user_sites");
    if(isset($result[0]['_id'])){
      return $result[0];
    }else {
        return array();
    }
}
}
/**
 * 
 * NoiCore::json()->update($array);
 * @param array $array   data for update
 * @return void
 *
 *
 *
 */
   public function update($array){

      if(is_array($array)){
     if($this->isJson()){
       $current_array=$this->get();
       $result = array_merge($current_array, $array);

//       if(isset($array['theme_components'])){
//       $result['theme_components']=$array['theme_components'];
//       }
       $this->db->updateAll ( "mysite",$result);
     }else {
     
         MGQuery::update($array,"widget_user_sites", array('_id'=>new MongoId(NoiCore::app()->site_data['_id']->__toString())));
     }
      }

   }

}