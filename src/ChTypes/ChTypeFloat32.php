<?php
namespace InformikaDoctrineClickHouse\ChTypes;


class ChTypeFloat32 implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'Float32';
    }

    public function getFormatValue($value = null)
    {
        if (is_float($value)) {
            return (float)$value;
        } else {
            throw new \Exception('Type of value not is ' . $this->getTypeName());
        }
    }
}