<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class ChTypeString
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeString implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'String';
    }

    /**
     * @param null $value
     * @return string
     * @throws \Exception
     */
    public function getFormatValue($value = null)
    {
        if (is_string($value)) {
            return (string)$value;
        } else {
            throw new \Exception('Type of value not is ' . $this->getName());
        }
    }
}