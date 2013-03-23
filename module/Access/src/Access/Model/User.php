<?php

namespace Access\Model;

use Access\Entity;
use Access\Utils;

class User extends AbstractModel
{
    protected $entity = 'Access\Entity\User';
    protected $table = "account";

    public function find($id)
    {
        $user = $this->getRepository()->findBy(array('id' => $id))[0];

        if (empty($user) || !$user->isActive()) {
            return null;
        }

        return $user;
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
        $user->setPassword(md5($user->getPassword()));

        if (empty($user)) {
            throw new \Exception("The user's entity is Empty and could not be inserted");
        }

        $photo = $user->getPhoto();
        if (empty($photo)) {
            $user->setPhoto('/images/users_photo/default.gif');
        }

        $createdAt = $user->getCreatedAt();
        if (empty($createdAt)) {
            $now = new \DateTime();
            $user->setCreatedAt($now->format("Y-m-d"));
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
