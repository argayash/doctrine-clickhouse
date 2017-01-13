<?php
namespace InformikaClickHouse\ChOperations;


use ClickHouseDB\Client;

class ChInsertOperation extends ChAbstractOperation
{
    const OPERATION_NAME = 'insert';

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