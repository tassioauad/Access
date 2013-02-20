<?php

namespace Access\Entity;

use Zend\Stdlib\Hydrator;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

abstract class AbstractEntity implements InputFilterAwareInterface
{
    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

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

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @throws \Exception
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}
