<?php
namespace InformikaDoctrineClickHouse\ChTypes;


class ChTypeInt32 implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'Int32';
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