<?php

namespace Ghastly\Test;

use Ghastly\Config\Config;
use Ghastly\Post\PostModel;
use Ghastly\Post\DirectoryPostRepository;
use Ghastly\Post\PostParser;

class PostModelTest extends \PHPUnit_Framework_TestCase
{

	public function testCanFindAll()
	{
		$postModel = new PostModel(new DirectoryPostRepository(new Config()), new PostParser());
		$result = $postModel->findAll();
		$this->assertGreaterThan(0, count($result));
		$this->assertInstanceOf('\Ghastly\Post\Post', $result[0]);
	}

	public function testCanFindAllHeaders()
	{
		$postModel = new PostModel(new DirectoryPostRepository(new Config()), new PostParser());
		$result = $postModel->findAllHeaders();
		$this->assertGreaterThan(0, count($result));
	}

	public function testCanGetPostById()
	{
		$postModel = new PostModel(new DirectoryPostRepository(new Config()), new PostParser());
		$result = $postModel->getPostById('2014-03-26-introducing-ghastly');
		$this->assertGreaterThan(0, count($result));
		$this->assertInstanceOf('\Ghastly\Post\Post', $result);
	}


}