<?php

namespace noicms\mongogrid\plugins\type\fields;

use NoiCore;
use noicms\mongogrid\core\PluginField;

class StringiField extends PluginField {

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

        parent::__construct("stringi", $field_name, $opt);
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
                if (isset($this->opt['isjs'])) {
                    $addstyle = "data-maxl='" . $this->opt['maxl'] . "' maxlength='" . $this->opt['maxl'] . "'";
                    $added = "class='form-control checkjs'";
                } else {
                    $addstyle = "data-maxl='" . $this->opt['maxl'] . "' maxlength='" . $this->opt['maxl'] . "'";
                    $added = "class='form-control'";
                }
            }
            if (isset($this->opt['isjs2']) and isset($this->opt['maxl'])) {
                if (isset($this->opt['jsmax'])) {
                    $addstyle .= " data-jsmax='" . $this->opt['jsmax'] . "'";
                } else {
                    $addstyle .= " data-jsmax='" . $this->opt['maxl'] . "'";
                }
            }
            if (isset($this->opt['max'])) {
                //  $addstyle .= " data-max='" . $this->opt['max'] . "'";
            }

            $template = '<input   ' . $addstyle . ' ' . $added . ' name="' . $this->getNameField() . '" type="text"  value="' . $value . '">';
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
                if (is_numeric($_POST[$this->getNameField()])) {
                    return strip_tags($_POST[$this->getNameField()]);
                } else {
                    return false;
                }
            } elseif (isset($this->opt['max']) and mb_strlen($_POST[$this->getNameField()]) > $this->opt['max']) {
                // $curlen=strlen($_POST[$this->getNameField()]);
                // NoiCore::app()->setNotify("too large for field (actual: ".$curlen.", maximum: ".$this->opt['max'].")");
                // NoiCore::app()->returnback();
                // exit;
                $field = $this->getNameField();
                $field = str_replace("noibiz_", "", $field);
                $curlen = mb_strlen($_POST[$this->getNameField()]);
                $this->opt['max'] = $this->opt['max'] - 1;
                NoiCore::app()->setNotify("too large for field " . $field . " (actual: " . $curlen . ", maximum: " . $this->opt['max'] . ")");
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
