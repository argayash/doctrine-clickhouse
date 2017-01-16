<?php

namespace InformikaDoctrineClickHouse\ChTypes;

/**
 * Class ChTypeEnum8
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeEnum8 implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'Enum8';
    }

    public function getFormatValue($value = null)
    {
        return (string)$value;
    }
}