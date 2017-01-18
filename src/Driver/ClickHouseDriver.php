<?php
namespace InformikaDoctrineClickHouse\Driver;


use InformikaDoctrineClickHouse\Driver\DBAL\Connection;
use Doctrine\DBAL\Driver;
use InformikaDoctrineClickHouse\Driver\DBAL\Platform\ClickHousePlatform;

class ClickHouseDriver implements Driver
{
    /**
     * @var Connection
     */
    private $connection;

    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        if (!empty($this->connection)) return $this->connection;

        $this->connection = new Connection($params, $username, $password, $driverOptions);
        return $this->connection;
    }

    public function getDatabasePlatform()
    {
        return new ClickHousePlatform();
    }

    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {

    }

    public function getName()
    {
        return 'clickhouse';
    }

    public function getDatabase(\Doctrine\DBAL\Connection $conn)
    {
        $connectionParams = $conn->getParams();

        return isset($connectionParams['database']) ? $connectionParams['database'] : 'default';
    }

}