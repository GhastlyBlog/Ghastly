<?php

namespace Ghastly\Event;

/**
 * This event is dispatched prior to rendering any templates
 */
class PreRenderEvent extends \Symfony\Component\EventDispatcher\Event {

    /**
     * The renderer exposes methods to modify template variables and
     * directories
     * @var Ghastly\Template\Renderer
     */
    public $renderer;

    /**
     * The postModel allows plugins to query for posts
     * @var PostModel
     */
    public $postModel;

    /**
     * A PreRender event must be given a Renderer and PostModel
     * @param Ghastly\Template\Renderer $renderer 
     * @param PostModel $postModel 
     */
    public function __construct($renderer, $postModel){
        $this->renderer = $renderer;
        $this->postModel = $postModel;
    }
}
