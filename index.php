<?php

/**
 * Include composers autoloader
 */
require 'vendor/autoload.php';

/**
 * Include the configuration options 
 */
require 'config.php';

/**
 * Include spook classes
 */
require 'app/PostModel.php';
require 'app/PostRepositoryInterface.php';
require 'app/DirectoryPostRepository.php';
require 'app/Spook.php';

/**
 * Instantiate a new Spook with the config options given
 */
$spook = new \Spook\Spook($config);

/**
 * Tell Spook to run
 */
$spook->run();