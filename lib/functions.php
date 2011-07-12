<?php

function array_value($array, $key, $default = null)
{
    if (is_array($key)) {
        $subArray = $array;
        foreach ($key as $i => $v) {
            if (is_array($subArray) && isset($subArray[$v])) {
                $subArray = $subArray[$v];
            } else {
                return $default;
            }
        }
        return $subArray;
    } else {
        return (is_array($array) && isset($array[$key]) ? $array[$key] : $default);
    }
}

function unix_random_value($bytes = 16)
{
    $fp = @fopen('/dev/urandom', 'rb');
    if ($fp !== FALSE) {
        $random = @fread($fp, $bytes);
        @fclose($fp);
    } else {
        $random = mt_rand(mt_getrandmax());
    }
    return $random;
}
