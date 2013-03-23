<?php

namespace Access\DataTable;

use Zend\Db\TableGateway\AbstractTableGateway;
use Access\Utils\Utils;
use Access\DataTable\Element\DbElement\Element as DbElement;
use Access\DataTable\Element\InterfaceElement;
use Zend\Dom\Query;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;
use Zend\Paginator\Paginator;
use Access\DataTable\Column\ColumnContainer;
use Access\DataTable\Filter\FilterContainer;
use Access\DataTable\Filter\HtmlInputFilter\AbstractFilter;

/**
 *
 */
class DataTable
{
    /**
     * @var Column\ColumnContainer
     */
    private $columnContainer;
    /**
     * @var Filter\FilterContainer
     */
    private $filterContainer;
    /**
     * @var array;
     */
    private $params;

    /**
     *
     */
    public function __construct()
    {
        $this->columnContainer = new ColumnContainer();
        $this->filterContainer = new FilterContainer();
    }

    /**
     * @param array $params
     */
    public function updateParams($params = array())
    {
        $this->params = $params;
    }

    /**
     * @param \Zend\Db\TableGateway\AbstractTableGateway $model
     * @param $select
     * @return array
     */
    public function getOutput(AbstractTableGateway $model, $select = null)
    {
        //Creating the ZEND_DB_SELECT to set on the Paginator
        try {
            if (empty($select)) {
                $select = $model->getSql()->select();
            }

            /* Busca em todos os filtros */
            $searchAll = false;
            $searchAllParams = "";
            $predicateSet = new \Zend\Db\Sql\Predicate\Predicate();
            $predicate = $predicateSet->nest();
            if (!empty($this->params["sSearch"])) {
                $searchAll = true;
                $searchAllParams = urldecode($this->params["sSearch"]);
            }

            foreach ($this->filterContainer->getFilters() as $filter) {

                if (empty($this->params[$filter->getIdentifier()]) && !$searchAll) {
                    continue;
                }

                // buscaTudo não aceita bool
                if (($filter->getDataType() == AbstractFilter::BOOLEAN) && (!$searchAll)) {
                    switch($this->params[$filter->getIdentifier()]) {
                        case 'true':
                            $select->where(" ( ".$filter->getDbTable().".".$filter->getDbColumnName()." is TRUE ) ");
                            break;
                        case 'false':
                            $select->where(" ( ".$filter->getDbTable().".".$filter->getDbColumnName()." is FALSE ) ");
                            break;
                    }

                } elseif ($filter->getDataType() == AbstractFilter::NUMERIC) {
                    if ($searchAll) {
                        $predicate->addPredicate(
                            new \Zend\Db\Sql\Predicate\Operator(
                                $filter->getDbTable().".".$filter->getDbColumnName(),
                                \Zend\Db\Sql\Predicate\Operator::OP_EQ,
                                $searchAllParams
                            ),
                            \Zend\Db\Sql\Predicate\PredicateSet::OP_OR
                        );
                    } else {
                        $select->where(
                            array(
                                $filter->getDbTable().".".$filter->getDbColumnName()
                                                                            => $this->params[$filter->getIdentifier()]
                            )
                        );
                    }
                } elseif ($filter->getDataType() == AbstractFilter::STRING) {

                    if ($searchAll) {
                        $predicate->addPredicate(
                            new \Zend\Db\Sql\Predicate\Expression(
                                "lower(".$filter->getDbTable().".".$filter->getDbColumnName().") LIKE ?",
                                "%".mb_strtolower($searchAllParams, "UTF8")."%"
                            ),
                            \Zend\Db\Sql\Predicate\PredicateSet::OP_OR
                        );
                    } else {
                        $select->where(
                            array(
                                new \Zend\Db\Sql\Predicate\Expression(
                                    "lower(".$filter->getDbTable().".".$filter->getDbColumnName().") LIKE ?",
                                    "%".mb_strtolower($this->params[$filter->getIdentifier()], "UTF8")."%"
                                )
                            )
                        );
                    }
                } elseif ($filter->getDataType() == AbstractFilter::DATE) {
                    if ($searchAll) {
                        $predicate->addPredicate(
                            new \Zend\Db\Sql\Predicate\Expression(
                                "".$filter->getDbTable().".".$filter->getDbColumnName()." = ?",
                                "%".Utils::DateToBd($this->params[$filter->getIdentifier()])."%"
                            ),
                            \Zend\Db\Sql\Predicate\PredicateSet::OP_OR
                        );
                    } else {
                        $select->where(
                            array(
                                new \Zend\Db\Sql\Predicate\Expression(
                                    "".$filter->getDbTable().".".$filter->getDbColumnName()." = ?",
                                    "%".Utils::DateToBd($this->params[$filter->getIdentifier()])."%"
                                )
                            )
                        );
                    }
                }
            }

            if ($predicate->count() > 0) {
                $select->where(array($predicateSet), \Zend\Db\Sql\Predicate\PredicateSet::OP_AND);
            }

            if (isset($this->params['iSortCol_0']) && isset($this->params['sSortDir_0'])) {
                $columnToSort = $this->columnContainer->getColumnByIndex((int) $this->params['iSortCol_0']);
                $columnElements = $columnToSort->getAllDbElements();
                /**
                 * @var $element DbElement
                 */
                foreach ($columnElements as $element) {
                    $select->reset("order");
                    $select->order($element->getDbColumnAlias() . " " . $this->params['sSortDir_0']);
                }
            }

            //Creating the Zend_Paginator
            $paginatorSelect = clone $select;
            $paginator = new Paginator(new PaginatorDbSelectAdapter($paginatorSelect, $model->getAdapter()));
            if (isset($this->params['iDisplayLength'])) {
                $paginator->setItemCountPerPage((integer)$this->params['iDisplayLength']);

                if (isset($this->params['iDisplayLength'])) {
                    $paginator->setCurrentPageNumber(
                        (int)$this->params['iDisplayStart'] / (int)$this->params['iDisplayLength'] + 1
                    );
                }
            }

            //Creating Output['aaData']
            $output = array();
            $output['aaData'] = array();
            foreach ($paginator->getCurrentItems() as $line) {
                $valuesInLine = array();
                foreach ($this->columnContainer->getColumns() as $column) {
                    $valuesInLine[] = $column->getValueToPrint($line);
                }

                $output['aaData'][] = $valuesInLine;
            }

            //Getting params from paginator
            $output['iTotalRecords'] = $paginator->getTotalItemCount();
            $output['iTotalDisplayRecords'] = $paginator->getTotalItemCount();
        } catch (\Exception $exp) {
            $output['error'] = $exp->getMessage();

            if ($exp->getPrevious() !== null) {
                $output['error'] .= $exp->getPrevious()->getMessage();
            }
        }

        return $output;

    }

