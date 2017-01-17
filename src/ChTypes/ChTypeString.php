<?php
namespace InformikaDoctrineClickHouse\ChTypes;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class ChTypeString
 * @package InformikaDoctrineClickHouse\ChTypes
 */
class ChTypeString extends Type implements ChTypeInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'String';
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
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