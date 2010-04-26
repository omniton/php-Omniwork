<?php

function array_value(&$array, $value)
{
    return (isset($array[$value]) ? $array[$value] : null);
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
