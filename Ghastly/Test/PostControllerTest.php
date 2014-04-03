<?php

namespace Ghastly\Test;

use Ghastly\Config\Config;
use Ghastly\Post\PostModel;
use Ghastly\Template\Renderer;
use Ghastly\Post\PostController;
use Ghastly\Post\PostParser;
use Ghastly\Post\DirectoryPostRepository;

class PostControllerTest extends \PHPUnit_Framework_TestCase
{

	public function testIndex()
	{
		$config = new Config();
		$renderer = new Renderer($config);
		$postModel = new PostModel(new DirectoryPostRepository($config), new PostParser());
		$postController = new PostController($config, $postModel, $renderer);
		$postController->index();
		$this->assertEquals('layout.html', $renderer->getTemplate());
	}

	public function testSinglePost()
	{
		$config = new Config();
		$renderer = new Renderer($config);
		$postModel = new PostModel(new DirectoryPostRepository($config), new PostParser());
		$postController = new PostController($config, $postModel, $renderer);

		$request = new \stdClass();
		$request->id = '2014-03-26-introducing-ghastly';
		$postController->single($request);
		$this->assertEquals('single_post_layout.html', $renderer->getTemplate());
	}

}