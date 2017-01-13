<?php
namespace InformikaClickHouse\ChRows;

use InformikaClickHouse\ChFields\ChBaseFiled;

class ChBaseRow
{
    /** @var ChBaseFiled[] */
    private $fields = [];

    public function getDataArray()
    {

    }

    /**
     * @return ChBaseFiled[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param ChBaseFiled[] $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }
}