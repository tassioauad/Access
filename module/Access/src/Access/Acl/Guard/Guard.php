<?php

namespace Access\Acl\Guard;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Mvc\MvcEvent;
use Access\Acl\Service\Service as AclService;
use Zend\Mvc\Router\RouteMatch;
use Zend\Uri\Http as Uri;
class Guard implements EventManagerAwareInterface
{
    /**
     * @var string
     */
    protected $defaultPath = '/';
    /**
     * @var string
     */
    protected $deniedPath = '/denied';
    /**
     * @var EventManagerInterface
     */
    protected $events;
    /**
     * @var AclService
     */
    protected $aclService;

    /**
     * @param $aclService AclService
     */
    function __construct($aclService)
    {
        $this->aclService = $aclService;
    }

    /**
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function dispatch(MvcEvent $e)
    {
        try {
            $controller = null;
            $action = 'index';
            $path = $this->defaultPath;

            $uri = explode('/', $e->getRequest()->getRequestUri());
            if (!empty($uri[1])) {
                $controller = $uri[1];
                if ($controller == 'favicon.ico') {
                    return;
                }
            }

            if (!empty($uri[2])) {
                $action = $uri[2];
            }
            if (!empty($controller) && !empty($action)) {
                if ($this->aclService->isAllowed($controller, $action) && $controller != 'denied') {
                    $path = '/'. $controller;
                    if ($action != 'index') {
                        $path .= '/' . $action;
                    }

                } else {
                    $path = $this->deniedPath;
                }
            }
        } catch(\Exception $ex) {
            $path = 'error/404';
        }

        $e->getRequest()->setRequestUri($path);
        $e->getRequest()->getUri()->setPath($path);

    }

    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));

        $this->events = $events;

        return $this;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}
