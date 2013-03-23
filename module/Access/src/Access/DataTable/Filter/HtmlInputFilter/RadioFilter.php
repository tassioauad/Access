<?php

namespace Access\DataTable\Filter\HtmlInputFilter;

use \ZendTest\XmlRpc\Server\Exception;
use Access\DataTable\Filter\HtmlInputFilter\AbstractFilter;

/**
 *
 */
class RadioFilter extends AbstractFilter
{

    /**
     * @var String
     */
    private $radioName;

    /**
     * @param string $identifier
     * @param string $selectName
     * @param string $dbTable
     * @param string $dbColumnName
     * @param int $type
     */
    public function __construct($identifier, $selectName, $dbTable, $dbColumnName, $type)
    {
        parent::__construct($identifier, $dbTable, $dbColumnName, $type);
        $this->radioName = $selectName;
    }

    /**
     * @return string
     */
    public function getJSToFilter()
    {
        $javascript = "'name': '".$this->identifier."', 'value': $(\"input[name='".$this->radioName."']:checked\").val()";
        $javascript .= "
        ";

        return $javascript;
    }

    /**
     * @return string
     */
    public function getJSToClear()
    {
        $javascript = "
        ";
        $javascript .= "atualizaCheckbox($(\"input[name='".$this->radioName."']:checked\").attr('id'), false);"; //TODO : It's not a JS pattern method!
        $javascript .= "
        ";
        //$javascript.= "oTable.fnDraw();";

        return $javascript;
    }
}
