<?php

namespace Access\Auth;

use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Doctrine\ORM\EntityManager;
use \DoctrineModule\Authentication\Adapter\ObjectRepository;

class Authentication
{
    /**
     * @var ObjectRepository
     */
    private $authAdapter;
    /**
     * @var EntityManager
     */
    private $entityManager;

    function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return ObjectRepository
     */
    protected function buildAuthAdapter()
    {
        if(empty($this->authAdapter)) {

            $this->authAdapter = new ObjectRepository(
                array(
                    'objectManager' => $this->entityManager,
                    'identityClass' => 'Access\Entity\User',
                    'identityProperty' => 'username',
                    'credentialProperty' => 'password',
                )
            );
        }

        return $this->authAdapter;
    }

    public function isValid($username, $password)
    {
        $this->authAdapter = $this->buildAuthAdapter();
        $this->authAdapter->setIdentityValue($username);
        $this->authAdapter->setCredentialValue($password);

        $authResult = $this->authAdapter->authenticate();

        if($authResult->getCode() == 1) {
            if($authResult->getIdentity()->isActive()) {
                return $authResult->getIdentity();
            }

        }

        return false;
    }

}
