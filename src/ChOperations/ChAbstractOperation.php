<?php
namespace InformikaDoctrineClickHouse\ChOperations;


use InformikaDoctrineClickHouse\ChRows\ChAbstractRow;
use InformikaDoctrineClickHouse\Driver\DBAL\Connection;
use InformikaDoctrineClickHouse\Mapping\Annotation\Column;
use InformikaDoctrineClickHouse\Mapping\Annotation\Table;

abstract class ChAbstractOperation implements ChOperationInterface
{
    /** @var  Table */
    protected $table;
    /** @var ChAbstractRow[] */
    protected $rows = [];
    /** @var Column[] */
    protected $columns = [];

    /** @var  Connection */
    private $connection;

    /**
     * ChAbstractOperation constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->setConnection($connection);
    }

    /**
     * @param Column $column
     */
    public function addColumn(Column $column)
    {
        $this->columns[] = $column;
    }

    /**
     * @param ChAbstractRow $row
     */
    public function addRow(ChAbstractRow $row)
    {
        $this->rows[] = $row;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param Table $table
     */
    public function setTable(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param array $rows
     */
    public function setRows(array $rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}