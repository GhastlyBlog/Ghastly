<?php

namespace Spook;


class Spook {

    protected $options;
    protected $template_path;
    protected $twig;

    protected $PostRepository;
    protected $PostModel;

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
        $this->PostRepository = new DirectoryPostRepository($this->options['posts_dir'], 'md');
        $this->PostModel = new PostModel($this->PostRepository);
        $this->template_path = $this->options['templates_dir'].DIRECTORY_SEPARATOR.$this->options['theme'];

        $twig_environment_config = array('autoescape'=>false);

        if($this->options['cache']) {
            $twig_environment_config['cache'] = $this->options['templates_dir'].'/cache';
        }

        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem($this->template_path);
        $this->twig = new \Twig_Environment($loader, $twig_environment_config);

        $this->data = array(
            'blog_title'=>$this->options['blog_title'], 
            'blog_author'=>$this->options['blog_author'], 
            'blog_url'=>$this->options['blog_url'],
            'blog_description'=>$this->options['blog_description']
        );
    }

    public function run() 
    {
        $post_id = isset($_GET['post']) ? $_GET['post'] : false;       

        if($post_id){
            $post = $this->PostModel->get_post_by_id($post_id);
            $this->data['post'] = $post;
        } else {
            $posts = $this->PostModel->find_all($this->options['posts_per_page']);

            foreach($posts as $key => $post)
            {
                $posts[$key] = $this->PostModel->get_post_by_id($post);
            }

            $this->data['posts'] = $posts;
        }

        $layout = $this->_getTemplate();
        echo $layout->render($this->data);
    }

    private function _getTemplate()
    {
        if(isset($this->data['posts'])) {
            return $this->twig->loadTemplate('layout.html');
        }

        if(isset($this->data['post']) && $this->data['post']) {
            return $this->twig->loadTemplate('single_post_layout.html');
        }

        return $this->twig->loadTemplate('404.html');
    }
}