<?php

namespace Access\Model;

class Role extends AbstractModel
{
    protected $entity = 'Access\Entity\Role';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }
}
