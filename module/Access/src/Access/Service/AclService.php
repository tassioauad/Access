<?php
namespace Access\Service;

use \Zend\Session\Container as Session;

class AclService
{
    /**
     * @var Session
     */
    private $session;

    function __construct()
    {
        $session = new Session('Access');
        $session->setExpirationSeconds(1800);

        $this->session = clone $session;
    }

    /**
     * @return \Access\Acl\Acl
     */
    public function getAcl()
    {
        $session = clone $this->session;

        if (empty($session->acl)) {
            throw new \Exception("There is no ACL on the session");
        }

        $acl = clone $session->acl;

        return $acl;
    }

    /**
     * @return int
     */
    public function getAuthenticatedRole()
    {
        return $this->getAcl()->getUserId();
    }

}
