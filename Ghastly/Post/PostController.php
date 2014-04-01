<?php

namespace Ghastly\Post;

use Ghastly\Config\Config;

class PostController {

    protected $config;

    public function __construct(Config $config){
        $this->config = $config;
    } 
    
    /**
     * The blog homepage, return a limited list of posts
     */
    public function index($Ghastly) {
        $posts = $Ghastly->postModel->findAll($this->config->options['posts_per_page']);

        $Ghastly->template_vars['posts'] = $posts;
        $Ghastly->template = 'layout.html';
    }

    /**
     * Show a single post
     */
    public function single($Ghastly, $request) {
        $post = $Ghastly->postModel->getPostById($request->id);
        
        $Ghastly->template_vars['post'] = $post;
        $Ghastly->template = 'single_post_layout.html';
    }

}
