<?php

yii::import("ext.mongogrid.core.PluginView");
class AjaxaddView extends PluginView{
    public function __construct($params) {
        parent::__construct("ajaxadd", $params);
    }
    public function render() {
     return $this->renderPlugin($this->params);
    }
}

?>