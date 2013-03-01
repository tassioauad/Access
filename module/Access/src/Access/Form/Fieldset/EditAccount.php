<?php

namespace Access\Form\Fieldset;

use Access\Entity;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

class EditAccount extends Fieldset
{
    function __construct()
    {
        parent::__construct('editaccount_fieldset');
        $this->setHydrator(new ClassMethods(true))
            ->setObject(new Entity\User());

        $this->add(
            array(
                'name' => 'fullname',
                'options' => array(
                    'label' => 'Your Full Name:'
                ),
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'input-block-level'
                )
            )
        );

        $this->add(
            array(
                'name' => 'email',
                'options' => array(
                    'label' => 'Email:'
                ),
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'input-block-level'
                )
            )
        );
    }

}
