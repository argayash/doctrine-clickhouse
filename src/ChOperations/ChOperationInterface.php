<?php

namespace InformikaDoctrineClickHouse\ChOperations;

/**
 * Interface ChOperationInterface
 * @package InformikaDoctrineClickHouse\ChOperations
 */
interface ChOperationInterface
{
    /**
     * Get operation name
     * @return string
     */
    public function getName(): string;

    /**
     * @return ChOperationInterface
     */
    public function prepare();

    public function execute();
}