<?php

namespace Access\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container as Session;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Access\Model;
use \Zend\ServiceManager\ServiceLocatorAwareInterface;

class AccessPlugin extends AbstractPlugin
{
    /**
     * @var \Zend\Session\Container
     */
    private $session;


    function __construct()
    {

    }

    public function login($username, $password)
    {
        $authenticate = $this->getServiceLocator()->get('Access\Auth\Auth');

        $userEntity = $authenticate->isValid($username, $password);

        if ($userEntity) {
            $this->setAcl(new \Access\Acl\Acl($this->getServiceLocator(), $userEntity));
            return true;
        }

        return false;
    }

    public function logout()
    {
        $this->setAcl(new \Access\Acl\Acl($this->getController()->getServiceLocator()));
        $this->getSession()->setExpirationSeconds(1);

        $this->getController()->redirect()->toRoute('access-login');
    }

    public function isAllowed($resource, $privillege)
    {
        $resource = new Resource($resource);
        $isAllowed = $this->getAcl()->isAllowed($resource, $privillege);

        if($isAllowed) {
            return true;
        }

        return false;
    }

    protected function getServiceLocator()
    {
        $controller = $this->getController();
        if (!$controller instanceof ServiceLocatorAwareInterface) {
            throw new \Exception("The controller who called the plugin is not a instance of ServiceLocatorAwareInterface");
        }

        return $controller->getServiceLocator();
    }

    /**
     * @param \Zend\Session\Container $session
     */
    protected function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @return \Zend\Session\Container
     */
    protected function getSession()
    {
        $session = new Session('Access');
        $session->setExpirationSeconds(1800);

        if (empty($session->acl)) {
            $acl = new \Access\Acl\Acl($this->getServiceLocator());
            $session->acl = clone $acl;
        }

        return $session;
    }

    /**
     * @param \Access\Acl\Acl $acl
     */
    protected function setAcl(\Access\Acl\Acl $acl)
    {
        $session = $this->getSession();
        $session->acl = clone $acl;
    }

    /**
     * @return \Access\Acl\Acl
     */
    protected function getAcl()
    {
        $session = $this->getSession();

        if(empty($session->acl)) {
            $acl = new \Access\Acl\Acl($this->getServiceLocator());
            $session->acl = clone $acl;
        }

        $acl = clone $session->acl;

        return $acl;
    }
}
