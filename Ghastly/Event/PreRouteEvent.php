<?php

namespace Ghastly\Event;

/**
 * This event is dispatched prior to routing and allows plugins to 
 * respond to new routes
 */
class PreRouteEvent extends \Symfony\Component\EventDispatcher\Event {

    /**
     * The router exposes the methods necessary to attach new routes
     * @var Klein;
     */
    public $router;

    /**
     * The renderer exposes the methods necessary to modify template
     * variables and directories
     * @var Ghastly\Template\Renderer;
     */
    public $renderer;
    
    /**
     * The postModel allows plugins to query for posts
     * @var PostModel
     */
    public $postModel;

    /**
     * A PreRoute event requires a Router, Renderer, and PostModel
     * @param Router $router
     * @param Renderer $renderer
     * @param PostModel $postModel
     */
    public function __construct($router, $renderer, $postModel){
        $this->router = $router;
        $this->renderer = $renderer;
        $this->postModel = $postModel;
    }
}
