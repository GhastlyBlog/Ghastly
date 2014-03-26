<?php

namespace Spook;

class PostController {

    public function __construct(){
        $this->options = Config::getInstance()->options;
    } 
    
    /**
     * The blog homepage, return a limited list of posts
     */
    public function index($spook) {
        $posts = $spook->postModel->findAll($this->options['posts_per_page']);
        
        foreach($posts as $key => $post)
        {
            $posts[$key] = $spook->postModel->getPostById($post);
        }

        $spook->template_vars['posts'] = $posts;
        $spook->template = 'layout.html';
    }

    /**
     * Show a single post
     */
    public function single($spook, $request) {
        $post = $spook->postModel->getPostById($request->id);
        
        $spook->template_vars['post'] = $post;
        $spook->template = 'single_post_layout.html';
    }

}
