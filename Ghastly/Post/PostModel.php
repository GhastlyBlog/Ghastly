<?php

namespace Ghastly\Post;

use \Michelf\Markdown;

class PostModel {

    /**
     * A database of posts
     * @var PostRepositoryInterface
     */
    private $db;

    /**
     * An object that can parse posts
     * @var Parsable
     */
    private $parser;

    /**
     * @param PostRepositoryInterface $db
     * @param Parsable $parser
     */
    public function __construct(PostRepositoryInterface $db, Parsable $parser){
        $this->db = $db;
        $this->parser = $parser;
    }

    /**
     * Will find all posts, can optionally specify a limit
     * @param int $limit Defaults to 0
     * @return array Array of Posts
     */
    public function findAll($limit=0)
    {
        $posts = $this->db->findAll()->limit($limit)->getResults();

        foreach($posts as $key => $post)
        {
            $posts[$key] = $this->parser->parse($post);
        }

        return $posts;
    }

    /**
     * Just like findAll() but will not retrieve the file contents
     * @param int $limit Defaults to 0
     * @return array Array of posts without content
     */
    public function findAllHeaders($limit=0)
    {
        $posts = $this->db->findAll()->limit($limit)->getResults(true);

        return $posts;
    }

    /**
     * Returns a single post with content
     * @param int $id The post filename/id
     * @return Post
     */
    public function getPostById($id)
    {
        $post = $this->db->find($id)->getResult();
        return $this->parser->parse($post);
    }

}
