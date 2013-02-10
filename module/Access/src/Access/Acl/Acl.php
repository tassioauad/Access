<?php

namespace Access\Acl;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Session\Container as Session;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Access\Model;
use Access\Entity;

class Acl extends ZendAcl
{
    /**
     * @var int
     */
    private $userId;

    function __construct(ServiceLocatorInterface $serviceLocator, Entity\User $user = null)
    {
        $roles = array();
        if($user != null){
            $userRoleModel = $serviceLocator->get('Access\Model\UserRole');
            $userRoles = $userRoleModel->findByUser($user->getId());
            foreach($userRoles as $userRole) {
                $roles[] = $userRole->getRole();
            }
        } else {
            $user = new Entity\User();
            $user->setId(-1);
            $roles = array(new Entity\Role(array('roleId' => "GUESS")));
        }

        $this->userId = $user->getId();

        $this->addRole(new GenericRole('GUESS'));

        foreach ($this->generateRoles($serviceLocator) as $role) {
            $this->addRole($role);
        }

        $this->addRole(new GenericRole($this->userId), $roles);

        foreach ($this->generateResouces($serviceLocator) as $resource) {
            $this->addResource($resource);
        }

        foreach ($this->generateAllows($serviceLocator) as $allow) {
            $this->allow($allow['role'], $allow['resource'], $allow['privillege']);
        }

    }

    public function generateRoles(ServiceLocatorInterface $serviceLocator)
    {
        /**@var $roleModel Model\Role */
        $roleModel = $serviceLocator->get('Access\Model\Role');
        $roles = $roleModel->findAll();

        $rolesArray = array();
        /**@var $role Entity\Role */
        foreach ($roles as $role) {
            $rolesArray[] = new GenericRole($role->getRoleId());
        }

        return $rolesArray;
    }

    public function generateResouces(ServiceLocatorInterface $serviceLocator)
    {
        /**@var $resourceModel Model\Resource */
        $resourceModel = $serviceLocator->get('Access\Model\Resource');
        $resources = $resourceModel->findAll();

        $resourcesArray = array();
        /**@var $resource Entity\Resource */
        foreach ($resources as $resource) {
            $resourcesArray[] = new GenericResource($resource->getResourceId());
        }

        return $resourcesArray;
    }

    public function generateAllows(ServiceLocatorInterface $serviceLocator)
    {
        /**@var $allowModel Model\Allow */
        $allowModel = $serviceLocator->get('Access\Model\Allow');
        $allows = $allowModel->findAll();

        $allowsArray = array();
        /**@var $allow Entity\Allow */
        foreach ($allows as $allow) {
            $allowsArray[] = array(
                'role' => $allow->getRole(),
                'resource' => $allow->getResource(),
                'privillege' => $allow->getPrivillege()->getTag()
            );
        }

        return $allowsArray;
    }

    /**
     * @param $resourse
     * @param $privillege
     * @return bool
     */
    public function isAllowed($resourse, $privillege)
    {
        return parent::isAllowed($this->userId, $resourse, $privillege);
    }
}
