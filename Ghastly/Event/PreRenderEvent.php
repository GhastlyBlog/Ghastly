<?php

namespace Ghastly\Event;

class PreRenderEvent extends \Symfony\Component\EventDispatcher\Event {
    public $Ghastly;

    public function __construct($Ghastly){
        $this->Ghastly = $Ghastly;
    }
}
