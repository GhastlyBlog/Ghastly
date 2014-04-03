<?php

namespace Ghastly\Post;

use Ghastly\Config\Config;
use Ghastly\Post\PostModel;
use Ghastly\Template\Renderer;

/**
 * Controller for built-in Ghastly routes for posts
 */
class PostController {

    /**
     * A Ghastly Config
     * @var Config
     */
    private $config;

    /**
     * A model for querying posts
     * @var PostModel
     */
    private $postModel;

    /**
     * The template renderer
     * @var Renderer
     */
    private $renderer;

    /**
     * @param Config $config
     * @param PostModel $postModel
     * @param Renderer $renderer
     */
    public function __construct(Config $config, PostModel $postModel, Renderer $renderer){
        $this->config = $config;
        $this->postModel = $postModel;
        $this->renderer = $renderer;
    } 
    
    /**
     * The blog homepage, return a limited list of posts
     */
    public function index() {
        $posts = $this->postModel->findAll($this->config->options['posts_per_page']);

        $this->renderer->setTemplateVar('posts', $posts);
        $this->renderer->setTemplate('layout.html');
    }

    /**
     * Show a single post
     * @param Request $request
     */
    public function single($request) {
        $post = $this->postModel->getPostById($request->id);
        
        $this->renderer->setTemplateVar('post', $post);
        $this->renderer->setTemplate('single_post_layout.html');
    }

}
