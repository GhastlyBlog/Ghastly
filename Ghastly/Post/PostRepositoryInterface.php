<?php

namespace Ghastly\Post;

/**
 * An object capable of retrieving posts should implement
 * the PostRepositoryInterface
 *
 * Methods should be chainable
 */
interface PostRepositoryInterface {

    /**
     * Should find all posts
     * @return PostRepositoryInterface 
     */
    public function findAll();

    /**
     * Get a single post
     * @return PostRepositoryInterface 
     */
    public function find($id);

    /**
     * Should limit the result set
     * @param int $limit How many results to return
     * @return PostRepositoryInterface
     */
    public function limit($limit);

    /**
     * Should return array of posts parsed or not
     * @param bool $headers_only if true, exclude post content
     * @return array
     */
    public function getResults($headers_only = false);

    /**
     * Return a single post with content
     * @return Post
     */
    public function getResult();
}
