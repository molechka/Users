<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;

class String2Field extends PluginField {

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

        parent::__construct("string2", $field_name, $opt);
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
                //     $addstyle.=" data-max='".$this->opt['max']."'";
            }

            $template = '<input class="form-control numberfilter" ' . $addstyle . '    type="text" data-myname="' . $this->getNameField() . '"   value="' . $value . '">';
            $template .= '<input name="' . $this->getNameField() . '" class="number_' . $this->getNameField() . '" style="display:none;" ' . $addstyle . ' name="' . $this->getNameField() . '" type="text" maxlength="' . $this->length . '" value="' . $value . '">';
        }
        return $template;
    }

    public function setInput($value = "", $mg) {
        if (!isset($_POST[$this->getNameField()])) {
            return false;
        } else {
//            if (isset($this->opt['max'])) {
//                $this->opt['max'] = $this->opt['max'] - 1;
//            }

            if (isset($this->opt['max']) and mb_strlen($_POST[$this->getNameField()]) < $this->opt['max']) {
                return strip_tags($_POST[$this->getNameField()]);
            } elseif (isset($this->opt['max']) and mb_strlen($_POST[$this->getNameField()]) > $this->opt['max']) {
                // $curlen=strlen($_POST[$this->getNameField()]);
                // NoiCore::app()->setNotify("too large for field (actual: ".$curlen.", maximum: ".$this->opt['max'].")");
                // NoiCore::app()->returnback();
                // exit;
                $field = $this->getNameField();
                $field = str_replace("noibiz_", "", $field);
                $curlen = mb_strlen($_POST[$this->getNameField()]);
                $this->opt['max'] = $this->opt['max'] - 1;
                NoiCore::app()->setNotify("too large for field  " . $field . " (actual: " . $curlen . ", maximum: " . $this->opt['max'] . ")");
                NoiCore::app()->returnback();
                exit;
                return false;
            } else {
                return strip_tags($_POST[$this->getNameField()]);
            }
        }
    }

    public function renderValue($value, $mg) {
        return $value;
    }

}
