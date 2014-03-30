<?php

namespace Ghastly\Config;

class Config {

    private static $instance = null;

    public $options = array();

    public static function getInstance($options=false)
    {
        if( !isset(self::$instance)) {
            self::$instance = new self($options);
        }
        return self::$instance;
    }

    public function __construct($options) 
    {
        $defaults = array(
            'blog_title' => 'Ghastly',
            'blog_author' => 'Ghastlyy Ghost',
            'blog_url' => 'http://localhost',
            'blog_description' => 'Another Ghastlyy blog',
            'posts_dir' => 'posts',
            'theme' => 'Ghastlyy',
            'themes_dir' => 'templates',
            'plugins_dir' => 'plugins',
            'plugins' => array(),
            'cache' => false,
            'posts_per_page' => 5
        );

        $this->options = array_merge($defaults, $options);
    }

}
