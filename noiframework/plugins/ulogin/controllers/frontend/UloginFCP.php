<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UloginFCP
 *
 * @author megamind
 */
class UloginFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("ulogin",$cur,$route);

    }
 
}
