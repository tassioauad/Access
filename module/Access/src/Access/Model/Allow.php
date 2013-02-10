<?php

namespace Access\Model;

use Access\Entity;

class Allow extends AbstractModel
{
    protected $entity = 'Access\Entity\Allow';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function findByUserId($id)
    {
        return $this->getRepository()->findBy(array('usuarioid' => $id))[0];
    }

    public function findByUser(Entity\User $user)
    {
        return $this->getRepository()->findBy(array('usuarioid' => $user->getId()))[0];
    }
}
