<?php
namespace InformikaDoctrineClickHouse\Driver;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Schema\MySqlSchemaManager;

class ClickHouseDriver implements Driver
{
    /**
     * @var Connection
     */
    private $connection;

    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        if (!empty($this->connection)) return $this->connection;
        $config = new Configuration();

        $this->connection = new Connection($params, $this, $config);
        return $this->connection;
    }

    public function getDatabasePlatform()
    {
        return new MySqlPlatform();
    }

    public function getSchemaManager(Connection $conn)
    {
        return new MySqlSchemaManager($conn);
    }

    public function getName()
    {
        return 'clickhouse';
    }

    public function getDatabase(Connection $conn)
    {
        $connectionParams = $conn->getParams();

        return isset($connectionParams['database']) ? $connectionParams['database'] : 'default';
    }

}