<?php

namespace Access\Form;

use \Zend\Form\Form;

class EditAccount extends Form
{
    function __construct()
    {
        parent::__construct('editacount_form');
        $this->setAttribute('method', 'post')
            ->setAttribute("id", "editaccount-form")
            ->setAttribute("novalidate", 'true')
            ->setAttribute("class", 'form-editaccount');


        $this->add(
            array(
                'type' => 'Access\Form\Fieldset\EditAccount',
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
                    'label' => 'Edit'

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
                'editaccount_fieldset' => array(
                    "fullname",
                    'email',
                    'password',
                    'repassword'
                )
            )
        );
    }

}
