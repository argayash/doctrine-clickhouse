<?php
namespace InformikaDoctrineClickHouse\ChTypes;

/**
 * Class ChTypeInt8
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeInt8 implements ChTypeInterface
{
    public function getTypeName()
    {
        return 'Int8';
    }

    public function getFormatValue($value = null)
    {
        if (is_int($value)) {
            return (int)$value;
        } else {
            throw new \Exception('Type of value not is ' . $this->getTypeName());
        }
    }
}