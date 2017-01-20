<?php
namespace InformikaDoctrineClickHouse\Driver\DBAL\Platform;


use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ColumnDiff;
use Doctrine\DBAL\Schema\Constraint;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\Types\Type;

/**
 * Class ClickHousePlatform
 * @package InformikaDoctrineClickHouse\Driver\Platform
 */
class ClickHousePlatform extends AbstractPlatform
{
    public function getBooleanTypeDeclarationSQL(array $columnDef)
    {
        return 'UInt8';
    }

    public function getIntegerTypeDeclarationSQL(array $columnDef)
    {
        return 'Int32';
    }

    public function getBigIntTypeDeclarationSQL(array $columnDef)
    {
        return 'Int64';
    }

    public function getSmallIntTypeDeclarationSQL(array $columnDef)
    {
        return 'Int16';
    }

    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    protected function initializeDoctrineTypeMappings()
    {
        $this->doctrineTypeMapping = [
            'UInt8' => 'smallint',
            'UInt16' => 'integer',
            'UInt32' => 'integer',
            'UInt64' => 'bigint',
            'Int8' => 'smallint',
            'Int16' => 'integer',
            'Int32' => 'integer',
            'Int64' => 'bigint',
            'Float32' => 'decimal',
            'Float64' => 'float',
            'String' => 'text',
            'FixedString' => 'string',
            'Date' => 'integer',
            'DateTime' => 'integer',
            'Enum' => 'simple_array',
            'Array' => 'array',
        ];
    }

    public function getClobTypeDeclarationSQL(array $field)
    {
        return 'String';
    }

    public function getBlobTypeDeclarationSQL(array $field)
    {
        return 'String';
    }

    public function getName()
    {
        return 'click_house';
    }

    /**
     * {@inheritDoc}
     */
    public function supportsSequences()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getListDatabasesSQL()
    {
        return 'SELECT name FROM system.databases';
    }

    public function getVarcharTypeDeclarationSQL(array $field)
    {
        if (!isset($field['length'])) {
            $field['length'] = $this->getVarcharDefaultLength();
        }

        return $this->getVarcharTypeDeclarationSQLSnippet($field['length'], null);
    }

    public function getBinaryTypeDeclarationSQL(array $field)
    {
        return 'UInt8';
    }

    protected function getVarcharTypeDeclarationSQLSnippet($length, $fixed)
    {
        return 'FixedString(' . $length . ')';
    }

    public function getAnyExpression($column)
    {
        return 'any(' . $column . ')';
    }

    public function getAnyLastExpression($column)
    {
        return 'anyLast(' . $column . ')';
    }

    public function getAvgExpression($column)
    {
        return 'avg(' . $column . ')';
    }

    public function getUniqExpression($column)
    {
        return 'uniq(' . $column . ')';
    }

    public function getUniqCombinedExpression($column)
    {
        return 'uniqCombined(' . $column . ')';
    }

    public function getUniqHLL12Expression($column)
    {
        return 'uniqHLL12(' . $column . ')';
    }

    public function getUniqExact($column)
    {
        return 'uniqExact(' . $column . ')';
    }

    public function getCountExpression($column)
    {
        return 'count()';
    }

    public function getGroupArrayExpression($column)
    {
        return 'groupArray(' . $column . ')';
    }

    public function getGroupUniqArrayExpression($column)
    {
        return 'groupUniqArray(' . $column . ')';
    }

    public function getMaxExpression($column)
    {
        return 'max(' . $column . ')';
    }

    public function getMinExpression($column)
    {
        return 'min(' . $column . ')';
    }

    public function getSumExpression($column)
    {
        return 'sum(' . $column . ')';
    }

    public function getArgMin($arg = [], $val)
    {
        $arg[] = $val;
        return 'argMin(' . implode(', ', $arg) . ')';
    }

    public function getArgMax($arg = [], $val)
    {
        $arg[] = $val;
        return 'argMax(' . implode(', ', $arg) . ')';
    }

    public function getQuantileExpression($column, $level)
    {
        if ($level < 0 || $level > 1) {
            $level = 0;
        }
        return 'quantile(' . $level . ')(' . $column . ')';
    }

    public function getQuantileExactExpression($column, $level)
    {
        if ($level < 0 || $level > 1) {
            $level = 0;
        }
        return 'quantileExact(' . $level . ')(' . $column . ')';
    }

    public function getQuantileDeterministicExpression($column, $level, $determinator)
    {
        if ($level < 0 || $level > 1) {
            $level = 0;
        }
        return 'quantileDeterministic(' . $level . ')(' . $column . ', ' . $determinator . ')';
    }

    public function getQuantileTimingExpression($column, $level)
    {
        if ($level < 0 || $level > 1) {
            $level = 0;
        }
        return 'quantileTiming(' . $level . ')(' . $column . ')';
    }

