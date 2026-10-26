<?php

use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use mg\models\Collections;
use mg\models\ManipulateDocuments;
class ArrowsMgACP  extends CoreAdminControllerPlugin{
    public function actionIndex($last_id,$name_collection,$type="up"){
         if(isset($name_collection)  and isset($last_id) and  is_numeric($last_id) and ($type=="down" or $type=="up")){
   $collection=Collections::getManage($name_collection);
   if(is_array($collection)){
   
   $manipulate=new ManipulateDocuments($collection,$last_id,$type);
   }
    }
    NoiCore::app()->returnback();
    exit;
}
}

