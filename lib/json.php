<?php

namespace Lib;

class Json
{


    // encodes and indents a json string
    public static function encode($json)
    {
        return json_encode($json);
    }

    public static function decode($json)
    {
        return json_decode($json, true);
    }

    public static function get_var($var_name, $o, $add_var_text = true)
    {
        if ($add_var_text) {
            echo 'var ';
        }
        echo $var_name . ' = ' . Json::encode($o) . ';';
    }
}
