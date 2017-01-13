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
    private $property;

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param string $property
     */
    public function setProperty(string $property)
    {
        $this->property = $property;
    }
}