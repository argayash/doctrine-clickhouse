<?php

namespace InformikaClickHouse\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * This class contains table column metadata.
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class Column
{
    /**
     * Column name.
     *
     * @var string
     */
    public $name;

    /**
     * Column type.
     *
     * @var string
     */
    public $type;

    /**
     * Type length. Only for FixedString type.
     *
     * @var int
     */
    public $length;

    /** @var  string */
    private $propertyName;

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     */
    public function setPropertyName(string $propertyName)
    {
        $this->propertyName = $propertyName;
    }
}