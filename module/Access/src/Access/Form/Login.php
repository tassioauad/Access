<?php

namespace Access\Form;

use \Zend\Form\Form;

class Login extends Form
{
    function __construct()
    {
        parent::__construct('login_form');
        $this->setAttribute('method', 'post')
            ->setAttribute("id", "login_form")
            ->setAttribute("novalidate", 'true');

        $this->add(
            array(
                'type' => 'Access\Form\Fieldset\Login',
                'options' => array(
                    'use_as_base_fieldset' => true
                )
            )
        );

        $this->add(
            array(
                'type' => 'Zend\Form\Element\Csrf',
                'name' => 'security',
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'options' => array(
                    'label' => 'Login'

                ),
                'attributes' => array(
                    'type' => 'submit'
                )
            )
        );

        $this->setValidationGroup(
            array(
                'security',
                'login_fieldset' => array(
                    'username',
                    'password'
                )
            )
        );
    }

}
