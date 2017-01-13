<?php

namespace InformikaClickHouse\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * This class contains database table metadata.
 *
 * @Annotation
 * @Target("CLASS")
 */

class Table
{
    /**
     * @var string
     */
    public $name;
}