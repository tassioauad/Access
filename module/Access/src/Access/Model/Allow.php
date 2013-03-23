<?php

namespace Access\Model;

use Access\Entity;

class Allow extends AbstractModel
{
    protected $entity = 'Access\Entity\Allow';
    protected $table = 'allow';

    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }
}
