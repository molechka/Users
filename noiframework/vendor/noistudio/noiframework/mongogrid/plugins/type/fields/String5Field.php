<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;

class String5Field extends PluginField {

    private $length = 120;
    private $check_format = '';
    public $opt = array();

    public function __construct($field_name, $opt) {
        $this->opt = $opt;
        if (isset($opt['length']) and $opt['length'] > 0) {
            $this->length = $opt['length'];
        }
        $this->length = 16;
        $this->check_format = "/^[\a-zA-Zаеё-яАЕЁ-Я0-9_]{0," . $this->length . "}$/";

        parent::__construct("string5", $field_name, $opt);
    }

    public function getInput($value = "", $mg) {
        if ($value == "") {
            $value = $this->opt['default_value'];
        }
        $added = "class='form-control input-lg'";

        if (NoiCore::app()->isAdmin()) {
            $added = "class='form-control input-lg'";
        }
        if (NoiCore::app()->isAdmin()) {
            $template = '<input ' . $added . ' name="' . $this->getNameField() . '" type="text"  value="' . $value . '">';
        } else {
            $addstyle = "";
            if (isset($this->opt['maxl'])) {
                $addstyle = "maxlength='" . $this->opt['maxl'] . "'";
            }
            if (isset($this->opt['max'])) {
                //   $addstyle.=" data-max='".$this->opt['max']."'";
            }
            $template = '<input class="form-control " ' . $addstyle . '  name="' . $this->getNameField() . '"   type="text"   value="' . $value . '">';
        }
        return $template;
    }

    public function setInput($value = "", $mg) {
        if (!isset($_POST[$this->getNameField()])) {
            return false;
        } else {
            if (strlen($_POST[$this->getNameField()]) == 0) {
                return false;
            } else {
                return $_POST[$this->getNameField()];
            }
        }
    }

    public function renderValue($value, $mg) {
        return $value;
    }

}
