<?php
namespace InformikaDoctrineClickHouse\ChOperations;


use InformikaDoctrineClickHouse\ChRows\ChAbstractRow;
use InformikaDoctrineClickHouse\Driver\DBAL\Connection;

/**
 * Class ChInsertOperation
 * @package InformikaDoctrineClickHouse\ChOperations
 */
class ChInsertOperation extends ChAbstractOperation
{
    const OPERATION_NAME = 'insert';

    private $insertData = [];
    private $insertColumn = [];

    /**
     * ChInsertOperation constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::OPERATION_NAME;
    }

    /**
     * Prepare data for insert in to ClickHouse
     * @return $this;
     */
    public function prepare()
    {
        $this->insertData = [];
        $this->insertColumn = [];

        if ($chRows = $this->getRows()) {
            /** @var ChAbstractRow $row */
            foreach ($chRows as $row) {
                $this->insertData[] = $row->getDataArray();
            }
            /** @var ChAbstractRow $anyRow */
            $anyRow = current($chRows);
            $this->insertColumn = $anyRow->getColumnArray();
        }

        return $this;
    }

    /**
     * @return \InformikaDoctrineClickHouse\Driver\DBAL\Statement
     * @throws \Exception
     */
    public function execute()
    {
        $connection = $this->getConnection();
        if (!empty($this->insertData)) {
            return $connection->insert($this->getTable()->name, $this->insertData, $this->insertColumn);
        } else {
            throw new \Exception('Insert data is empty');
        }
    }
}