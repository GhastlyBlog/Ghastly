<?php

/**
 * Include composers autoloader
 */
require 'vendor/autoload.php';

/** 
 * Include the configuration file
 */
require 'config.php';

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
