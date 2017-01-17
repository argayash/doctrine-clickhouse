<?php
namespace InformikaDoctrineClickHouse\ChTypes;


interface ChTypeInterface
{
    /**
     * Get formatted CH Value
     *
     * @param mixed $value
     * @return mixed
     */
    public function getFormatValue($value = null);
}