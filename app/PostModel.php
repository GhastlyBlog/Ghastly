<?php

namespace Ghastly;

class PostModel {

    protected $db;

    public function __construct(DirectoryPostRepository $db){
        $this->db = $db;
    }

    public function findAll($limit=0)
    {
        return $this->db->find_all($limit);
    }

    public function getPostById($id)
    {
        return $this->db->read($id);
    }

}
