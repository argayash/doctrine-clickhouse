<?php
namespace InformikaDoctrineClickHouse\ChTypes;

/**
 * Class ChTypeDateTime
 * Дата-с-временем. Хранится в 4 байтах, в виде (беззнакового) unix timestamp.
 *
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeDateTime implements ChTypeInterface
{
    public function getTypeName(): string
    {
        return 'DateTime';
    }

    public function getFormatValue($value = null)
    {
        if ($value instanceof \DateTime) {
            $value = $value->getTimestamp();
        } else {
            throw new \Exception('Type of value not is correct ' . $this->getTypeName());
        }

        return (int)$value;
    }
}