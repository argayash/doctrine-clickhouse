<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class ChTypeInt32
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeInt32 implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Int32';
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