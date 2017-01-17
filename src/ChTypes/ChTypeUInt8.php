<?php
namespace InformikaDoctrineClickHouse\ChTypes;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class ChTypeUInt8
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeUInt8 extends Type implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'UInt8';
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getSmallIntTypeDeclarationSQL($fieldDeclaration);
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