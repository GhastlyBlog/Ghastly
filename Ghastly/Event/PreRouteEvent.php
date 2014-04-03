<?php

namespace Ghastly\Event;

class PreRouteEvent extends \Symfony\Component\EventDispatcher\Event {
    public $router;
    public $renderer;
    public $dispatcher;
    public $postModel;

    public function __construct($router, $renderer, $dispatcher, $postModel){
        $this->router = $router;
        $this->renderer = $renderer;
        $this->dispatcher = $dispatcher;
        $this->postModel = $postModel;
    }
}