<?php

namespace Ghastly\Test;

use Ghastly\Post\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{
	public function testPostIsAPost()
	{
		$post = new Post();
		$this->assertInstanceOf('\Ghastly\Post\Post', $post);
	}

	public function testGettersAndSetters()
	{
		$post = new Post();
		$post->setTitle('asdf');
		$post->setDate('2014-01-01');
		$post->setSlug('new-post');
		$post->setTags(['tag1','tag2']);
		$post->setContent('fdsa');
		$post->setSummary('jkl');

		$this->assertEquals('asdf', $post->getTitle());
		$this->assertEquals('2014-01-01', $post->getDate());
		$this->assertEquals('new-post', $post->getSlug());
		$this->assertEquals(['tag1', 'tag2'], $post->getTags());
		$this->assertEquals('fdsa', $post->getContent());
		$this->assertEquals('jkl', $post->getSummary());
	}

	public function testCanAddTag()
	{
		$post = new Post();
		$post->setTags(['tag1', 'tag2']);
		$post->addTag('tag3');

		$this->assertEquals(['tag1','tag2','tag3'], $post->getTags());
	}
}