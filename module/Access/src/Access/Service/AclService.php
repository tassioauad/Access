<?php
namespace Access\Service;

use \Zend\Session\Container as Session;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclService
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceManager;

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

    public function setAcl(\Access\Acl\Acl $acl)
    {
        $this->getSession()->acl = $acl; //TODO: ISSO AQUI NÃO É SEMPRE CHAMADO E SO É SETADO O DEFAULT ACL E ROLE SE CAIR AQUI!
        \Zend\View\Helper\Navigation::setDefaultAcl($acl);
        $this->setUserRole(new GenericRole($acl->getUserId()));
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

    public function setUserRole(GenericRole $userRole)
    {
        $this->getAcl()->setUserId($userRole->getRoleId());
        \Zend\View\Helper\Navigation::setDefaultRole($userRole);
    }
}
