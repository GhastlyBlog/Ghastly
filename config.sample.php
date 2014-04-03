<?php

/**
 * Configuration Options
 * ---------------------
 * Change the options below as is needed
 */

$ghastly_config = array(

	/**
	 * The url of your blog goes here (without a trailing slash)
	 */
	'blog_url' => 'http://localhost',

	/**
	 * The name of your blog
	 */
	'blog_title' => 'Ghastly',

	/**
	 * The name of the person who wants credit for the articles
	 */
	'blog_author' => 'Ghastly',

	/**
	 * Describe your blog in a few words
	 */
	'blog_description' => 'Just another blogging platform',

	/**
	 * How many posts do you want displayed at once
	 */
	'posts_per_page' => 1,

	/**
	 * The theme you want your blog to use
	 */
	'theme' => 'spooky',

    /**
     * The plugins you would like to enable
     */
    'plugins' => array('archive'),








	/** Only edit below if you know what you are doing **/
	/** ---------------------------------------------- **/

	/**
	 * Where can Ghastly find all of your posts?
	 */
	'posts_dir' => 'posts',

	/**
	 * Where can we find your templates?
	 */
	'themes_dir' => 'themes',

    /**
     * Where can we find your plugins?
     */
    'plugins_dir' => 'plugins',

    /**
     * Your images directory
     */
    'images_dir' => 'images',

    /**
     * Post file extension
     */
    'post_file_extension' => 'md',

	/**
	 * Do you want to enable twig template caching?
	 * If you choose to do so, you must chmod 777 your templates directory
	 */
	'cache' => false

);
