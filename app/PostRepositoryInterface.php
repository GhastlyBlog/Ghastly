<?php
namespace Ghastly;

interface PostRepositoryInterface {

    public function findAll();
    public function find($id);
    public function limit($limit);
    public function getResults($headers_only = false);
    public function getResult();
}