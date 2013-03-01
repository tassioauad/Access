<?php

namespace Access\Model;

use Access\Entity;

class User extends AbstractModel
{
    protected $entity = 'Access\Entity\User';

    public function find($id)
    {
        $usuario = $this->getRepository()->findBy(array('id' => $id))[0];
        if (empty($usuario) || !$usuario->isActive()) {
            return null;
        }

        return $usuario;
    }

    public function findByEmail($emailAddress)
    {
        return $this->getRepository()->findBy(array('email' => $emailAddress))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\User $user)
    {
        if (empty($user)) {
            throw new \Exception("The user's entity is Empty and could not be inserted");
        }

        $photo = $user->getPhoto();
        if (empty($photo)) {
            $user->setPhoto('/images/users_photo/default.gif');
        }

        $isActive = $user->isActive();
        if (empty($isActive)) {
            $user->setActive(false);
        }

        try {
            $this->getEntityManager()->beginTransaction();
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
        } catch (\Exception $ex) {
            $this->getEntityManager()->rollback();
            throw $ex;
        }
    }
}
