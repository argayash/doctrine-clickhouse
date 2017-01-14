<?php
namespace InformikaDoctrineClickHouse\ChOperations;


use ClickHouseDB\Client;
use InformikaDoctrineClickHouse\ChRows\ChAbstractRow;
use InformikaDoctrineClickHouse\Mapping\Annotation\Column;
use InformikaDoctrineClickHouse\Mapping\Annotation\Table;

abstract class ChAbstractOperation
{
    /** @var  string */
    protected $name;
    /** @var  Table */
    protected $table;
    /** @var ChAbstractRow[] */
    protected $rows = [];
    /** @var Column[] */
    protected $columns = [];

    /** @var  Client */
    private $chClient;

    /**
     * ChAbstractOperation constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->setChClient($client);
    }

    /**
     * @return bool
     */
    abstract public function prepare();

    /**
     * @return bool
     */
    abstract public function execute();

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Table
     */
    public function getTable(): Table
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
    public function getRows(): array
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
    public function getColumns(): array
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
     * @return Client
     */
    public function getChClient(): Client
    {
        return $this->chClient;
    }

    /**
     * @param Client $chClient
     */
    public function setChClient(Client $chClient)
    {
        $this->chClient = $chClient;
    }
}