<?php

namespace Ghastly\Test;

use Ghastly\Post\PostParser;

class PostParserTest extends \PHPUnit_Framework_TestCase
{
    public $inputFile;

	public function setUp()
	{
$testPost = <<<EOT
---
title: My Post Title
summary: A summary
tags: tag1, tag2
---

It was a dark and stormy night...
EOT;

		$this->inputFile = [
			'filename' => '2014-03-26-stormy-night',
			'date' => new \DateTime('2014-03-26'),
			'content' => $testPost
		];
	}

	public function testParse()
	{
		$parser = new PostParser();
		$post = $parser->parse($this->inputFile);
		$this->assertInstanceOf('\Ghastly\Post\Post', $post);
		$this->assertEquals('My Post Title', $post->getTitle());
		$this->assertEquals('2014-03-26-stormy-night', $post->getSlug());
		$this->assertEquals('2014-03-26', $post->getDate());
		$this->assertEquals('A summary', $post->getSummary());
		$this->assertEquals(['tag1','tag2'], $post->getTags());
		$this->assertEquals("<p>It was a dark and stormy night...</p>\n", $post->getContent());
	}
}
