<?php
namespace Access\DataTable\Filter;

use ZendTest\XmlRpc\Server\Exception;
use Access\DataTable\Filter\InterfaceFilter;

/**
 *
 */
class FilterContainer
{
    /**
     * @var \Access\DataTable\Filter\HtmlInputFilter\AbstractFilter[]
     */
    private $filters = array();

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @param $filter
     * @throws \ZendTest\XmlRpc\Server\Exception
     */
    public function setFilter($filter)
    {
        if ($filter instanceof InterfaceFilter) {
            $this->filters[] = $filter;
        } else {
            throw new Exception("The param 'filter' must be an instance of InterfaceFilterField");

        }
    }

    /**
     * @return HtmlInputFilter\AbstractFilter[]|array
     */
    public function getFilters()
    {
        return $this->filters;
    }

}
