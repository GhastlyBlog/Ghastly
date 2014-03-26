<?php

namespace Ghastly;
class GhastlyRouteEvent extends \Symfony\Component\EventDispatcher\Event {
    public $router;

    public function __construct($router){
        $this->router = $router;
    }
}

class GhastlyPreRenderEvent extends \Symfony\Component\EventDispatcher\Event {
    public $template_vars;
    public $template_dirs;
    public $template;

    public function __construct($template_vars, $template_dirs, $template){
        $this->template_vars = $template_vars;
        $this->template_dirs = $template_dirs;
        $this->template = $template;
    }
}
