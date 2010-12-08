<?php

function array_value($array, $value)
{
    if (is_array($value)) {
        $subArray = $array;
        foreach ($value as $i => $v) {
            if (is_array($subArray) && isset($subArray[$v])) {
                $subArray = $subArray[$v];
            } else {
                return null;
            }
        }
        return $subArray;
    } else {
        return (is_array($array) && isset($array[$value]) ? $array[$value] : null);
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
