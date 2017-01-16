<?php
namespace InformikaDoctrineClickHouse\ChTypes;

/**
 * Class ChTypeDate
 * Дата. Хранится в двух байтах в виде (беззнакового) числа дней, прошедших от 1970-01-01.
 *
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeDate implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'Date';
    }

    public function getFormatValue($value = null)
    {
        if ($value instanceof \DateTime) {
            $value = $value->getTimestamp() / 86400;
        } else {
            throw new \Exception('Type of value not is correct ' . $this->getTypeName());
        }

        return (int)$value;
    }
}