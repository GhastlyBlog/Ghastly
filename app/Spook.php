<?php

namespace Spook;


class Spook {

    public $twig;
    public $template;
    public $data;

    protected $options;
    protected $template_path;

    protected $PostRepository;
    protected $PostModel;

    public function __construct()
    {
        $this->options = SpookConfig::getInstance()->options;
        $this->PostRepository = new DirectoryPostRepository($this->options['posts_dir'], 'md');
        $this->PostModel = new PostModel($this->PostRepository);
        $this->template_path = $this->options['templates_dir'].DIRECTORY_SEPARATOR.$this->options['theme'];

        $twig_environment_config = array('autoescape'=>false);

        if($this->options['cache']) {
            $twig_environment_config['cache'] = $this->options['templates_dir'].'/cache';
        }

        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem($this->template_path);
        $this->twig = new \Twig_Environment($loader, $twig_environment_config);

        $this->data = $this->options;
    }

    public function run() 
    {
        $router = new \Klein\Klein();

        $router->respond('/', function($request){
            PostController::index($this);
        });

        $router->respond('/post/[:id]', function($request){
            PostController::single($this, $request);
        });
        
        $router->dispatch();        
        
        $layout = $this->twig->loadTemplate($this->template);
        echo $layout->render($this->data);
    }

}
