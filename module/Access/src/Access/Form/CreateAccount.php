<?php

namespace Access\Form;

use \Zend\Form\Form;

class CreateAccount extends Form
{
    function __construct()
    {
        parent::__construct('createacount_form');
        $this->setAttribute('method', 'post')
            ->setAttribute("id", "createaccount-form")
            ->setAttribute("novalidate", 'true')
            ->setAttribute("class", 'form-createaccount');


        $this->add(
            array(
                'type' => 'Access\Form\Fieldset\CreateAccount',
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
                    'label' => 'Create Account'

                ),
                'attributes' => array(
                    'type' => 'submit',
                    'class' => 'btn btn-large btn-primary'
                )
            )
        );

        $this->setValidationGroup(
            array(
                'security',
                'createaccount_fieldset' => array(
                    "fullname",
                    'email',
                    'password',
                )
            )
        );
    }

}
