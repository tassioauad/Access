<?php

namespace Access\Acl\Guard;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Mvc\MvcEvent;
use Access\Acl\Service\Service as AclService;

class Guard implements EventManagerAwareInterface
{

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
    public function canDispatch(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller', 'denied');
        $action = $routeMatch->getParam('action', null);

        if (!$this->aclService->isAllowed($controller, $action) && $controller != 'denied') {
            return false;
        }

        return true;
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
