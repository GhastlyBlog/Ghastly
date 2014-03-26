<?php

/**
 * Include composers autoloader
 */
require 'vendor/autoload.php';

/**
 * Include the configuration options 
 */
require 'app/Config.php';
require 'config.php';

/**
 * Include Ghastly classes
 */
require 'app/PostController.php';
require 'app/PostModel.php';
require 'app/PostRepositoryInterface.php';
require 'app/DirectoryPostRepository.php';
require 'app/Plugin.php';
require 'app/PluginManager.php';
require 'app/Events.php';
require 'app/Ghastly.php';

/**
 * Constant definitions 
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Instantiate a new Ghastly
 */
$Ghastly = new \Ghastly\Ghastly();

/**
 * Tell Ghastly to run
 */
$Ghastly->run();
