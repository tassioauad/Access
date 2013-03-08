<?php

namespace Access\Model;

use Access\Entity;

class UserRole extends AbstractModel
{
    protected $entity = 'Access\Entity\UserRole';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findByUser($userId)
    {
        return $this->getRepository()->findBy(array('user' => $userId));
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\UserRole $userRole)
    {
        try {
            $this->getEntityManager()->beginTransaction();
            $this->getEntityManager()->persist($userRole);
            $this->getEntityManager()->flush($userRole);
            $this->getEntityManager()->commit();
        } catch (\Exception $ex) {
            $this->getEntityManager()->rollback();
        }
    }
}
