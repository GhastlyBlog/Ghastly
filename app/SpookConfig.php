<?php
namespace Spook;
class SpookConfig {

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
            'blog_title' => 'Spook',
            'blog_author' => 'Spooky Ghost',
            'blog_url' => 'http://localhost',
            'blog_description' => 'Another spooky blog',
            'posts_dir' => 'posts',
            'theme' => 'spooky',
            'templates_dir' => 'templates',
            'cache' => false,
            'posts_per_page' => 5
        );

        $this->options = array_merge($defaults, $options);
    }

}
