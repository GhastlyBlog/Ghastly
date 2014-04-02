<?php

namespace Ghastly\Test;

use Ghastly\Post\DirectoryPostRepository;
use Ghastly\Config\Config;

class DirectoryPostRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public $cfg;

	public function setUp()
	{
		if(! defined('DS')) { define('DS', DIRECTORY_SEPARATOR); };

		$this->cfg = new Config();
	}

	public function testCanFindAllFiles()
	{
		$dpr = new DirectoryPostRepository($this->cfg);
		$posts = $dpr->findAll()->getResults();
		$this->assertGreaterThan(0, count($posts));
	}

	public function testCanFindSingleFile()
	{
		$file = '2014-03-26-introducing-ghastly';
		$dpr = new DirectoryPostRepository($this->cfg);
		$posts = $dpr->find($file)->getResult();
		$this->assertGreaterThan(0, count($posts));
	}

	public function testCanLimitResults()
	{
		$dpr = new DirectoryPostRepository($this->cfg);
		$post = $dpr->findAll()->limit(1)->getResult();
		$this->assertNotEmpty($post);
	}

	public function testCanGetDateFromFilename()
	{
		$dpr = new DirectoryPostRepository($this->cfg);
		$post = $dpr->findAll()->limit(1)->getResult();
		$this->assertInstanceOf('DateTime', $post['date']);
		$this->assertEquals('2014-03-26', $post['date']->format('Y-m-d'));
	}
}
