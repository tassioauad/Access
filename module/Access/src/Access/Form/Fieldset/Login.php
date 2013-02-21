<?php

namespace Access\Form\Fieldset;

use Access\Entity;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

class Login extends Fieldset
{
    function __construct()
    {
        parent::__construct('login_fieldset');
        $this->setHydrator(new ClassMethods(true))
            ->setObject(new Entity\User());

        $this->add(
            array(
                'name' => 'email',
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'input-block-level',
                    'placeholder' => 'email'
                )
            )
        );

        $this->add(
            array(
                'name' => 'password',
                'type' => 'Zend\Form\Element\Password',
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'input-block-level',
                    'placeholder' => 'password'
                )
            )
        );
    }

}
