<?php
namespace InformikaDoctrineClickHouse\Managers;


use InformikaDoctrineClickHouse\Driver\DBAL\Connection;

/**
 * Class ClickHouseBaseConnectionManager
 * @package InformikaDoctrineClickHouse\Managers
 */
class ClickHouseBaseConnectionManager implements ClickHouseConnectionManagerInterface
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $database;
    /**
     * @var array
     */
    private $params = [];

    /**
     * @var Connection
     */
    private $connection;

    /**
     * ClickHouseBaseConnectionManager constructor.
     * @param $host
     * @param $port
     * @param $username
     * @param $password
     * @param $database
     * @param array $params
     */
    public function __construct($host, $port, $username, $password, $database, $params = [])
    {
        $this->setHost($host);
        $this->setPort($port);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setDatabase($database);
        $this->setParams($params);

        $this->setParams(array_merge($this->getParams(), [
            'host' => $host,
            'port' => $port,
            'username' => $username,
            'password' => $password,
            'database' => $database,
        ]));

        $this->createNewConnection();
    }

    /**
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return $this
     */
    public function createNewConnection()
    {
        $this->setConnection(new Connection($this->getParams(), $this->getUsername(), $this->getPassword()));

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param string $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}