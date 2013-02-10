<?php

namespace Access\Entity;

interface InterfaceEntity
{
    public function hydrate(array $data);
    public function toArray();
    public function __construct(array $data = null);


}
