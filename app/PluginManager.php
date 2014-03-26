<?php
namespace Ghastly;

class PluginManager {

    private static $instance = null;

    public $plugins_dir;
    public $plugins = array();
    public $enabled_plugins = array();
    public $options = array();

    public static function getInstance()
    {
        if( !isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() 
    {
        $this->options = Config::getInstance()->options;
        $this->plugins_dir = $this->options['plugins_dir'];
        $this->enabled_plugins = $this->options['plugins'];
    }


    public function loadPlugins()
    {
        foreach($this->enabled_plugins as $plugin) {
            require_once($this->options['plugins_dir'].DS.$plugin.DS.$plugin.'.plugin.php');
            $this->plugins[] = new $plugin();
         } 
    }

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
