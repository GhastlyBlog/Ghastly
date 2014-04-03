<?php

namespace Ghastly\Template;

use Ghastly\Ghastly;
use Ghastly\Config\Config;

class Renderer {

    /**
     * A ghastly config object
     * @var Config
     */
	private $config;

    /** 
     * The template to render
     * @var string
     */
	private $template;

    /**
     * The template variables to pass to the rendering engine
     * @var array
     */
	private $template_vars = [];

    /**
     * The directories to search in for templates
     * @var array
     */
	private $template_dirs = [];

    /**
     * @param Config $config
     */
	public function __construct(Config $config)
	{
		$this->config = $config;

		/** Let template vars include all of the config options **/
        $this->template_vars = $this->config->options;
        $this->template_dirs = array($this->config->options['themes_dir'].DS.$this->config->options['theme']);
	}

    /**
     * Render the templates
     */
	public function render()
    {
        /**
         * Configure the twig environment
         */
        $template_config = array('autoescape'=>false);
        if($this->config->options['cache']) {
            $template_config['cache'] = $this->config->options['themes_dir'].'/cache';
        }
        
        $loader = new \Twig_Loader_Filesystem($this->template_dirs);
        $twig = new \Twig_Environment($loader, $template_config);

        /**
         * Set the template and render compiled template to screen
         */
        $layout = $twig->loadTemplate($this->template);
        echo $layout->render($this->template_vars);
    }

    /**
     * Exposes a variable to the template
     * @param string $name Name of the variable
     * @param mixed $value Value of the variable
     */
    public function setTemplateVar($name, $value)
    {
    	$this->template_vars[$name] = $value;
    }

    /**
     * Returns all the template variables
     * @return array
     */
    public function getTemplateVars()
    {
    	return $this->template_vars;
    }

    /**
     * Add a directory to search for templates in
     * @param string $dir The directory to search
     */
    public function addTemplateDir($dir)
    {
    	$this->template_dirs[] = $dir;
    }

    /**
     * Set the template the engine will render
     * @param string $template
     */
    public function setTemplate($template)
    {
    	$this->template = $template;
    }

    /**
     * Return the template the engine wants to render
     * @return string
     */
    public function getTemplate()
    {
    	return $this->template;
    }

}
