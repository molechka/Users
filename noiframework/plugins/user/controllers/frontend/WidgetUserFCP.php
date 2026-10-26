<?php

class WidgetUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {

        parent::__construct("user",$cur,$route);
        $this->iswidget=0;


    }
    public function actionLast($count=6){
      
         $this->iswidget=0;
         $main=$this->get_value();
         
         if(isset($main[0]['collection'])){
         $last_users=$this->db()->query(array(),$main[0]['collection'],array('blocked'=>array('$ne'=>1),"enable_account"=>1),array('_id'=>-1),$count);
       
         if(count($last_users)>0){
          return $this->render("widget_last",array('users'=>$last_users));
         }
         }
    }
}


