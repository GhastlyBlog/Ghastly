<?php
namespace Spook;

interface PostRepositoryInterface {
    public function find($id);
    public function find_all();
    public function read($id);
}