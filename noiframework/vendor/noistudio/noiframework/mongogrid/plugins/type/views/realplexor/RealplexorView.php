<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
yii::import("ext.mongogrid.core.PluginView");
class RealplexorView extends PluginView{
    public function __construct($params) {
        parent::__construct("realplexor", $params);
    }
    public function render() {
     return $this->renderPlugin($this->params);
    }
}
?>