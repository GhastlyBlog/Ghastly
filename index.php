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
 * Include spook classes
 */
require 'app/PostController.php';
require 'app/PostModel.php';
require 'app/PostRepositoryInterface.php';
require 'app/DirectoryPostRepository.php';
require 'app/Plugin.php';
require 'app/PluginManager.php';
require 'app/Events.php';
require 'app/Spook.php';

/**
 * Constant definitions 
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Instantiate a new Spook with the config options given
 */
$spook = new \Spook\Spook();

/**
 * Tell Spook to run
 */
$spook->run();
