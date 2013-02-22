<?php

namespace Access\Form\Fieldset\Validator;

use \Zend\Validator\AbstractValidator;

class FullNameValidator extends AbstractValidator
{

    const INVALID    = 'invalidFullName';

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID            => "Escreva seu nome e sobrenome",
    );

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        $fullNameArray = explode(' ', $value);

        if (sizeof($fullNameArray) < 2) {
            $this->error(self::INVALID);
            return false;
        }

        return true;
    }
}
