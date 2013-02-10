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
                'name' => 'username',
                'options' => array(
                    'label' => 'Username:'
                ),
                'attributes' => array(
                    'required' => 'required'
                )
            )
        );

        $this->add(
            array(
                'name' => 'password',
                'type' => 'Zend\Form\Element\Password',
                'options' => array(
                    'label' => 'Password'
                ),
                'attributes' => array(
                    'required' => 'required'
                )
            )
        );
    }

}
