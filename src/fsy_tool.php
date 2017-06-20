<?php
if (!function_exists('dv_arr')) {
    function dv_arr($vars, $label = '', $return = false)
    {
        if (ini_get('html_errors')) {
            $content = "<pre>\n";
            if ($label != '') {
                $content .= "<strong>{$label} :</strong>\n";
            }
            $content .= htmlspecialchars(print_r($vars, true));
            $content .= "\n</pre>\n";
        } else {
            $content = $label . " :\n" . print_r($vars, true);
        }
        if ($return) {
            return $content;
        }
        echo $content;
        return null;
    }
}
if (!function_exists('dv')) {
    function dv($value, $tag = 'dv')
    {
        if (config('app_debug', true)) {
            if (is_array($value)) {
                echo $tag ? $tag . ':<br>' : '';
                dv_arr($value);
                echo "----------------------<br>";
            } else {
                if ($tag) {
                    echo '<font color=blue>' . $tag . '=' . $value . '</font><br>';
                } else {
                    echo '<font color=blue>' . $value . '</font><br>';
                }
            }
        }
    }
}
if (!function_exists('dd')) {
    function dd($value)
    {
        dv($value);
        die();
    }
}
if (!function_exists('config')) {
    function config($name, $default = '')
    {
        //      测试环境获取配置
        $arr = explode('.', $name);
        $path = __DIR__;
        if (strstr(__DIR__, "vendor")) {
            $path = $path . '/../../..';
        }
        $path = $path . '/../config/' . $arr[0] . '.php';
        if (!file_exists($path)) {
            return $default;
        }
        $conf = require $path;// 此处不能用用require_once
        if (sizeof($arr) > 1) {
            for ($i = 1; $i < sizeof($arr); $i++) {
                if (array_key_exists($arr[$i], $conf)) {
                    $conf = $conf[$arr[$i]];
                } else {
                    return $default;
                }
            }
        }
        return $conf;
    }

}