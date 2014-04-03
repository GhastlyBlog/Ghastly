<?php
namespace Ghastly\Plugin;

use Ghastly\Config\Config;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * The plugin manager keeps track of the enabled Ghastly
 * plugins
 */
class PluginManager {

    /**
     * The directory where the plugin directories are stored
     * @var string
     */
    private $plugins_dir;

    /**
     * An array of loaded plugins
     * @var array
     */
    private $plugins = array();

    /**
     * An array of enabled plugins
     * @var array
     */
    private $enabled_plugins = array();

    /**
     * The Config object
     * @var Config
     */
    private $config;

    /**
     * The event dispatcher
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * A PluginManger requires a Config and an EventDispatcher
     * @param Config $config
     * @param EventDispatcher $dispatcher
     */
    public function __construct(Config $config, EventDispatcher $dispatcher) 
    {
        $this->config = $config;
        $this->dispatcher = $dispatcher;
        $this->plugins_dir = $this->config->options['plugins_dir'];
        $this->enabled_plugins = $this->config->options['plugins'];
    }

    /**
     * Load the plugins specified in Config
     * @return void
     */
    public function loadPlugins()
    {
        // Loop over all of the plugins to enable and attempt to include them
        foreach($this->enabled_plugins as $plugin) {
            // Require the file
            require_once($this->config->options['plugins_dir'].DS.$plugin.DS.$plugin.'.plugin.php');

            // Instantiate the plugin and add it to the array
            $this->plugins[] = new $plugin();
         } 
    }

    /**
     * Add plugin listeners to the dispatcher
     * @return void
     */
    public function addListeners()
    {
        foreach($this->plugins as $plugin) {
            // Plugins should have an events array
            $events = $plugin->events;

            foreach($events as $event) {
                // Add the plugin event listeners
                $this->dispatcher->AddListener($event['event'], array($plugin, $event['func']));
            }
        }
    }

}
