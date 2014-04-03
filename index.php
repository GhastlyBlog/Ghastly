<?php

/**
 * Include composers autoloader
 */
require 'vendor/autoload.php';

/** 
 * Include the configuration file
 */

if( !file_exists('config.php')) {
	die('You forgot to rename config.sample.php to config.php');
}

require('config.php');


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