    public function getQuantileTimingWeightedExpression($column, $level, $weight)
    {
        if ($level < 0 || $level > 1) {
            $level = 0;
        }
        return 'quantileTimingWeighted(' . $level . ')(' . $column . ', ' . $weight . ')';
    }

    public function getQuantileExactWeightedExpression($column, $level, $weight)
    {
        if ($level < 0 || $level > 1) {
            $level = 0;
        }
        return 'quantileExactWeighted(' . $level . ')(' . $column . ', ' . $weight . ')';
    }

    public function getQuantileTDigestExpression($column, $level)
    {
        if ($level < 0 || $level > 1) {
            $level = 0;
        }
        return 'quantileTDigest(' . $level . ')(' . $column . ')';
    }

    public function getQuantilesExpression($column, $levels = [])
    {
        $levels = array_map(function ($v) {
            return $v < 0 || $v > 1 ? 0 : $v;
        }, $levels);

        return 'quantiles(' . implode(', ', $levels) . ')(' . $column . ')';
    }

    public function getQuantilesExactExpression($column, $levels = [])
    {
        $levels = array_map(function ($v) {
            return $v < 0 || $v > 1 ? 0 : $v;
        }, $levels);

        return 'quantilesExact(' . implode(', ', $levels) . ')(' . $column . ')';
    }

    public function getQuantilesDeterministicExpression($column, $levels = [], $determinator)
    {
        $levels = array_map(function ($v) {
            return $v < 0 || $v > 1 ? 0 : $v;
        }, $levels);

        return 'quantilesDeterministic(' . implode(', ', $levels) . ')(' . $column . ', ' . $determinator . ')';
    }

    public function getQuantilesTimingExpression($column, $levels = [])
    {
        $levels = array_map(function ($v) {
            return $v < 0 || $v > 1 ? 0 : $v;
        }, $levels);

        return 'quantilesTiming(' . implode(', ', $levels) . ')(' . $column . ')';
    }

    public function getQuantilesTimingWeightedExpression($column, $levels = [], $weight)
    {
        $levels = array_map(function ($v) {
            return $v < 0 || $v > 1 ? 0 : $v;
        }, $levels);

        return 'quantilesTimingWeighted(' . implode(', ', $levels) . ')(' . $column . ', ' . $weight . ')';
    }

    public function getQuantilesExactWeightedExpression($column, $levels = [], $weight)
    {
        $levels = array_map(function ($v) {
            return $v < 0 || $v > 1 ? 0 : $v;
        }, $levels);

        return 'quantilesExactWeighted(' . implode(', ', $levels) . ')(' . $column . ', ' . $weight . ')';
    }

    public function getQuantilesTDigestExpression($column, $levels = [])
    {
        $levels = array_map(function ($v) {
            return $v < 0 || $v > 1 ? 0 : $v;
        }, $levels);

        return 'quantilesTDigest(' . implode(', ', $levels) . ')(' . $column . ')';
    }

    public function getMedianExpression($column, $level)
    {
        return $this->getQuantileExpression($column, $level);
    }

    public function getMedianExactExpression($column, $level)
    {
        return $this->getQuantileExactExpression($column, $level);
    }

    public function getMedianDeterministicExpression($column, $level, $determinator)
    {
        return $this->getQuantileDeterministicExpression($column, $level, $determinator);
    }

    public function getMedianTimingExpression($column, $level)
    {
        return $this->getQuantileTimingExpression($column, $level);
    }

    public function getMedianTimingWeightedExpression($column, $level, $weight)
    {
        return $this->getQuantileTimingWeightedExpression($column, $level, $weight);
    }

    public function getMedianExactWeightedExpression($column, $level, $weight)
    {
        return $this->getQuantileExactWeightedExpression($column, $level, $weight);
    }

    public function getMedianTDigestExpression($column, $level)
    {
        return $this->getQuantileTDigestExpression($column, $level);
    }

    public function getLengthExpression($column)
    {
        return 'length(' . $column . ')';
    }

    public function getSqrtExpression($column)
    {
        return 'sqrt(' . $column . ')';
    }

    public function getRoundExpression($column, $decimals = 0)
    {
        return 'round(' . $column . ', ' . $decimals . ')';
    }

    public function getModExpression($expression1, $expression2)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    public function getTrimExpression($str, $pos = self::TRIM_UNSPECIFIED, $char = false)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    public function getRtrimExpression($str)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    public function getLtrimExpression($str)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    public function getUpperExpression($str)
    {
        return 'upper(' . $str . ')';
    }

    public function getLowerExpression($str)
    {
        return 'lower(' . $str . ')';
    }

    public function getLocateExpression($str, $substr, $startPos = false)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    public function getNowExpression()
    {
        return 'now()';
    }
}