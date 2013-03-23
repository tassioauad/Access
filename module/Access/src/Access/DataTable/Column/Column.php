<?php

namespace Access\DataTable\Column;

use ZendTest\XmlRpc\Server\Exception;
use Access\DataTable\Element\InterfaceElement;
use Access\DataTable\Element\DbElement\Element as DbElement;

/**
 *
 */
class Column
{
    /**
     * @var Integer
     */
    private $index;

    /**
     * @var String
     */
    private $separator;
    /**
     * @var InterfaceElement[]
     */
    private $elements = array();
    /**
     * @var bool
     */
    private $enableSorting = false;

    /**
     * Constructor
     */
    public function __construct($index)
    {
        $this->index = $index;
    }

    /**
     * @param $element
     */
    public function insertElement($element)
    {
        if ($this->elementInstanceOfChecks($element)) {
            $this->elements[] = $element;
        }
    }

    /**
     * @param $element
     * @return bool
     * @throws \ZendTest\XmlRpc\Server\Exception
     */
    public function elementInstanceOfChecks($element)
    {
        if ($element instanceof InterfaceElement) {
            return true;
        } else {
            throw new Exception('The element must be an implementation of InterfaceElement');
        }
    }

    /**
     * @param $separator
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    /**
     * @return mixed
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param $line
     * @return string
     */
    public function getValueToPrint($line)
    {
        $value = "";
        $elementPrint = null;
        foreach ($this->elements as $element) {
            if (!empty($this->separator) && !empty($elementPrint)) {
                $value .= $this->separator;
            }
            $elementPrint = $element->getValueToPrint($line);
            $value .= $elementPrint;
        }

        return $value;
    }

    /**
     * @return array
     */
    public function getAllDbElements()
    {
        $filterValues = array();
        foreach ($this->elements as $element) {
            if ($element instanceof DbElement) {
                $filterValues[] = $element;
            }
        }
        return $filterValues;
    }

    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param int $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param boolean $enableSorting
     */
    public function setEnableSorting($enableSorting)
    {
        $this->enableSorting = $enableSorting;
    }

    /**
     * @return boolean
     */
    public function getEnableSorting()
    {
        return $this->enableSorting;
    }
}
