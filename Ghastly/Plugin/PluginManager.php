<?php
namespace Ghastly\Plugin;

use Ghastly\Config\Config;

class PluginManager {

    private static $instance = null;

    /**
     * The directory where the plugin directories are stored
     */
    public $plugins_dir;

    /**
     * An array of loaded plugins
     */
    public $plugins = array();

    /**
     * An array of enabled plugins
     */
    public $enabled_plugins = array();

    public $config;

    public function __construct(Config $config) 
    {
        $this->config = $config;
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
                $dispatcher->AddListener($event['event'], array($plugin, $event['func']));
            }
        }
    }

}
