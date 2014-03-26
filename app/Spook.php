<?php

namespace Spook;


class Spook {

    private $options;

    public function __construct($options = array())
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

    public function run() 
    {
        $post_id = isset($_GET['post']) ? $_GET['post'] : false;       

        $PostRepository = new DirectoryPostRepository($this->options['posts_dir'], 'md');
        $PostModel = new PostModel($PostRepository);

        if($post_id){
            $post = $PostModel->get_post_by_id($post_id);
            
        } else {
            $found_posts = $PostModel->find_all($this->options['posts_per_page']);
        
            $posts = array();

            foreach($found_posts as $post)
            {
                $posts[] = $PostModel->get_post_by_id($post);
            }
        }
        
       
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem($this->options['templates_dir'].DIRECTORY_SEPARATOR.$this->options['theme']);
        
        $twig_environment_config = array('autoescape'=>false);

        if($this->options['cache']) {
            $twig_environment_config['cache'] = $this->options['templates_dir'].'/cache';
        }
        
        $twig = new \Twig_Environment($loader, $twig_environment_config);

        $data = array(
            'blog_title'=>$this->options['blog_title'], 
            'blog_author'=>$this->options['blog_author'], 
            'blog_url'=>$this->options['blog_url'],
            'blog_description'=>$this->options['blog_description']
        );

        if($post_id){
            $data['post'] = $post;
            $layout = $twig->loadTemplate('single_post_layout.html');
        } else {
            $data['posts'] = $posts;
            $layout = $twig->loadTemplate('layout.html');
        }

        echo $layout->render($data);

    }

}

