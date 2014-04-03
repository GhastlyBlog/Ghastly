<?php
namespace Ghastly\Plugin;

use Ghastly\Config\Config;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PluginManager {

    private static $instance = null;

    /**
     * The directory where the plugin directories are stored
     */
    private $plugins_dir;

    /**
     * An array of loaded plugins
     */
    private $plugins = array();

    /**
     * An array of enabled plugins
     */
    private $enabled_plugins = array();

    private $config;
    private $dispatcher;

    public function __construct(Config $config, EventDispatcher $dispatcher) 
    {
        $this->config = $config;
        $this->dispatcher = $dispatcher;
        $this->plugins_dir = $this->config->options['plugins_dir'];
        $this->enabled_plugins = $this->config->options['plugins'];
    }


    public function loadPlugins()
    {
        // Loop over all of the plugins to enable and attempt to include them
        foreach($this->enabled_plugins as $plugin) {
            require_once($this->config->options['plugins_dir'].DS.$plugin.DS.$plugin.'.plugin.php');
            $this->plugins[] = new $plugin();
         } 
    }

    /**
     * Add plugin listeners to the dispatcher
     */
    public function addListeners($dispatcher)
    {
        foreach($this->plugins as $plugin) {
            $events = $plugin->events;

            foreach($events as $event) {
                $this->dispatcher->AddListener($event['event'], array($plugin, $event['func']));
            }
        }
    }

}
