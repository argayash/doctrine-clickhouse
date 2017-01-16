<?php
namespace InformikaDoctrineClickHouse\ChTypes;


class ChTypeUInt8 implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'UInt8';
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