<?php

namespace QiQiuYun\SDK\Service;

use QiQiuYun\SDK\Auth;
use QiQiuYun\SDK\HttpClient\Client;
use Psr\Log\LoggerInterface;
use QiQiuYun\SDK\HttpClient\ClientInterface;

abstract class BaseService
{
    /**
     * QiQiuYun auth
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Service options
     *
     * @var array
     */
    protected $options;

    /**
     * Http client
     *
     * @var Client
     */
    protected $client;

    /**
     * API base uri
     *
     * @var string
     */
    protected $baseUri = '';

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(Auth $auth, array $options = array(), LoggerInterface $logger = null, ClientInterface $client = null)
    {
        $this->auth = $auth;
        $this->options = $options;
        $this->logger = $logger;
        $this->client = $client;
    }

    protected function createClient()
    {
        if ($this->client) {
            return $this->client;
        }

        if (!empty($this->options['base_uri'])) {
            $this->baseUri = $this->options['base_uri'];
        }

        $this->client = new Client(array(
            'base_uri' => $this->baseUri,
        ), $this->logger);

        return $this->client;
    }
}
