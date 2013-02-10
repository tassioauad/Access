<?php

namespace Access\Model;

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
}
