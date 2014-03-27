<?php

namespace Ghastly;

use \Michelf\Markdown;

class PostModel {

    protected $db;

    public function __construct(PostRepositoryInterface $db){
        $this->db = $db;
    }

    public function findAll($limit=0)
    {
        $posts = $this->db->findAll()->limit($limit)->getResults();

        foreach($posts as $key => $post)
        {
            $posts[$key] = $this->_buildPostFromMarkdownFile($post);
        }

        return $posts;
    }

    public function findAllHeaders($limit=0)
    {
        $posts = $this->db->findAll()->limit($limit)->getResults(true);

        return $posts;
    }

    public function getPostById($id)
    {
        $post = $this->db->find($id)->getResult();
        return $this->_buildPostFromMarkdownFile($post);
    }

    private function _buildPostFromMarkdownFile($post)
    {

        $post_content = $post['content'];
      
        $config_options = $post_config_lines = array();

        $post_config = $post_content = explode('-----', $post_content);
        $post_config = explode(PHP_EOL, $post_config[1]);
        $post_config = array_filter($post_config, function($n){ return trim($n); });
        $post_config = array_map(function($n){ return explode(':', $n); }, $post_config);

        foreach($post_config as $option){
            $config_options[trim($option[0])] = trim($option[1]);
        }

        $config_options['slug'] = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($post['filename'])));

        $config_options['date'] = $post['date']->format('Y-m-d');

        $post_content = $post_content[2];
        $post_content = Markdown::defaultTransform($post_content);

        $post_summary = false;
        if(str_word_count($post_content) > 50){
            $post_summary = implode(' ', array_slice(explode(' ', $post_content), 0, 50));
        }  

        return array('metadata'=>$config_options, 'content'=>$post_content, 'summary'=>$post_summary);
    }

}