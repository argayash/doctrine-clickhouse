<?php
namespace InformikaClickHouse\Driver;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

class ClickHouseDriver implements Driver
{
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {

    }

    public function getDatabasePlatform()
    {
        // TODO: Implement getDatabasePlatform() method.
    }

    public function getSchemaManager(Connection $conn)
    {
        // TODO: Implement getSchemaManager() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function getDatabase(Connection $conn)
    {
        // TODO: Implement getDatabase() method.
    }

}