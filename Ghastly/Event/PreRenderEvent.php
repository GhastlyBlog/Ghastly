<?php

namespace Ghastly\Event;

class PreRenderEvent extends \Symfony\Component\EventDispatcher\Event {
    public $renderer;
    public $postModel;

    public function __construct($renderer, $postModel){
        $this->renderer = $renderer;
        $this->postModel = $postModel;
    }
}
