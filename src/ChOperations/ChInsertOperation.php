<?php
namespace InformikaDoctrineClickHouse\ChOperations;


use ClickHouseDB\Client;

/**
 * Class ChInsertOperation
 * @package InformikaDoctrineClickHouse\ChOperations
 */
class ChInsertOperation extends ChAbstractOperation
{
    const OPERATION_NAME = 'insert';

    /**
     * ChInsertOperation constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->setName(self::OPERATION_NAME);
    }

    public function prepare()
    {
        // TODO: Implement prepare() method.
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }
}