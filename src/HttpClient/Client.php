<?php

namespace QiQiuYun\SDK\HttpClient;

use QiQiuYun\SDK\HttpClient\Psr7;
use QiQiuYun\SDK\HttpClient\ClientException;

class Client
{
    /**
     * Default request options
     *
     * @var array
     */
    private $config;

    public function __construct($config = array())
    {
        $defaults = array(
            'timeout' => 300,
        );
        $this->config = $config + $defaults;
    }

    public function request($method, $uri = '', array $options = [])
    {
        $options = $this->prepareDefaults($options);

        $headers = isset($options['headers']) ? $options['headers'] : [];
        $body = isset($options['body']) ? $options['body'] : null;
        if (isset($options['json'])) {
            $body = json_encode($options['json']);
            $headers['Content-Type'] = 'application/json';
        }

        $uri = $this->buildUri($uri, $options);

        $options = [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $this->compileRequestHeaders($headers),
            CURLOPT_URL => (string) $uri,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => $options['timeout'],
            CURLOPT_RETURNTRANSFER => true, // Follow 301 redirects
            CURLOPT_HEADER => true, // Enable header processing
        ];

        if ($method !== 'GET') {
            $options[CURLOPT_POSTFIELDS] = $body;
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $rawResponse = curl_exec($curl);

        $errorCode = curl_errno($curl);
        if ($errorCode) {
            throw new ClientException(\curl_error($curl), $errorCode);
        }

        curl_close($curl);

        list($rawHeaders, $rawBody) = $this->extractResponseHeadersAndBody($rawResponse);

        return new Response($rawHeaders, $rawBody);
    }

        /**
     * Merges default options into the array.
     *
     * @param array $options Options to modify by reference
     *
     * @return array
     */
    private function prepareDefaults($options)
    {
        $defaults = $this->config;

        if (array_key_exists('headers', $options)) {
            if ($options['headers'] === null) {
                unset($options['headers']);
            } elseif (!is_array($options['headers'])) {
                throw new \InvalidArgumentException('headers must be an array');
            }
        }

        // Shallow merge defaults underneath options.
        $result = $options + $defaults;

        // Remove null values.
        foreach ($result as $k => $v) {
            if ($v === null) {
                unset($result[$k]);
            }
        }

        return $result;
    }

    private function buildUri($uri, array $config)
    {
        // for BC we accept null which would otherwise fail in uri_for
        $uri = Psr7\uri_for($uri === null ? '' : $uri);

        if (isset($config['base_uri'])) {
            $uri = Psr7\UriResolver::resolve(Psr7\uri_for($config['base_uri']), $uri);
        }

        return $uri->getScheme() === '' && $uri->getHost() !== '' ? $uri->withScheme('http') : $uri;
    }

    public function compileRequestHeaders(array $headers)
    {
        $return = [];

        foreach ($headers as $key => $value) {
            $return[] = $key . ': ' . $value;
        }

        return $return;
    }

    public function extractResponseHeadersAndBody($rawResponse)
    {
        $parts = explode("\r\n\r\n", $rawResponse);
        $rawBody = array_pop($parts);
        $rawHeaders = implode("\r\n\r\n", $parts);

        return array(trim($rawHeaders), trim($rawBody));
    }
}