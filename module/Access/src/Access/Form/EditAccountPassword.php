<?php

namespace Access\Form;

use \Zend\Form\Form;

class EditAccountPassword extends Form
{
    function __construct()
    {
        parent::__construct('editacountpassword_form');
        $this->setAttribute('method', 'post')
            ->setAttribute("id", "editaccountpassword-form")
            ->setAttribute("novalidate", 'true')
            ->setAttribute("class", 'form-editaccountpassword');


        $this->add(
            array(
                'type' => 'Access\Form\Fieldset\EditAccountPassword',
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
                    'label' => 'Change'

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
                'editaccountpassword_fieldset' => array(
                    'password',
                    'repassword'
                )
            )
        );
    }

}
