<?php
namespace InformikaDoctrineClickHouse\Driver;


use InformikaDoctrineClickHouse\Driver\DBAL\Connection;
use Doctrine\DBAL\Driver;
use InformikaDoctrineClickHouse\Driver\DBAL\Platform\ClickHousePlatform;
use InformikaDoctrineClickHouse\Driver\DBAL\Schema\ClickHouseSchemaManager;

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
     * @var  ClickHousePlatform
     */
    private $platform;
    /**
     * @var  ClickHouseSchemaManager
     */
    private $schema;

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
        if (!$this->getPlatform()) {
            $this->setPlatform(new ClickHousePlatform());
        }

        return $this->getPlatform();
    }

    /**
     * @param \Doctrine\DBAL\Connection $conn
     * @return ClickHouseSchemaManager
     */
    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {
        if (!$this->getSchema()) {
            $this->setSchema(new ClickHouseSchemaManager($conn, $this->getDatabasePlatform()));
        }

        return $this->getSchema();
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

    /**
     * @return ClickHousePlatform
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param ClickHousePlatform $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return ClickHouseSchemaManager
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param ClickHouseSchemaManager $schema
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
    }
}