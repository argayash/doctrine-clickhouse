<?php
namespace InformikaDoctrineClickHouse\ChTypes;


class Int16 implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'ChTypeInt16';
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