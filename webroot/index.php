<?php
// System directories & config file
define('PATH_WEBROOT', dirname(__FILE__));
define('PATH_ROOT', empty($_SERVER['PATH_ROOT']) ? dirname(PATH_WEBROOT) : $_SERVER['PATH_ROOT']);
define('PATH_ETC', empty($_SERVER['PATH_ETC']) ? PATH_ROOT . DIRECTORY_SEPARATOR . 'etc'
    : $_SERVER['PATH_ETC']);
define('PATH_VAR', empty($_SERVER['PATH_VAR']) ? PATH_ROOT . DIRECTORY_SEPARATOR . 'var'
    : $_SERVER['PATH_VAR']);
define('PATH_TMP', empty($_SERVER['PATH_TMP']) ? PATH_ROOT . DIRECTORY_SEPARATOR . 'tmp'
    : $_SERVER['PATH_TMP']);
define('PATH_SYSTEM', empty($_SERVER['PATH_SYSTEM']) ? PATH_ROOT . DIRECTORY_SEPARATOR . 'lib'
    : $_SERVER['PATH_SYSTEM']);

// set the include-path
set_include_path(PATH_ROOT . PATH_SEPARATOR . PATH_SYSTEM);

// load Solar
require_once 'Solar.php';

// start Solar with config file
Solar::start(PATH_ETC . DIRECTORY_SEPARATOR . 'default.php');

// instantiate and run the front controller
Solar_Registry::get('controller_front')->display();

// Done!
Solar::stop();
?>