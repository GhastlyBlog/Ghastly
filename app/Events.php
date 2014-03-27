<?php

namespace Ghastly;

class GhastlyRouteEvent extends \Symfony\Component\EventDispatcher\Event {
    public $Ghastly;
    public $router;

    public function __construct($Ghastly, $router){
        $this->Ghastly = $Ghastly;
        $this->router = $router;
    }
}

class GhastlyPreRenderEvent extends \Symfony\Component\EventDispatcher\Event {
    public $Ghastly;

    public function __construct($Ghastly){
        $this->Ghastly = $Ghastly;
    }
}
