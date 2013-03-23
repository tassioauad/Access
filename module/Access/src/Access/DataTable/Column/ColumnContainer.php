<?php
namespace Access\DataTable\Column;

/**
 *
 */
class ColumnContainer
{
    /**
     * @var Column[]
     */
    private $columns = array();

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @param $index
     */
    public function setColumn($index)
    {
        if ($this->repeatedIndexChecks($index)) {
            $this->columns[] = new Column($index);
        }
    }

    /**
     * @param $index
     * @return Column
     * @throws \Exception
     */
    public function getColumnByIndex($index)
    {
        foreach ($this->columns as $column) {
            if ($column->getIndex() == $index) {
                return $column;
            }
        }

        throw new \Exception("There is not a column with index ".$index);
    }

    /**
     * @return Column[]
     */
    public function getColumns()
    {
        $this->sequenceColumnsIndexChecks(); //Ensuring that the index is 0 and others validations Sort order securely.
        $this->orderColumns();

        return $this->columns;
    }

    /**
     * Ordering the columns using $index as parameter
     */
    public function orderColumns()
    {
        $newColumns = array();

        for ($i = 0; $i <= $this->highestIndex(); $i++) {
            foreach ($this->columns as $column) {
                if ($column->getIndex() == $i) {
                    $newColumns[] = $column;
                }
            }
        }
    }

    //Verifying if is missing a column in any index. Because if you set an column in index 2,
    //you must to set columns in indexes 0 and 1.
    /**
     * @throws \ZendTest\XmlRpc\Server\Exception
     */
    public function sequenceColumnsIndexChecks()
    {
        $lowestIndex = $this->lowestIndex();
        $highestIndex = $this->highestIndex();

        if ($lowestIndex != 0) {
            throw new \Exception("Missing the column index 0");
        }

        if ($highestIndex != sizeof($this->columns)-1) {
            throw new \Exception("Missing the column index ". sizeof($this->columns));
        }

        $i = 0;
        while ($i <= $highestIndex) {
            $found = false;
            foreach ($this->columns as $column) {
                if ($column->getIndex() === $i) {
                    $found = true;
                }
            }
            if (!$found) {
                throw new \Exception("Missing column with index ".$i);
            }

            $i++;
        }
    }

    /**
     * @param $index
     * @return bool
     * @throws \ZendTest\XmlRpc\Server\Exception
     */
    public function repeatedIndexChecks($index)
    {
        foreach ($this->columns as $column) {
            if ($column->getIndex() === $index) {
                throw new \Exception("Already exist a column with this index");
            }
        }

        return true;
    }

    /**
     * @param $column
     * @throws \ZendTest\XmlRpc\Server\Exception
     */
    public function columnInstanceOfChecks($column) {
        if(!$column instanceof Column) {
            throw new \Exception("This column is not a instance of class Column");
        }
    }

    /**
     * @return int
     */
    public function lowestIndex() {
        $lowestIndex = sizeof($this->columns);
        foreach ($this->columns as $column) {
            if ($column->getIndex() < $lowestIndex) {
                $lowestIndex = $column->getIndex();
            }
        }

        return $lowestIndex;
    }

    /**
     * @return int
     */
    public function highestIndex()
    {
        $highestIndex = 0;
        foreach ($this->columns as $column) {
            if ($column->getIndex() > $highestIndex) {
                $highestIndex = $column->getIndex();
            }
        }

        return $highestIndex;
    }
}
