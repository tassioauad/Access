<?php

namespace Access\Model;

class ResourcePrivillege extends AbstractModel
{
    protected $entity = 'Access\Entity\ResourcePrivillege';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }
}
