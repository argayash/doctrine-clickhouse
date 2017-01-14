<?php
namespace InformikaDoctrineClickHouse\Mapping\Driver;

/**
 * This class provides method to load custom driver.
 */
interface DriverInterface
{
    /**
     * @param \ReflectionClass $class
     *
     * @return \InformikaDoctrineClickHouse\Mapping\ClassMetadata
     */
    public function loadMetadataForClass(\ReflectionClass $class);
}