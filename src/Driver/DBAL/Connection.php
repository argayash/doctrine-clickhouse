<?php
namespace InformikaDoctrineClickHouse\Driver\DBAL;


use ClickHouseDB\Client;
use Doctrine\DBAL\ConnectionException;

/**
 * Class Connection
 * @package InformikaDoctrineClickHouse\Driver\DBAL
 */
class Connection implements \Doctrine\DBAL\Driver\Connection
{
    /**
     * @var  Client
     */
    private $client;
    /**
     * @var  array
     */
    protected $config;
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var array
     */
    private $params;
    /**
     * @var int
     */
    private $errorCode;
    /**
     * @var string
     */
    private $errorInfo;

    /**
     * Connection constructor.
     * @param array $params
     * @param $username
     * @param $password
     * @param array $driverOptions
     */
    public function __construct(array $params, $username, $password, array $driverOptions = [])
    {
        $this->setHost(isset($params['host']) ? $params['host'] : null);
        $this->setPort(isset($params['port']) ? (int)$params['port'] : 0);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setParams([
            'database' => isset($params['database']) ? $params['database'] : null,
        ]);

        $config = [
            'host' => $this->getHost(),
            'port' => $this->getPort(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'settings' => $this->getParams(),
        ];

        $this->setConfig($config);

        $this->setClient(new Client($this->getConfig()));
    }

    /**
     * @param string $prepareString
     * @return Statement
     */
    public function prepare($prepareString)
    {
        return new Statement($this->getClient(), $prepareString);
    }

    /**
     * @return Statement
     */
    public function query()
    {
        $args = func_get_args();
        $sql = $args[0];
        $stmt = $this->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    /**
     * @param string $input
     * @param int $type
     * @return string
     */
    public function quote($input, $type = \PDO::PARAM_STR)
    {
        return "'" . addslashes($input) . "'";
    }

    /**
     * @param string $statement
     * @return int
     */
    public function exec($statement)
    {
        $stmt = $this->query($statement);
        if (false === $stmt->execute()) {
            throw new \RuntimeException("Unable to execute query '{$statement}'");
        }
        return $stmt->rowCount();
    }

    /**
     * @param string $sql
     * @param array $bindings
     * @param null $whereInFile
     * @param null $writeToFile
     * @return Statement
     */
    public function select($sql, $bindings = [], $whereInFile = null, $writeToFile = null)
    {
        $selectStmt = $this->getClient()->select($sql, $bindings, $whereInFile, $writeToFile);
        $stmt = $this->query($selectStmt->sql());
        $stmt->setChStatement($selectStmt);

        return $stmt;
    }

    /**
     * @param string $table
     * @param array $values
     * @param array $columns
     * @return Statement
     */
    public function insert($table, $values, $columns = [])
    {
        $insertStmt = $this->getClient()->insert($table, $values, $columns);
        $stmt = $this->query($insertStmt->sql());
        $stmt->setChStatement($insertStmt);

        return $stmt;
    }

    public function lastInsertId($name = null)
    {
        throw new \RuntimeException("Unable to get last insert id in ClickHouse");
    }

    public function beginTransaction()
    {
        throw new \RuntimeException("Transactions are not allowed in ClickHouse");
    }

    public function commit()
    {
        throw new \RuntimeException("Transactions are not allowed in ClickHouse");
    }

    public function rollBack()
    {
        throw new \RuntimeException("Transactions are not allowed in ClickHouse");
    }

    /**
     * @return int
     */
    public function errorCode()
    {
        return $this->getErrorCode();
    }

    /**
     * @return string
     */
    public function errorInfo()
    {
        return $this->getErrorInfo();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param $host
     * @return self
     * @throws ConnectionException
     */
    public function setHost($host)
    {
        if (!is_null($host)) {
            $this->host = $host;
        } else {
            throw new ConnectionException('Parameter \'host\' must be not empty. Example: 127.0.0.1');
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return self
     * @throws ConnectionException
     */
    public function setPort($port)
    {
        if ($port > 0) {
            $this->port = $port;
        } else {
            throw new ConnectionException('Parameter \'port\' must be not empty. Example: 8123');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return self
     * @throws ConnectionException
     */
    public function setUsername($username)
    {
        if (!$username) {
            throw new ConnectionException('Username must be not empty');
        }

        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return self
     * @throws ConnectionException
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return self
     * @param array $params
     */
    public function setParams(array $params = [])
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     * @return self
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorInfo()
    {
        return $this->errorInfo;
    }

    /**
     * @param string $errorInfo
     * @return self
     */
    public function setErrorInfo($errorInfo)
    {
        $this->errorInfo = $errorInfo;

        return $this;
    }
}