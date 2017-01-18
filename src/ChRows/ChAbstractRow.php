<?php

namespace InformikaDoctrineClickHouse\ChRows;


use InformikaDoctrineClickHouse\ChFields\ChAbstractField;
use InformikaDoctrineClickHouse\ChFields\ChBaseFiled;

/**
 * Class ChAbstractRow
 * @package InformikaDoctrineClickHouse\ChRows
 */
abstract class ChAbstractRow
{
    /** @var ChBaseFiled[] */
    private $fields = [];

    /**
     * @return array
     */
    public function getDataArray()
    {
        $data = [];
        /** @var ChAbstractField $field */
        foreach ($this->getFields() as $field) {
            $data[] = $field->getFormattedValue();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getColumnArray(){
        $columns = [];
        /** @var ChAbstractField $field */
        foreach ($this->getFields() as $field) {
            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @return ChBaseFiled[]
     */
    public function getFields()
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

    /**
     * @param ChAbstractField $field
     */
    public function addField(ChAbstractField $field){
        $this->fields[] = $field;
    }
}