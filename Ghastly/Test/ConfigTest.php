<?php

namespace Ghastly\Test;

use Ghastly\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

	public function testDefaultConfigOptionsPresent()
	{
		$config = new Config();
		$options = array_keys($config->options);

		$this->assertContains('blog_title', $options);
		$this->assertContains('blog_author', $options);
		$this->assertContains('blog_url', $options);
		$this->assertContains('blog_description', $options);
		$this->assertContains('posts_dir', $options);
		$this->assertContains('theme', $options);
		$this->assertContains('themes_dir', $options);
		$this->assertContains('plugins_dir', $options);
		$this->assertContains('plugins', $options);
		$this->assertContains('cache', $options);
		$this->assertContains('posts_per_page', $options);
		$this->assertContains('post_file_extension', $options);
	}

	public function testCanOverrideThemeOption()
	{
		$config = new Config(array('blog_title'=>'asdf'));
		$this->assertEquals('asdf', $config->options['blog_title']);
	}

}