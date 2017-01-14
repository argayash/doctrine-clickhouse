<?php
namespace InformikaDoctrineClickHouse\ChFields;


use InformikaDoctrineClickHouse\Mapping\Annotation\Column;

/**
 * Class ChBaseFiled
 * @package InformikaDoctrineClickHouse\ChFields
 */
class ChBaseFiled extends ChAbstractField
{
    /**
     * ChBaseFiled constructor.
     * @param Column $column
     * @param null $value
     */
    public function __construct(Column $column, $value = null)
    {
        parent::__construct($column, $value);
    }
}