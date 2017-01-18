<?php
namespace InformikaDoctrineClickHouse\Driver\DBAL\Platform;


use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class ClickHousePlatform
 * @package InformikaDoctrineClickHouse\Driver\Platform
 */
class ClickHousePlatform extends AbstractPlatform
{
    public function getBooleanTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    public function getIntegerTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    public function getBigIntTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    public function getSmallIntTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    protected function initializeDoctrineTypeMappings()
    {
        return '';
    }

    public function getClobTypeDeclarationSQL(array $field)
    {
        return '';
    }

    public function getBlobTypeDeclarationSQL(array $field)
    {
        return '';
    }

    public function getName()
    {
        return 'click_house';
    }
}