<?php
namespace InformikaDoctrineClickHouse\Mapping;

use InformikaDoctrineClickHouse\Mapping\Driver\DriverInterface;

/**
 * This class provides method to load entity class metadata.
 */
class ClassMetadataFactory
{
    /**
     * @var array
     */
    private $loaded = [];

    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param string $className
     * @return ClassMetadata|null
     */
    public function loadMetadata(string $className)
    {
        $classMetadata = null;

        if (!class_exists($className)) {
            throw new \RuntimeException(sprintf('Class "%s" does not exists.', $className));
        }

        if (!array_key_exists($className, $this->loaded)) {
            if ($classMetadata = $this->driver->loadMetadataForClass(new \ReflectionClass($className))) {
                return $this->loaded[$className] = $classMetadata;
            }
        }

        return isset($this->loaded[$className]) ? $this->loaded[$className] : null;
    }
}