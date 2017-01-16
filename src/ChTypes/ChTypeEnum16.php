<?php

namespace InformikaDoctrineClickHouse\ChTypes;

/**
 * Class ChTypeEnum16
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeEnum16 implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'Enum16';
    }

    public function getFormatValue($value = null)
    {
        return (string)$value;
    }
}