    /**
     * @param $zend_controller
     * @param $zend_action
     * @param $zend_view
     * @param $htmlTableId
     * @param string $filterButtonId
     * @param string $clearButtonId
     * @return string
     */
    public function renderJqueryDataTable(
        $zend_controller,
        $zend_action,
        $htmlTableId,
        $filterButtonId = null,
        $clearButtonId = null,
        $extraParams = ""
    ) {
        //Creating Jquery DataTable
        $javascript =
            "var oTable;
                $(document).ready(function() {
                    oTable = $('#".$htmlTableId."').dataTable({
                            'bInfo': false,
                            'iDisplayLength': 10,
                            'aLengthMenu': [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                            'sPaginationType': 'full_numbers',
                            'bPaginate': true,
                            'aoColumnDefs': [{
                                'bSortable': false,
                                'aTargets': [ ";
        foreach ($this->columnContainer->getColumns() as $column) {
            if (!$column->getEnableSorting()) {
                $javascript .= $column->getIndex() . ", ";
            }
        }
        $javascript .=          "]
                            }],
                            'sDom': '<pl><i>rt',
                            'bProcessing': true,
                            'bServerSide': true,
                            'sServerMethod': 'POST',
                            'sAjaxSource': '/".$zend_controller."/".$zend_action."',
                            'fnServerParams': function (aoData) {
                            ";
        foreach ($this->filterContainer->getFilters() as $filter) {
            $javascript .= "aoData.push({".$filter->getJSToFilter()."});";
        }

        $javascript .=     "
                            },
                            'oLanguage': {
                                'sProcessing':   'Loading...',
                                'sLengthMenu':   '_MENU_',
                                'sZeroRecords':  'Não foram encontrados resultados',
                                'sInfo':         'Mostrando de _START_ até _END_ de _TOTAL_ registros',
                                'sInfoEmpty':    'Mostrando de 0 até 0 de 0 registros',
                                'sInfoFiltered': '(filtrado de _MAX_ registros no total)',
                                'sInfoPostFix':  '',
                                'sUrl':          '',
                                'oPaginate': {
                                    'sFirst':    '<<',
                                    'sPrevious': '<',
                                    'sNext':     '>',
                                    'sLast':     '>>'
                                }
                            }".$extraParams."
                    });
                 ";
        //Creating filter events
        if (!empty($clearButtonId) && !empty($filterButtonId)) {
            $javascript .= "$('#"."$filterButtonId"."').click(function(){
                oTable.fnDraw();
            });
            ";

            $javascript .= "$('#"."$clearButtonId"."').click(function(){";
            foreach ($this->filterContainer->getFilters() as $filter) {
                $javascript  .= $filter->getJSToClear();
            }
            $javascript .= " oTable.fnDraw(); ";
            $javascript .= "});
             ";
        }

        $javascript .= "});
             ";

        return $javascript;
    }

    /**
     * @param $n
     */
    public function createNColumns($n)
    {
        for ($i = 0; $i < $n; $i++) {
            $this->columnContainer->setColumn($i);
        }
    }

    /**
     *
     */
    public function getColumns()
    {
        $this->columnContainer->getColumns();
    }

    /**
     * @param $filter
     */
    public function setFilter($filter)
    {
        $this->filterContainer->setFilter($filter);
    }

    /**
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filterContainer->getFilters();
    }

    /**
     * @param array|InterfaceElement $element
     * @param $columnIndex
     */
    public function insertElement($columnIndex, $element)
    {
        if (is_array($element)) {
            foreach ($element as $aElement) {
                $this->columnContainer->getColumnByIndex($columnIndex)->insertElement($aElement);
            }
        } else {
            $this->columnContainer->getColumnByIndex($columnIndex)->insertElement($element);
        }
    }

    public function insertSeparatorInColumn($columnIndex, $separator)
    {
         $this->columnContainer->getColumnByIndex($columnIndex)->setSeparator($separator);
    }

    /**
     * @param array|int $index
     */
    public function columnEnableSorting($index)
    {
        foreach($index as $aIndex) {
            $this->columnContainer->getColumnByIndex($aIndex)->setEnableSorting(true);
        }
    }
}