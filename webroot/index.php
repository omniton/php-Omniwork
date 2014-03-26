<?php
// System directories & config file
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('PATH_WEBROOT', dirname(__FILE__));
define('PATH_ROOT', empty($_SERVER['PATH_ROOT']) ? dirname(PATH_WEBROOT) : $_SERVER['PATH_ROOT']);
define('PATH_ETC', empty($_SERVER['PATH_ETC']) ? PATH_ROOT . DS . 'etc'
: $_SERVER['PATH_ETC']);
define('PATH_VAR', empty($_SERVER['PATH_VAR']) ? PATH_ROOT . DS . 'var'
: $_SERVER['PATH_VAR']);
define('PATH_TMP', empty($_SERVER['PATH_TMP']) ? PATH_ROOT . DS . 'tmp'
: $_SERVER['PATH_TMP']);
define('PATH_SYSTEM', empty($_SERVER['PATH_SYSTEM']) ? PATH_ROOT . DS . 'lib'
: $_SERVER['PATH_SYSTEM']);

// set the include-path
set_include_path(PATH_ROOT . PS . PATH_SYSTEM);

// load extended functions & Solar
require_once 'functions.php';
require_once 'Solar.php';

// start Solar with config file
Solar::start(PATH_ETC . DS . 'default.php');

// instantiate and run the front controller
Solar_Registry::get('controller_front')->display();

// Done!
Solar::stop();
