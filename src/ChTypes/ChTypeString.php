<?php
namespace InformikaDoctrineClickHouse\ChTypes;


class ChTypeString implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'String';
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