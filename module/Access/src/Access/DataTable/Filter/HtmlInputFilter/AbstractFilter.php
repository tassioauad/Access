<?php

namespace Access\DataTable\Filter\HtmlInputFilter;

use Access\DataTable\Filter\InterfaceFilter;
use ZendTest\XmlRpc\Server\Exception;

/**
 *
 */
abstract class AbstractFilter implements InterfaceFilter
{
    /**
     * @var string
     */
    protected $identifier;
    /**
     * @var string
     */
    protected $dbTable;
    /**
     * @var string
     */
    protected $dbColumnName;
    /**
     * @var int
     */
    protected $dataType;
    /**
     *
     */
    const STRING = 0;
    /**
     *
     */
    const NUMERIC = 1;
    /**
     *
     */
    const BOOLEAN = 2;
    /**
     *
     */
    const DATE = 3;

    /**
     * @param string $identifier
     * @param string $dbTableAlias
     * @param string $dbColumnName
     * @param int $dataType
     * @throws \ZendTest\XmlRpc\Server\Exception
     */
    public function __construct($identifier, $dbTableAlias, $dbColumnName, $dataType)
    {
        $this->identifier = $identifier;
        $this->dbTable = $dbTableAlias;
        $this->dbColumnName = $dbColumnName;

        if ($dataType == self::STRING || $dataType == self::NUMERIC
            || $dataType == self::BOOLEAN || $dataType == self::DATE ) {
            $this->dataType = $dataType;
        } else {
            throw new Exception("You've inserted a value not valid in attribute dataType of filter with identifier ".$this->identifier);
        }
    }

    /**
     * @return mixed
     */
    public function getDbColumnName()
    {
        return $this->dbColumnName;
    }

    /**
     * @return mixed
     */
    public function getDbTable()
    {
        return $this->dbTable;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return mixed
     */
    public function getDataType()
    {
        return $this->dataType;
    }

}
