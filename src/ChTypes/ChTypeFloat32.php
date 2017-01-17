<?php
namespace InformikaDoctrineClickHouse\ChTypes;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class ChTypeFloat32
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeFloat32 extends Type implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Float32';
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getFloatDeclarationSQL($fieldDeclaration);
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