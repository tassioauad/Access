<?php

namespace Access\Entity;

use Zend\Stdlib\Hydrator;

abstract class AbstractEntity
{
    function __construct(array $data = null)
    {
        if($data != null) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data)
    {
        $hydrator = new Hydrator\ClassMethods(true);
        $hydrator->hydrate($data, $this);
    }

    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods(true);

        return $hydrator->extract($this);
    }

}
