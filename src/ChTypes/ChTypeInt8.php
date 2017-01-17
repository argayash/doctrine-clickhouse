<?php
namespace InformikaDoctrineClickHouse\ChTypes;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ChTypeInt8 extends Type implements ChTypeInterface
{
    public function getTypeName(): string
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