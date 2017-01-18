<?php
namespace InformikaDoctrineClickHouse\ChFields;


use InformikaDoctrineClickHouse\ChTypes\ChTypeInterface;
use InformikaDoctrineClickHouse\Mapping\Annotation\Column;

/**
 * Class ChAbstractField
 * @package InformikaDoctrineClickHouse\ChFields
 */
abstract class ChAbstractField
{
    protected $definedTypes = [];

    const TYPE_UINT8 = 'UInt8';
    const TYPE_UINT16 = 'UInt16';
    const TYPE_UINT32 = 'UInt32';
    const TYPE_UINT64 = 'UInt64';
    const TYPE_INT8 = 'Int8';
    const TYPE_INT16 = 'Int16';
    const TYPE_INT32 = 'Int32';
    const TYPE_INT64 = 'Int64';
    const TYPE_FLOAT32 = 'Float32';
    const TYPE_FLOAT64 = 'Float64';
    const TYPE_STRING = 'String';
    const TYPE_FIXED_STRING = 'FixedString';
    const TYPE_DATE = 'Date';
    const TYPE_DATE_TIME = 'DateTime';
    const TYPE_BOOLEAN = 'Boolean';

    /** @var  string */
    private $propertyName;
    /** @var  string */
    private $name;
    /** @var  string */
    private $type;
    /** @var  ChTypeInterface */
    private $chType;
    /** @var  int */
    private $length;
    /** @var  mixed */
    private $value;

    /**
     * ChAbstractField constructor.
     * @param Column $column
     * @param null $value
     */
    public function __construct(Column $column, $value = null)
    {
        $this->setDefinedTypes([
            self::TYPE_UINT8,
            self::TYPE_UINT16,
            self::TYPE_UINT32,
            self::TYPE_UINT64,
            self::TYPE_INT8,
            self::TYPE_INT16,
            self::TYPE_INT32,
            self::TYPE_INT64,
            self::TYPE_FLOAT32,
            self::TYPE_FLOAT64,
            self::TYPE_STRING,
            self::TYPE_FIXED_STRING,
            self::TYPE_DATE,
            self::TYPE_DATE_TIME,
            self::TYPE_BOOLEAN,
        ]);

        $this->setPropertyName($column->getPropertyName());
        $this->setName($column->name);
        $this->setType($column->type);
        if ($column->length) {
            $this->setLength($column->length);
        }
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType($type)
    {
        if (!in_array($type, $this->getDefinedTypes())) {
            throw new \Exception('Undefined ClickHouse type `' . $type . '`');
        }
        $chTypeClassName = '\InformikaDoctrineClickHouse\ChTypes\ChType' . $type;
        $this->setChType(new $chTypeClassName);
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @throws \Exception
     */
    public function setLength($length)
    {
        if ($length < 0) {
            throw new \Exception('Length value must be ');
        }
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return int|mixed
     * @throws \Exception
     */
    public function getFormattedValue()
    {
        return $this->getChType()->getFormatValue($this->getValue());
    }

    /**
     * @return array
     */
    public function getDefinedTypes()
    {
        return $this->definedTypes;
    }

    /**
     * @param array $definedTypes
     */
    public function setDefinedTypes(array $definedTypes)
    {
        $this->definedTypes = $definedTypes;
    }

    /**
     * @return ChTypeInterface
     */
    public function getChType()
    {
        return $this->chType;
    }

    /**
     * @param ChTypeInterface $chType
     */
    public function setChType(ChTypeInterface $chType)
    {
        $this->chType = $chType;
    }
}