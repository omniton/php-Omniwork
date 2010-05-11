<?php

$config = array();

/**
 * ini_set values
 */
$config['Solar']['ini_set'] = array(
    'error_reporting'   => (E_ALL | E_STRICT),
    'display_errors'    => true,
    'html_errors'       => true,
    'session.save_path' => PATH_TMP . DIRECTORY_SEPARATOR . 'session',
    'date.timezone'     => 'UTC',
);

/**
 * auto-register some default objects for common use. note that these are
 * lazy-loaded and only get created when called for the first time.
 */
$config['Solar']['registry_set'] = array(
    'user'             => 'Solar_User',
    'model_catalog'    => 'Solar_Sql_Model_Catalog',
    'mail_transport'   => 'Solar_Mail_Transport',
    'controller_front' => 'Solar_Controller_Front',
    'session'          => 'Solar_Session',
    'sql'              => 'Solar_Sql',
    'log'              => 'Solar_Log',
);

/**
 * sql adapter to use
 */
$config['Solar_Sql'] = array(
    'adapter' => 'Solar_Sql_Adapter_Sqlite',
);

$config['Solar_Sql_Model_Catalog'] = array(
    'classes' => array(),
);

/**
 * log adapter to use
 */
$config['Solar_Log'] = array(
    'adapter' => 'Solar_Log_Adapter_Syslog',
);

/**
 * mail transport adapter to use
 */
$config['Solar_Mail_Transport'] = array(
    'adapter' => 'Solar_Mail_Transport_Adapter_Phpmail',
);

/**
 * mail transport to use for messages
 */
$config['Solar_Mail_Message'] = array(
    'transport' => 'mail_transport',
);

/**
 * view adapter to use
 */
$config['Solar_View'] = array(
    'adapter' =>'Solar_View_Adapter_Native',
    'helper_class'  => array('Solar_View_Helper'),
);

/**
 * front controller
 */
$config['Solar_Controller_Front'] = array(
    'classes' => array('App'),
    'disable'  => array('base'),
    'default' => 'hello',
    'routing' => array(),
);

/**
 * load application config
 */
include PATH_VAR . '/config.php';

/**
 * done!
 */
return $config;
