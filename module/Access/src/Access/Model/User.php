<?php

namespace Access\Model;

class User extends AbstractModel
{
    protected $entity = 'Access\Entity\User';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id, 'ativo' => true))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

}
