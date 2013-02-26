<?php

namespace Messenger\Helper;

use Messenger\Controller\Plugin\MessengerPlugin;
use Zend\View\Helper\HelperInterface;
use Zend\View\Renderer\RendererInterface as Renderer;

class MessengerHelper extends MessengerPlugin implements HelperInterface
{

    /**
     * __invoke
     *
     * @access public
     * @return MessengerPlugin
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * View object
     *
     * @var Renderer
     */
    protected $view = null;

    /**
     * Set the View object
     *
     * @param  Renderer $view
     * @return MessengerHelper
     */
    public function setView(Renderer $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Get the view object
     *
     * @return null|Renderer
     */
    public function getView()
    {
        return $this->view;
    }
}