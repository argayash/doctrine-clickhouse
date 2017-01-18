<?php
namespace InformikaDoctrineClickHouse\Driver;


use InformikaDoctrineClickHouse\Driver\DBAL\Connection;
use Doctrine\DBAL\Driver;
use InformikaDoctrineClickHouse\Driver\DBAL\Platform\ClickHousePlatform;

/**
 * Class ClickHouseDriver
 * @package InformikaDoctrineClickHouse\Driver\
 */
class ClickHouseDriver implements Driver
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param array $params
     * @param null $username
     * @param null $password
     * @param array $driverOptions
     * @return Connection
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        if (!empty($this->connection)) return $this->connection;

        if (isset($params['dbname'])) {
            $params['database'] = $params['dbname'];
        }

        $this->setConnection(new Connection($params, $username, $password, $driverOptions));

        return $this->getConnection();
    }

    /**
     * @return ClickHousePlatform
     */
    public function getDatabasePlatform()
    {
        return new ClickHousePlatform();
    }

    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'clickhouse';
    }

    /**
     * @param \Doctrine\DBAL\Connection $conn
     * @return string
     */
    public function getDatabase(\Doctrine\DBAL\Connection $conn)
    {
        $connectionParams = $conn->getParams();

        return isset($connectionParams['database']) ? $connectionParams['database'] : 'default';
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