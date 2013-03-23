<?php

namespace Access\Model;

class ResourcePrivillege extends AbstractModel
{
    protected $entity = 'Access\Entity\ResourcePrivillege';
    protected $table = 'controller_action';


    public function find($id)
    {
        return $this->getRepository()->findBy(array('id' => $id))[0];
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }
}
