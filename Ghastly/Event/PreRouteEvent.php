<?php

namespace Ghastly\Event;

class PreRouteEvent extends \Symfony\Component\EventDispatcher\Event {
    public $Ghastly;
    public $router;

    public function __construct($Ghastly, $router){
        $this->Ghastly = $Ghastly;
        $this->router = $router;
    }
}