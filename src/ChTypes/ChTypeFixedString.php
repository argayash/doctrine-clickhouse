<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class ChTypeFixedString
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeFixedString implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'FixedString';
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