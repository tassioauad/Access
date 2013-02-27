<?php
namespace Access\Acl\Service;

use \Zend\Session\Container as Session;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Service
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sm
     */
    function __construct(ServiceLocatorInterface $sm)
    {
        $this->serviceManager = $sm;

        $session = new Session('Acl');
        $session->setExpirationSeconds(1800);

        $this->session = $session;

        if (empty($session->acl)) {
            $acl = new \Access\Acl\Acl($sm);
            $this->setAcl($acl);
        }
    }

    /**
     * @param \Access\Acl\Acl $acl
     */
    public function setAcl(\Access\Acl\Acl $acl)
    {
        $this->getSession()->acl = $acl;
    }

    /**
     * @return \Access\Acl\Acl
     */
    public function getAcl()
    {
        return $this->getSession()->acl;
    }

    /**
     * @return \Zend\Session\Container
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return GenericRole
     */
    public function getUserRole()
    {
        $role = $this->getAcl()->getUserId();
        if (empty($role)) {
            $userRole = new GenericRole("GUESS");
            \Zend\View\Helper\Navigation::setDefaultRole($userRole);
            return $userRole;
        }
        return new GenericRole($this->getAcl()->getUserId());
    }

    /**
     * @param $resource string
     * @param $privillege string
     * @return bool
     */
    public function isAllowed($resource, $privillege)
    {
        $resource = strtoupper($resource);
        if ($resource == 'DENIED' || $resource == 'INDEX') {
            return true;
        }

        $privillege = strtoupper($privillege);

        $resource = new Resource($resource);
        $isAllowed = $this->getAcl()->isAllowed($this->getAcl()->getUserId(), $resource, $privillege);

        if($isAllowed) {
            return true;
        }

        return false;
    }
}
