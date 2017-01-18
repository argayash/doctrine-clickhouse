<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class ChTypeInt64
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeInt64 implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Int64';
    }

    /**
     * @param null $value
     * @return int
     * @throws \Exception
     */
    public function getFormatValue($value = null)
    {
        if (is_int($value)) {
            return (int)$value;
        } else {
            throw new \Exception('Type of value not is ' . $this->getName());
        }
    }
}