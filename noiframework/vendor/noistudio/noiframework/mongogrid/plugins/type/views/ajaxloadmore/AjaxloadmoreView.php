<?php

yii::import("ext.mongogrid.core.PluginView");
class AjaxloadmoreView extends PluginView{
    public function __construct($params) {
        parent::__construct("ajaxloadmore", $params);
    }
    public function render() {
     return $this->renderPlugin($this->params);
    }
}
?>