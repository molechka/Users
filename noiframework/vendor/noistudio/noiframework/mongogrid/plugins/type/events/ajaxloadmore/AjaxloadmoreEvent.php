<?php
yii::import("ext.mongogrid.core.PluginEvent");
class AjaxloadmoreEvent extends PluginEvent{
    public function __construct( $params) {
        parent::__construct("ajaxloadmore", $params);
    }
    public function execute($mg) {

     if(isset($this->params['class_div_insert']) and isset($this->params['endtag'])){
    $tmp=explode('class="'.$this->params['class_div_insert'].'">',$mg->view->current_html);

    if(isset($tmp[1])){
   
    $newtmp=explode($this->params['endtag'],$tmp[1]);
    if(isset($newtmp[0])){

      return $newtmp[0];
    }
    }
    }
    
    }

}
?>