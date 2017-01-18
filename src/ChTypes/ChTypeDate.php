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
    /**
     * @return string
     */
    public function getName()
    {
        return 'Date';
    }

    /**
     * @param null $value
     * @return int
     * @throws \Exception
     */
    public function getFormatValue($value = null)
    {
        if ($value instanceof \DateTime) {
            $value = $value->getTimestamp() / 86400;
        } else {
            throw new \Exception('Type of value not is correct ' . $this->getName());
        }

        return (int)$value;
    }
}