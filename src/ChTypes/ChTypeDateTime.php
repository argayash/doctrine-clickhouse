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
    /**
     * @return string
     */
    public function getName()
    {
        return 'DateTime';
    }

    /**
     * @param null $value
     * @return int
     * @throws \Exception
     */
    public function getFormatValue($value = null)
    {
        if ($value instanceof \DateTime) {
            $value = $value->getTimestamp();
        } else {
            throw new \Exception('Type of value not is correct ' . $this->getName());
        }

        return (int)$value;
    }
}