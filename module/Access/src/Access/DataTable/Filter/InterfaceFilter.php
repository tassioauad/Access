<?php

namespace Access\DataTable\Filter;

/**
 *
 */
interface InterfaceFilter
{
    /**
     * @return string
     */
    public function getJSToFilter();

    /**
     * @return string
     */
    public function getJSToClear();
}
