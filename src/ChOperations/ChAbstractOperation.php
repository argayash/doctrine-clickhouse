<?php
namespace InformikaClickHouse\ChOperations;


use ClickHouseDB\Client;

abstract class ChAbstractOperation
{
    /** @var  string */
    protected $name;
    /** @var  string */
    protected $table;
    /** @var array */
    protected $rows = [];
    /** @var array */
    protected $columns = [];

    /** @var  Client */
    private $chClient;

    public function __construct(Client $client)
    {
        $this->setChClient($client);
    }

    abstract public function prepare();

    abstract public function execute();

    /**
     * @param string $column
     */
    public function addColumn(string $column)
    {
        $this->columns[] = $column;
    }

    /**
     * @param array $row
     */
    public function addRow(array $row)
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
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table)
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