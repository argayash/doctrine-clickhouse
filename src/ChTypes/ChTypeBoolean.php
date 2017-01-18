<?php
namespace InformikaDoctrineClickHouse\ChTypes;


/**
 * Class ChTypeBoolean
 * Отдельного типа для булевых значений нет. Для них используется тип UInt8, в котором используются только значения 0 и 1.
 *
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeBoolean implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Boolean';
    }

    /**
     * @param null $value
     * @return int
     */
    public function getFormatValue($value = null)
    {
        return (int)$value;
    }
}