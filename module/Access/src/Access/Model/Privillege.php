<?php

namespace Access\Model;

class Privillege extends AbstractModel
{
    protected $entity = 'Access\Entity\Privillege';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }
}
