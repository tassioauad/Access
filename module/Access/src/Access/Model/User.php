<?php

namespace Access\Model;

use Access\Entity;

class User extends AbstractModel
{
    protected $entity = 'Access\Entity\User';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id, 'ativo' => true))[0];
    }

    public function findByEmail($emailAddress)
    {
        return $this->getRepository()->findBy(array('email' => $emailAddress))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function insert(Entity\User $user)
    {
        try {
            $this->getEntityManager()->beginTransaction();
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush($user);
            $this->getEntityManager()->commit();
        } catch (\Exception $ex) {
            $this->getEntityManager()->rollback();
        }
    }
}
