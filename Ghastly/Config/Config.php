<?php

namespace Ghastly\Config;

/**
 * Reads a configuration file
 */
class Config {

    /**
     * The configuration options and their values
     * @var array
     */
    public $options;

    /**
     * Specify an optional array of options to override the defaults
     * @param array $options The overriding options array
     */
    public function __construct($options=[]) 
    {
        $defaults = array(
            'blog_title' => 'Ghastly',
            'blog_author' => 'Ghastlyy Ghost',
            'blog_url' => 'http://localhost',
            'blog_description' => 'Another Ghastlyy blog',
            'timezone' => 'Etc/UTC',
            'posts_dir' => 'posts',
            'theme' => 'Ghastlyy',
            'subdirectory' => false,
            'themes_dir' => 'templates',
            'plugins_dir' => 'plugins',
            'plugins' => array(),
            'cache' => false,
            'posts_per_page' => 5,
            'post_file_extension'=>'md'
        );

        // Override the defined defaults with the provided options
        $this->options = array_merge($defaults, $options);
    }

}
