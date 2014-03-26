<?php
namespace Spook;

class PostController {
    public static function index($spook) {
        $options = SpookConfig::getInstance()->options;
        $PostRepository = new DirectoryPostRepository($options['posts_dir'], 'md');
        $PostModel = new PostModel($PostRepository);

        $posts = $PostModel->find_all($options['posts_per_page']);
        
        foreach($posts as $key => $post)
        {
            $posts[$key] = $PostModel->get_post_by_id($post);
        }

        $spook->data['posts'] = $posts;
        $spook->template = 'layout.html';
    }

    public static function single($spook, $request) {
        $options = SpookConfig::getInstance()->options;
        $PostRepository = new DirectoryPostRepository($options['posts_dir'], 'md');
        $PostModel = new PostModel($PostRepository);

        $post = $PostModel->get_post_by_id($request->id);
        
        $spook->data['post'] = $post;
        $spook->template = 'single_post_layout.html';
    }
}
