<?php

namespace Access\DataTable\Element\DbElement;

use Access\DataTable\Element\InterfaceElement;

/**
 *
 */
class Element implements InterfaceElement
{
    /**
     * @var string
     */
    private $tableName;
    /**
     * @var string
     */
    private $dbColumnName;
    /**
     * @var string
     */
    private $dbColumnAlias;
    /**
     * @var array
     */
    private $convertBooleanValue = array();
    /**
     * @var \Closure
     * This attribute has to contain a function to format as you want the result.
     */
    private $functionFormatter;

    /**
     * @param string $tableName
     * @param string $dbColumnName
     * @param string $dbColumnAlias
     * @param callable $functionFormatter
     * If you set any value different from "" in $dbColumnAlias, it will be used as the DataBase Column's name to get
     * values.
     * The $functionFormatter has to contain a function to format as you want the result. The function has to have as
     * param the attribute result. Don't forget it!
     */
    public function __construct($tableName, $dbColumnName, $dbColumnAlias = "", \Closure $functionFormatter = null)
    {
        $this->tableName = $tableName;
        $this->dbColumnName = $dbColumnName;

        if (empty($dbColumnAlias)) {
            $this->dbColumnAlias = $dbColumnName;
        } else {
            $this->dbColumnAlias = $dbColumnAlias;
        }

        if ($functionFormatter instanceof \Closure) {
                $this->functionFormatter = $functionFormatter;
        }
    }

    /**
     * @return string
     */
    public function getDbColumnName()
    {
        return $this->dbColumnName;
    }

    /**
     * @param $line
     * @return string
     */
    public function getValueToPrint($line)
    {
        $result = "";
        if (isset($line[$this->dbColumnAlias])) {
            if (count($this->convertBooleanValue) > 0) {
                if ($line[$this->dbColumnAlias] == true) {
                    $result = $this->convertBooleanValue['true'];
                } else {
                    $result = $this->convertBooleanValue['false'];
                }
            } else {
                $result = $line[$this->dbColumnAlias];
            }
        }
        if (null != $this->functionFormatter && null != $result) {
            $result = call_user_func($this->functionFormatter, $result);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    public function getConvertBooleanValue()
    {
        return $this->convertBooleanValue;
    }

    /**
     * @param $convertBooleanValue
     */
    public function setConvertBooleanValue($convertBooleanValue = array('true' => 'Yes', 'false' => 'No'))
    {
        $this->convertBooleanValue = $convertBooleanValue;
    }

    /**
     * @return string "tableName.dbColumnName"
     */
    public function getDbReferenceOfElement()
    {
        return $this->tableName . "." . $this->dbColumnName;
    }

    /**
     * @return string
     */
    public function getDbColumnAlias()
    {
        return $this->dbColumnAlias;
    }


}
