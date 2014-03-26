<?php

/**
 * Configuration Options
 * ---------------------
 * Change the options below as is needed
 */

$config = array(

	/**
	 * The url of your blog goes here (without a trailing slash)
	 */
	'blog_url' => 'http://localhost/spook',

	/**
	 * The name of your blog
	 */
	'blog_title' => 'Spook',

	/**
	 * The name of the person who wants credit for the articles
	 */
	'blog_author' => 'Mr. Ghost',

	/**
	 * Describe your blog in a few words
	 */
	'blog_description' => '',

	/**
	 * How many posts do you want displayed at once
	 */
	'posts_per_page' => 5,

	/**
	 * The theme you want your blog to use
	 */
	'theme' => 'spooky',




	/** Only edit below if you know what you are doing **/
	/** ---------------------------------------------- **/

	/**
	 * Where can Spook find all of your posts?
	 */
	'posts_dir' => 'posts',

	/**
	 * Where can we find your templates?
	 */
	'templates_dir' => 'templates',

	/**
	 * Do you want to enable twig template caching?
	 * If you choose to do so, you must chmod 777 your templates directory
	 */
	'cache' => false


);