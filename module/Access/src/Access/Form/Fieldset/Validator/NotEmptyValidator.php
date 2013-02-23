<?php

namespace Access\Form\Fieldset\Validator;

use \Zend\Validator\AbstractValidator;

class NotEmptyValidator extends AbstractValidator
{

    const IS_EMPTY    = 'isEmpty';

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::IS_EMPTY            => "Campo obrigatório.",
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
        if (empty($value)) {
            $this->error(self::IS_EMPTY);
            return false;
        }

        return true;
    }
}
