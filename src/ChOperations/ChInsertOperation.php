<?php
namespace InformikaDoctrineClickHouse\ChOperations;


use ClickHouseDB\Client;
use InformikaDoctrineClickHouse\ChRows\ChAbstractRow;

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
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * @return string
     */
    public function getName(): string
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
     * @return \ClickHouseDB\Statement
     * @throws \Exception
     */
    public function execute()
    {
        $chClient = $this->getChClient();
        if (!empty($this->insertData)) {
            return $chClient->insert($this->getTable()->name, $this->insertData, $this->insertColumn);
        } else {
            throw new \Exception('Insert data is empty');
        }
    }
}