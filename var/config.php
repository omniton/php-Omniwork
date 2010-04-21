<?php

// mysql stuff
$config['Solar_Sql'] = array(
    'adapter' => 'Solar_Sql_Adapter_Mysql',
    'host' => 'localhost', // the database server host
    'name' => '',  // the database name
    'user' => '',  // authenticate as this user
    'pass' => '',  // authenticate with this password
);

// session stuff
$config['Solar_Session'] = array(
    'handler' => array('adapter' => 'Solar_Session_Handler_Adapter_Sql'),
    'name' => 'session',
    'lifetime' => 0,
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => true,
);

$config['Solar_Mail_Message'] = array(
    'transport' => 'mail_transport',
    'fromAddr' => '',
    'fromName' => '',
);

// front controller
$config['Solar_Controller_Front'] = array(
    'classes' => array('App'),
    'disable' => array(),
    'default' => 'hello',
    'rewrite' => array(),
    'routing' => array(),
    'explain' => true,
    'page_spec' => array(),
);
