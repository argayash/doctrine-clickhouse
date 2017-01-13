<?php

namespace InformikaClickHouse\Mapping\Driver;

use Doctrine\Common\Annotations\Reader;
use InformikaClickHouse\Exception\AnnotationReaderException;
use InformikaClickHouse\Mapping\ClassMetadata;
use InformikaClickHouse\Mapping\Annotation\Table;
use InformikaClickHouse\Mapping\Annotation\Column;

/**
 * This class provides method to load metadata from class annotations.
 */
class AnnotationDriver implements DriverInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param \ReflectionClass $class
     * @return ClassMetadata
     * @throws AnnotationReaderException|null
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $tableMetadata = $this->reader->getClassAnnotation($class, Table::class);

        $columnsMetadata = [];

        foreach ($class->getProperties() as $property) {
            /** @var Column $fieldMetadata */
            if (!is_null($fieldMetadata = $this->reader->getPropertyAnnotation($property, Column::class))) {
                $fieldMetadata->setProperty($property->getName());
                $columnsMetadata[] = $fieldMetadata;
            }
        }

        if (!empty($columnsMetadata) && null === $tableMetadata) {
            throw new AnnotationReaderException('Class \'' . $class->name . '\' not have `table` annotation');
        }

        return $tableMetadata ? new ClassMetadata($tableMetadata, $columnsMetadata) : null;
    }
}