<?php

namespace Access\Model;

class Resource extends AbstractModel
{
    protected $entity = 'Access\Entity\Resource';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }
}
