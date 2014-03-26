<?php

namespace Ghastly;

class PostController {

    public function __construct(){
        $this->options = Config::getInstance()->options;
    } 
    
    /**
     * The blog homepage, return a limited list of posts
     */
    public function index($Ghastly) {
        $posts = $Ghastly->postModel->findAll($this->options['posts_per_page']);
        
        foreach($posts as $key => $post)
        {
            $posts[$key] = $Ghastly->postModel->getPostById($post);
        }

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
