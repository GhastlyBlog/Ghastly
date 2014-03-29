<?php

namespace Ghastly;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Klein\Klein;

use Ghastly\Event\PreRenderEvent;
use Ghastly\Event\PreRouteEvent;
use Ghastly\Config\Config;
use Ghastly\Plugin\PluginManager;
use Ghastly\Post\PostController;
use Ghastly\Post\PostModel;
use Ghastly\Post\DirectoryPostRepository;

class Ghastly {

    public $template;
    public $template_vars;
    public $template_dirs;
    public $postModel;

    protected $options;
    protected $template_path;
    protected $dispatcher;
    protected $postController;

    public function __construct()
    {
        /** Initialize Configuration Options **/
        $this->options = Config::getInstance()->options;

        /** Instantiate Post Controller **/
        $this->postController = new PostController();
        
        /** Instantiate Post Model **/
        $this->postModel = new PostModel(new DirectoryPostRepository());

        /** Let template vars include all of the config options **/
        $this->template_vars = $this->options;
        $this->template_dirs = array($this->options['themes_dir'].DS.$this->options['theme']);

        /** Create the event dispatcher **/
        $this->dispatcher = new EventDispatcher();

        /** Bootstrap plugins **/
        $this->pluginManager = new PluginManager();
        $this->pluginManager->loadPlugins();
        $this->pluginManager->addListeners($this->dispatcher);
    }

    /**
     * Ghastly expects that the controllers will set $this->template.
     */
    public function run() 
    {
        $router = new Klein();

        /**
         * Dispatch our route event so plugins can setup routes
         */
        $event = new PreRouteEvent($this, $router);
        $this->dispatcher->dispatch('Ghastly.PreRoute', $event);

        /**
         * Ghastly's built-in routes
         */
        $router->respond('/', function($request){
            $this->postController->index($this);
        });

        $router->respond('/post/[:id]', function($request){
            $this->postController->single($this, $request);
        });
        
        $router->respond('404', function($request){
            $this->template = '404.html';
        });

        $router->dispatch();        

        /**
         * Render the template to the page
         */
        $this->_render(); 
    }
    
    private function _render()
    {
        /**
         * If a plugin provides or extends
         * any templates, it's expected to push them onto $this->template_dirs
         *
         * Dispatch PreRenderEvent so that plugins have a chance to modify
         * or inject template vars and templates because it didn't make 
         * sense for them to respond to a route.
         */
        $event = new PreRenderEvent($this);
        $this->dispatcher->dispatch('Ghastly.PreRender', $event);

        /**
         * Configure the twig environment
         */
        $config = array('autoescape'=>false);
        if($this->options['cache']) {
            $config['cache'] = $this->options['themes_dir'].'/cache';
        }
        
        $loader = new \Twig_Loader_Filesystem($this->template_dirs);
        $twig = new \Twig_Environment($loader, $config);

        /**
         * Set the template and render compiled template to screen
         */
        $layout = $twig->loadTemplate($this->template);
        echo $layout->render($this->template_vars);
    }
}