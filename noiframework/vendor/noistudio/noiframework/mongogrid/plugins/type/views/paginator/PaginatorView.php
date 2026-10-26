<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
use noicms\mongogrid\core\PluginView;
class PaginatorView extends PluginView{
    public function __construct($params) {
        parent::__construct("paginator", $params);
    }
    public function render() {
     return $this->renderPlugin($this->params);
    }
}
?>