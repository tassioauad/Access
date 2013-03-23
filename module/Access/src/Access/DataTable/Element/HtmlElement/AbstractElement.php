<?php

namespace Access\DataTable\Element\HtmlElement;

use Access\DataTable\Element\InterfaceElement;

/**
 *
 */
abstract class AbstractElement implements InterfaceElement
{
    /**
     * @var string
     */
    protected $attributes;
    /**
     * @var \Access\DataTable\Column\Column[]
     */
    protected $dbColumns;
    /**
     * Return value to print only if they meet the requirement represented by this variable
     * this array should has 3 keys: dbColumn, value and validateFunction (\Closure)
     * @var array
     */
    protected $requirement = false;

    /**
     * @param string $attributes
     * @param \Access\DataTable\Column\Column[]  $dbColumns
     * @param array|bool $requirement Array with dbColumn and value keys, to be validated (on a equals)
     */
    public function __construct($attributes, $dbColumns, $requirement)
    {
        $this->attributes = $attributes;
        $this->dbColumns = $dbColumns;
        $this->requirement = $requirement;
    }

    public function canBePrinted($line)
    {
        if (empty($line)) {
            throw new \Exception("Line can not be empty!");
        }

        if (is_array($this->requirement)) {
            if (array_key_exists("dbColumn", $this->requirement) && array_key_exists("value", $this->requirement)) {
                $dbColumn = $this->requirement['dbColumn'];
                $value = $this->requirement['value'];

                if (!array_key_exists($dbColumn, $line)) {
                    throw new \Exception("Column" . $dbColumn . " does not exists");
                }

                return ($line[$dbColumn] === $value);
            } elseif (array_key_exists("validateFunction", $this->requirement)) {
                $validateFunction = $this->requirement["validateFunction"];
                if ($validateFunction instanceof \Closure) {
                    return call_user_func($validateFunction, $line);
                } else {
                    throw new \Exception("validateFunction is not a Closure");
                }
            }
        } else {
            return !$this->requirement;
        }
    }
}
