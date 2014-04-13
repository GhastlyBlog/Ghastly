<?php

error_reporting(E_ALL);
ini_set('display_errors','1');

/**
 * Include composers autoloader
 */
require 'vendor/autoload.php';

/** 
 * Include the configuration file
 */

if( !file_exists('config.php')) {
	exit('You forgot to rename config.sample.php to config.php');
}

require('config.php');

/**
 * A timezone must be configured
 */
if(isset($ghastly_config['timezone'])) {
    date_default_timezone_set($ghastly_config['timezone']);
} else {
    exit("You must set a timezone in config.php");
}

/**
 * Constant definitions 
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Instantiate a new Ghastly
 */
$Ghastly = new \Ghastly\Ghastly($ghastly_config);

/**
 * Tell Ghastly to run
 */
$Ghastly->run();
