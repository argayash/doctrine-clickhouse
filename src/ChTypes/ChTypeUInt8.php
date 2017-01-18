<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class ChTypeUInt8
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeUInt8 implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'UInt8';
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