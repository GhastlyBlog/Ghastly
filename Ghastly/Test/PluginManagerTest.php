<?php

namespace Ghastly\Test;

use Ghastly\Plugin\PluginManager;
use Ghastly\Config\Config;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PluginManagerTest extends \PHPUnit_Framework_TestCase
{

	public function testCreation()
	{
		$pluginManager = new PluginManager(new Config(), new EventDispatcher());
		$this->assertInstanceOf('\Ghastly\Plugin\PluginManager', $pluginManager);
	}

	public function testPluginLoading()
	{
		$pluginManager = new PluginManager(new Config(['plugins'=>['archive']]), new EventDispatcher());
		$pluginManager->loadPlugins();
		$this->assertGreaterThan(0, count($pluginManager->getLoadedPlugins()));
	}

	public function testAddingListeners()
	{
		$dispatcher = new EventDispatcher();
		$pluginManager = new PluginManager(new Config(['plugins'=>['archive']]), $dispatcher);
		$pluginManager->loadPlugins();
		$pluginManager->addListeners();
		$this->assertTrue($dispatcher->hasListeners('Ghastly.PreRoute'));
	}

}