<?php

/**
 * Include composers autoloader
 */
require 'vendor/autoload.php';

/**
 * Include the configuration options 
 */
require 'app/SpookConfig.php';
require 'config.php';

/**
 * Include spook classes
 */
require 'app/PostController.php';
require 'app/PostModel.php';
require 'app/PostRepositoryInterface.php';
require 'app/DirectoryPostRepository.php';
require 'app/Spook.php';

/**
 * Instantiate a new Spook with the config options given
 */
$spook = new \Spook\Spook();

/**
 * Tell Spook to run
 */
$spook->run();
