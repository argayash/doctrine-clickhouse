<?php
namespace InformikaDoctrineClickHouse\ChFields;


use InformikaDoctrineClickHouse\Mapping\Annotation\Column;

/**
 * Class ChAbstractField
 * @package InformikaDoctrineClickHouse\ChFields
 */
abstract class ChAbstractField
{
    protected $definedTypes = [
        'UInt8', 'UInt16', 'UInt32', 'UInt64', 'Int8', 'Int16', 'Int32', 'Int64',
        'Float32', 'Float64',
        'String', 'FixedString',
        'Date', 'DateTime',
        'Enum8', 'Enum16',
    ];

    /** @var  string */
    private $propertyName;
    /** @var  string */
    private $name;
    /** @var  string */
    private $type;
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
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     */
    public function setPropertyName(string $propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType(string $type)
    {
        if (!in_array($type, $this->getDefinedTypes())) {
            throw new \Exception('Undefined ClickHouse type `' . $type . '`');
        }
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
    public function setLength(int $length)
    {
        if($length<0){
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
     * @return mixed
     */
    public function getFormattedValue()
    {
        return $this->getValue();
    }

    /**
     * @return array
     */
    public function getDefinedTypes(): array
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
}