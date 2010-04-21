<?php
// System directories & config file
define('PATH_WEBROOT', dirname(__FILE__));

// TODO handle env vars
$root = dirname(PATH_WEBROOT);
$etc = $root . DIRECTORY_SEPARATOR . 'etc';
$var = $root . DIRECTORY_SEPARATOR . 'var';
$tmp = $root . DIRECTORY_SEPARATOR . 'tmp';
$system = $root . DIRECTORY_SEPARATOR . 'lib';

define('PATH_ROOT', $root);
define('PATH_SYSTEM', $system);
define('PATH_ETC', $etc);
define('PATH_VAR', $var);
define('PATH_TMP', $tmp);

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