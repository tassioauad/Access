<?php

namespace Access\DataTable\Filter\HtmlInputFilter;

/**
 *
 */
class TextFilter extends AbstractFilter
{
    /**
     * @var string
     */
    private $textId;

    /**
     * @param string $identifier
     * @param string $textId
     * @param string $dbTableAlias
     * @param int $dbColumnName
     * @param $type
     */
    function __construct($identifier, $textId, $dbTableAlias, $dbColumnName, $type)
    {
        parent::__construct($identifier, $dbTableAlias, $dbColumnName, $type);
        $this->textId = $textId;
    }

    /**
     * @return string
     */
    public function getJSToFilter()
    {
        $javascript = "'name': '".$this->identifier."', 'value': $('#".$this->textId."').val()";
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
        $javascript .= "$('#".$this->textId."').val('');";
        $javascript .= "
        ";
        //$javascript.= "oTable.fnDraw();";

        return $javascript;
    }
}