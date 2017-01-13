<?php

namespace InformikaClickHouse\Mapping;

use InformikaClickHouse\Mapping\Annotation\Table;

/**
 * This class contains entity class metadata.
 */
class ClassMetadata
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @var \InformikaClickHouse\Mapping\Annotation\Column[]
     */
    private $columns = [];

    /**
     * @param Table $table
     * @param array $columns
     */
    public function __construct(Table $table, array $columns = [])
    {
        $this->table = $table;
        $this->columns = $columns;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return \InformikaClickHouse\Mapping\Annotation\Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }
}