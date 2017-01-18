<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class ChTypeFloat32
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeFloat32 implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Float32';
    }

    /**
     * @param null $value
     * @return float
     * @throws \Exception
     */
    public function getFormatValue($value = null)
    {
        if (is_float($value)) {
            return (float)$value;
        } else {
            throw new \Exception('Type of value not is ' . $this->getName());
        }
    }
}