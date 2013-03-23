<?php

namespace Access\DataTable\Element\HtmlElement;

use Access\DataTable\Element\HtmlElement\AbstractElement;

/**
 *
 */
class CheckboxElement extends AbstractElement
{

    /**
     * @param string $attributes
     * @param array $dbColumns
     * @param bool|array $requirement
     */
    public function __construct($attributes = '', $dbColumns = array(), $requirement = false)
    {
        parent::__construct($attributes, $dbColumns, $requirement);
    }

    //TODO : Set a type in doc for attribute $line;
    /**
     * @param $line
     * @return string
     */
    public function getValueToPrint($line)
    {
        $replacedAttributes = $this->attributes;
        foreach ($this->dbColumns as $key => $dbColumn) {
            $replacedAttributes = str_replace($key, $line[$dbColumn], $replacedAttributes);
        }

        if ($this->canBePrinted($line)) {
            $value = "<input type='checkbox' ";
            $value .= $replacedAttributes;
            $value .= " />";
        }
        else
            $value = "";

        return $value;
    }

}
