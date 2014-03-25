<?php
namespace Spook;
class PostModel {
    protected $db;

    public function __construct(DirectoryPostRepository $db){
        $this->db = $db;
    }

    public function find_all($limit)
    {
        return $this->db->find_all($limit);
    }

    public function get_post_by_id($id)
    {
        return $this->db->read($id);
    }

}