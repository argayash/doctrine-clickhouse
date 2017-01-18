<?php
namespace InformikaDoctrineClickHouse\Managers;


use InformikaDoctrineClickHouse\Driver\DBAL\Connection;

/**
 * Interface ClickHouseConnectionManagerInterface
 * @package InformikaDoctrineClickHouse\Managers
 */
interface ClickHouseConnectionManagerInterface
{
    /**
     * @return Connection
     */
    public function getConnection();
}