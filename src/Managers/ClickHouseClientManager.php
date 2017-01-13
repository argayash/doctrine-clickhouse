<?php
namespace InformikaClickHouse\Managers;

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
    public function __construct(string $host = '127.0.0.1', int $port = 8123, string $username = 'default', string $password = '', array $settings = [])
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
    public function getConfig(): array
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
    public function getClient(): Client
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