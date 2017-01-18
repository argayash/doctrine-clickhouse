<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class Int16
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class Int16 implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'ChTypeInt16';
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