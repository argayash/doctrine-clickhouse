<?php
namespace InformikaDoctrineClickHouse\ChTypes;


class ChTypeFixedString implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'FixedString';
    }

    public function getFormatValue($value = null)
    {
        if (is_string($value)) {
            return (string)$value;
        } else {
            throw new \Exception('Type of value not is ' . $this->getTypeName());
        }
    }
}