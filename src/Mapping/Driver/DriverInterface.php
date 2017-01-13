<?php

namespace InformikaClickHouse\Mapping\Driver;

/**
 * This class provides method to load custom driver.
 */
interface DriverInterface
{
    /**
     * @param \ReflectionClass $class
     *
     * @return \InformikaClickHouse\Mapping\ClassMetadata
     */
    public function loadMetadataForClass(\ReflectionClass $class);
}