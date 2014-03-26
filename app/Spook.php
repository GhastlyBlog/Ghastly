<?php

namespace Spook;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Spook {

    public $twig;
    public $template;
    public $template_vars;
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

        /** Create the event dispatcher **/
        $this->dispatcher = new EventDispatcher();

        /** Bootstrap plugins **/
        $this->pluginManager = new PluginManager();
        $this->pluginManager->loadPlugins();
        $this->pluginManager->addListeners($this->dispatcher);
    }

    /**
     * Spook expects that the controllers will set $this->template.
     */
    public function run() 
    {
        $router = new \Klein\Klein();

        /**
         * Dispatch our route event so plugins can setup routes
         */
        $event = new SpookRouteEvent($router);
        $this->dispatcher->dispatch('spook.route', $event);

        /**
         * Spook's built-in routes
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
         * Set the default template directory. If a plugin provides or extends
         * any templates, it's expected to push() them onto $template_dirs
         */
        $template_dirs = array($this->options['templates_dir'].DS.$this->options['theme']);

        /**
         * Dispatch PreRenderEvent so that plugins have a chance to modify
         * or inject template vars and templates because it didn't make 
         * sense for them to respond to a route.
         */
        $event = new SpookPreRenderEvent($this->template_vars, $template_dirs, $this->template);
        $pre_render = $this->dispatcher->dispatch('spook.pre_render', $event);

        /**
         * Read data back from the plugins (if any)
         */
        $this->template_vars = $pre_render->template_vars;
        $template_dirs = $pre_render->template_dirs;
        $this->template = $pre_render->template;

        /**
         * Configure the twig environment
         */
        $config = array('autoescape'=>false);
        if($this->options['cache']) {
            $config['cache'] = $this->options['templates_dir'].'/cache';
        }

        
        $loader = new \Twig_Loader_Filesystem($template_dirs);
        $this->twig = new \Twig_Environment($loader, $config);

        /**
         * Set the template and render compiled template to screen
         */
        $layout = $this->twig->loadTemplate($this->template);
        echo $layout->render($this->template_vars);
    }
}
