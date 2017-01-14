<?php
namespace InformikaDoctrineClickHouse\ChRows;


use InformikaDoctrineClickHouse\ChFields\ChBaseFiled;

class ChBaseRow
{
    /** @var ChBaseFiled[] */
    private $fields = [];

    /**
     * @return array
     */
    public function getDataArray()
    {
        $data = [];
        /** @var ChBaseFiled $field */
        foreach ($this->getFields() as $field) {
            $data[] = $field->getValue();
        }

        return $data;
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