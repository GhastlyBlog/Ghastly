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

class Ghastly {

    private $config;
    private $dispatcher;
    private $postController;
    private $pluginManager;
    private $renderer;
    private $router;

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
        $this->pluginManager->addListeners($this->dispatcher);

        /** Instantiate new router **/
        $this->router = new Klein();
    }

    /**
     * Ghastly expects that the controllers will set $this->template.
     */
    public function run() 
    {
        /**
         * Dispatch our route event so plugins can setup routes
         */
        $event = new PreRouteEvent($this->router, $this->renderer, $this->dispatcher, $this->postModel);
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
            $this->template = '404.html';
        });

        $this->router->dispatch();        

        /**
         * If a plugin provides or extends
         * any templates, it's expected to push them onto $this->template_dirs
         *
         * Let plugins modify template variables after the routes have executed
         */
        $event = new PreRenderEvent($this->renderer, $this->postModel);
        $this->dispatcher->dispatch('Ghastly.PreRender', $event);

        /**
         * Render the template to the page
         */
        $this->renderer->render($this);
    }

}