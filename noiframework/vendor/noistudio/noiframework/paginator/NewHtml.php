<?php

namespace noicms\paginator;
use yii\helpers\BaseHtml;
class NewHtml extends BaseHtml
{
    public static function a($text, $url = null, $options = [])
    {
         
        if ($url !== null) {
            $options['href'] = $url;
        }
        return static::tag2('a', $text, $options);
    }
     public static function tag2($name, $content = '', $options = [])
    {

        $html = "<$name" . static::renderTagAttributes2($options) . '>';
      
       
        return isset(static::$voidElements[strtolower($name)]) ? $html : "$html$content</$name>";
    }
     public static function renderTagAttributes2($attributes)
    {
        if (count($attributes) > 1) {
            $sorted = [];
            foreach (static::$attributeOrder as $name) {
                if (isset($attributes[$name])) {
                    $sorted[$name] = $attributes[$name];
                }
            }
            $attributes = array_merge($sorted, $attributes);
        }

        $html = '';
        foreach ($attributes as $name => $value) {
            if (is_bool($value)) {
                 
                if ($value) {
                    $html .= " $name";
                }
            } elseif (is_array($value) && $name === 'data') {
                foreach ($value as $n => $v) {

                    if (is_array($v)) {
                        $html .= " $name-$n='" . Json::encode($v, JSON_HEX_APOS) . "'";
                    } else {
                        $html .= " $name-$n=\"" . $v . '"';
                    }
                }
            } elseif ($value !== null) {
                $html .= " $name=\"" . $value . '"';
            }
        }

        return $html;
    }
}

