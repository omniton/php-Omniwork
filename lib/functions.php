<?php

function array_value(&$array, $value)
{
    return (isset($array[$value]) ? $array[$value] : null);
}

function unix_random_value()
{
    $fp = @fopen('/dev/urandom','rb');
    if ($fp !== FALSE) {
        $random = @fread($fp,16);
        @fclose($fp);
    } else {
        $random = mt_rand(mt_getrandmax());
    }
    return $random;
}
