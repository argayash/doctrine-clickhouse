<?php
namespace InformikaDoctrineClickHouse\Driver\DBAL;


use ClickHouseDB\Client;

class Statement implements \IteratorAggregate, \Doctrine\DBAL\Driver\Statement
{
    /** @var  Client */
    private $client;
    /** @var  string */
    private $sql;
    /** @var  \ClickHouseDB\Statement */
    private $chStatement;

    private $values = [];
    private $results = [];
    private $currentIterator = null;
    private $defaultFetchMode = \PDO::FETCH_BOTH;

    public function __construct(Client $client, $sql)
    {
        $this->setClient($client);
        $this->setSql($sql);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->results);
    }

    public function closeCursor()
    {

    }

    public function columnCount()
    {
        return (count($this->results)) ? count($this->results[0]) : null;
    }

    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        $this->defaultFetchMode = $fetchMode;
    }

    public function fetch($fetchMode = null)
    {
        if (!$this->currentIterator) {
            $this->currentIterator = $this->getIterator();
        }
        $data = $this->currentIterator->current();
        $this->currentIterator->next();
        return $data;
    }

    public function fetchAll($fetchMode = null)
    {
        return $this->results;
    }

    /**
     * @param int $columnIndex
     * @return null
     */
    public function fetchColumn($columnIndex = 0)
    {
        $elem = $this->fetch();
        if ($elem) {
            if (array_key_exists($columnIndex, $elem)) {
                return $elem[$columnIndex];
            } else {
                return $elem[array_keys($elem)[$columnIndex]];
            }
        }

        return null;
    }

    function bindValue($param, $value, $type = null)
    {
        $this->values[$param] = $value;
    }

    function bindParam($column, &$variable, $type = null, $length = null)
    {
        $this->values[$column] =& $variable;
    }

    function errorCode()
    {
        return (int)$this->getChStatement()->isError();
    }

    function errorInfo()
    {
        return implode(PHP_EOL, $this->getChStatement()->info());
    }

    function execute($params = null)
    {
        $this->values = (is_array($params)) ? array_replace($this->values, $params) : $this->values;
        $sql = $this->sql;
        foreach ($this->values as $key => $value) {
            $value = is_string($value) ? "'" . addslashes($value) . "'" : $value;
            $sql = preg_replace("/(\?|:{$key})/i", "{$value}", $sql, 1);
        }

        $statement = $this->getClient()->write($sql);
        $this->setChStatement($statement);
        $results = $statement->rows();

        return !empty($results);
    }

    function rowCount()
    {
        return $this->getChStatement()->countAll();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @param mixed $sql
     */
    public function setSql($sql)
    {
        $this->sql = $sql;
    }

    /**
     * @return \ClickHouseDB\Statement
     */
    public function getChStatement()
    {
        return $this->chStatement;
    }

    /**
     * @param \ClickHouseDB\Statement $chStatement
     * @return self
     */
    public function setChStatement(\ClickHouseDB\Statement $chStatement)
    {
        $this->chStatement = $chStatement;

        $this->values = $chStatement->rows();

        return $this;
    }
}