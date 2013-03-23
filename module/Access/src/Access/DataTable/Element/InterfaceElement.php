<?php

namespace Access\DataTable\Element;

/**
 *
 */
interface InterfaceElement
{
    //TODO : Set a type in doc for attribute $line;
    /**
     * @param $line
     * @return string
     */
    public function getValueToPrint($line);
}
