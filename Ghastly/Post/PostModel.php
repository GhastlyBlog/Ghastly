<?php

namespace Ghastly\Post;

use \Michelf\Markdown;

class PostModel {

    protected $db;
    protected $parser;

    public function __construct(PostRepositoryInterface $db, PostParser $parser){
        $this->db = $db;
        $this->parser = $parser;
    }

    public function findAll($limit=0)
    {
        $posts = $this->db->findAll()->limit($limit)->getResults();

        foreach($posts as $key => $post)
        {
            $posts[$key] = $this->parser->parse($post);
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
        return $this->parser->parse($post);
    }

}
