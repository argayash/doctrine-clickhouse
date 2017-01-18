<?php
namespace InformikaDoctrineClickHouse\Managers;


use ClickHouseDB\Client;

/**
 * Class ClickHouseClientManager
 * @package InformikaClickHouse\Managers
 */
class ClickHouseClientManager
{
    /** @var  array */
    protected $config = [];
    /** @var  Client */
    protected $client;

    /**
     * ClickHouseClientManager constructor.
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param array $settings
     */
    public function __construct($host = '127.0.0.1', $port = 8123, $username = 'default', $password = '', array $settings = [])
    {
        $config = [
            'host' => $host,
            'port' => $port,
            'username' => $username,
            'password' => $password,
            'settings' => $settings,
        ];

        $this->setConfig($config);
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
     * @return Client
     */
    public function getClient()
    {
        $this->client = new Client($this->getConfig());

        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}