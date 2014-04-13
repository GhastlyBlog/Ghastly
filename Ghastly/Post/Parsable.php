<?php

namespace Ghastly\Post;

/**
 * A class that can parse a Post should implement Parsable
 */
interface Parsable {
    /**
     * Parse a Post
     * @param array $data
     * @return Post
     */
    public function parse(PostFile $data);
}
