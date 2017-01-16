<?php
namespace InformikaDoctrineClickHouse\ChTypes;


interface ChTypeInterface
{
    /** Get CH name of type
     *
     * @return string
     */
    public function getTypeName(): string;

    /**
     * Get formatted CH Value
     *
     * @param mixed $value
     * @return mixed
     */
    public function getFormatValue($value = null);
}