<?php

namespace Access\Form\Fieldset;

use Access\Entity;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

class EditAccountPassword extends Fieldset
{
    function __construct()
    {
        parent::__construct('editaccountpassword_fieldset');
        $this->setHydrator(new ClassMethods(true))
            ->setObject(new Entity\User());

        $this->add(
            array(
                'name' => 'oldpassword',
                'options' => array(
                    'label' => 'Old password:'
                ),
                'type' => 'Zend\Form\Element\Password',
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'input-block-level'
                )
            )
        );

        $this->add(
            array(
                'name' => 'password',
                'options' => array(
                    'label' => 'New password:'
                ),
                'type' => 'Zend\Form\Element\Password',
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'input-block-level'
                )
            )
        );
        $this->add(
            array(
                'name' => 'repassword',
                'options' => array(
                    'label' => 'Re-type the new password:'
                ),
                'type' => 'Zend\Form\Element\Password',
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'input-block-level'
                )
            )
        );
    }

}
