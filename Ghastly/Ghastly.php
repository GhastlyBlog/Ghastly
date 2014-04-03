<?php

namespace Ghastly;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Klein\Klein;
use Ghastly\Event\PreRouteEvent;
use Ghastly\Event\PreRenderEvent;
use Ghastly\Config\Config;
use Ghastly\Plugin\PluginManager;
use Ghastly\Post\PostController;
use Ghastly\Post\PostModel;
use Ghastly\Post\DirectoryPostRepository;
use Ghastly\Post\PostParser;
use Ghastly\Template\Renderer;

/**
 * The Ghastly class serves as the applications main point of entry
 */
class Ghastly {
    
    /**
     * The Config object created from config.php
     * @var Config
     */
    private $config;

    /**
     * The event dispatcher
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * Built in controller to serve the default routes
     * @var PostController
     */
    private $postController;

    /**
     * Manages the applications plugins
     * @var PluginManager
     */
    private $pluginManager;

    /**
     * Handles template vars, directories, and rendering
     * @var Renderer
     */
    private $renderer;

    /**
     * Can query for posts
     * @var PostModel
     */
    private $postModel;

    /**
     * Performs routing for the application and its plugins
     * @var Klein
     */
    private $router;

    /**
     * Instantiates all objects necessary for runtime
     * @param array $config An array from the configuration script 
     */
    public function __construct($config)
    {
        /** Initialize Configuration Options **/
        $this->config = new Config($config);

        /** Create the template renderer **/
        $this->renderer = new Renderer($this->config);

        /** Instantiate Post Model **/
        $this->postModel = new PostModel(new DirectoryPostRepository($this->config), new PostParser());

        /** Instantiate Post Controller **/
        $this->postController = new PostController($this->config, $this->postModel, $this->renderer);
       
        /** Create the event dispatcher **/
        $this->dispatcher = new EventDispatcher();

        /** Bootstrap plugins **/
        $this->pluginManager = new PluginManager($this->config, $this->dispatcher);
        $this->pluginManager->loadPlugins();
        $this->pluginManager->addListeners();

        /** Instantiate new router **/
        $this->router = new Klein();
    }

    /**
     * Run the Ghastly app and echo the rendered template
     * @return void
     */
    public function run() 
    {
        /**
         * Dispatch our route event so plugins can setup routes
         */
        $event = new PreRouteEvent($this->router, $this->renderer, $this->postModel);
        $this->dispatcher->dispatch('Ghastly.PreRoute', $event);

        /**
         * Ghastly's built-in routes
         */
        $this->router->respond('/', function(){
            $this->postController->index();
        });

        $this->router->respond('/post/[:id]', function($request){
            $this->postController->single($request);
        });
        
        $this->router->respond('404', function(){
            $this->renderer->setTemplate('404.html');
        });

        $this->router->dispatch();        

        /**
         * Let plugins modify template variables after the routes have executed
         */
        $event = new PreRenderEvent($this->renderer, $this->postModel);
        $this->dispatcher->dispatch('Ghastly.PreRender', $event);

        /**
         * Render the template to the page
         */
        $this->renderer->render();
    }

}
