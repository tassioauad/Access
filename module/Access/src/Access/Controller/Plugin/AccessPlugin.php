<?php

namespace Access\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Access\Model;
use \Zend\ServiceManager\ServiceLocatorAwareInterface;
use Access\Service\AclService;

class AccessPlugin extends AbstractPlugin
{

    /**
     * @param $username string
     * @param $password string
     * @return bool
     */
    public function login($username, $password)
    {
        $authenticate = $this->getServiceLocator()->get('Access\Auth\Auth');

        $userEntity = $authenticate->isValid($username, $password);

        if ($userEntity) {
            $this->getAclService()->setAcl(new \Access\Acl\Acl($this->getServiceLocator(), $userEntity));
            return true;
        }

        return false;
    }

    /**
     * Disconnect user in the session
     */
    public function logout()
    {
        $this->getAclService()->setAcl(new \Access\Acl\Acl($this->getController()->getServiceLocator()));
        $this->getAclService()->getSession()->setExpirationSeconds(1);

        $this->getController()->redirect()->toRoute('access-login');
    }

    public function isAllowed($resource, $privillege)
    {
        return $this->getAclService()->isAllowed($resource, $privillege);
    }

    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     * @throws \Exception
     */
    protected function getServiceLocator()
    {
        $controller = $this->getController();
        if (!$controller instanceof ServiceLocatorAwareInterface) {
            throw new \Exception("The controller who called the plugin is not a instance of ServiceLocatorAwareInterface");
        }

        return $controller->getServiceLocator();
    }

    /**
     * @return AclService
     */
    protected function getAclService()
    {
        $aclService = $this->getServiceLocator()->get('Access\Service\AclService');
        return $aclService;
    }
}
