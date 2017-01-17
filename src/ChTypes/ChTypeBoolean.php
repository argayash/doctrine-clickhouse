<?php
namespace InformikaDoctrineClickHouse\ChTypes;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class ChTypeBoolean
 * Отдельного типа для булевых значений нет. Для них используется тип UInt8, в котором используются только значения 0 и 1.
 *
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeBoolean extends Type implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Boolean';
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getBooleanTypeDeclarationSQL($fieldDeclaration);
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