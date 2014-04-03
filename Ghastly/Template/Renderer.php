<?php

namespace Ghastly\Template;

use Ghastly\Ghastly;
use Ghastly\Config\Config;

class Renderer {

	private $config;
	private $template;
	private $template_vars = [];
	private $template_dirs = [];

	public function __construct(Config $config)
	{
		$this->config = $config;

		/** Let template vars include all of the config options **/
        $this->template_vars = $this->config->options;
        $this->template_dirs = array($this->config->options['themes_dir'].DS.$this->config->options['theme']);
	}

	public function render(Ghastly $Ghastly)
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

    public function setTemplateVar($name, $value)
    {
    	$this->template_vars[$name] = $value;
    }

    public function getTemplateVars()
    {
    	return $this->template_vars;
    }

    public function addTemplateDir($dir)
    {
    	$this->template_dirs[] = $dir;
    }

    public function setTemplate($template)
    {
    	$this->template = $template;
    }

    public function getTemplate()
    {
    	return $this->template;
    }

}