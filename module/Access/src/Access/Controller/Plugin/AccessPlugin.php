<?php

namespace Access\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Access\Model;
use \Zend\ServiceManager\ServiceLocatorAwareInterface;
use Access\Service\AclService;

class AccessPlugin extends AbstractPlugin
{

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

    public function logout()
    {
        $this->getAclService()->setAcl(new \Access\Acl\Acl($this->getController()->getServiceLocator()));
        $this->getAclService()->getSession()->setExpirationSeconds(1);

        $this->getController()->redirect()->toRoute('access-login');
    }

    public function isAllowed($resource, $privillege)
    {
        $resource = new Resource($resource);
        $isAllowed = $this->getAclService()->getAcl()->isAllowed($resource, $privillege);

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

    public function getAclService()
    {
        $aclService = $this->getServiceLocator()->get('Access\Service\AclService');
        return $aclService;
    }
}
