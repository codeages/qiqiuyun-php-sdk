<?php

namespace QiQiuYun\SDK;

use Psr\Log\LoggerInterface;
use QiQiuYun\SDK\HttpClient\ClientInterface;
use QiQiuYun\SDK\Exception\SDKException;

class QiQiuYunSDK
{
    protected $options;

    protected $services = array();

    protected $auth;

    protected $logger;

    protected $httpClient;

    /**
     * QiQiuYunSDK constructor.
     *
     * @param array $options
     * @param LoggerInterface|null $logger
     * @param ClientInterface|null $httpClient
     * @throws SDKException
     */
    public function __construct(array $options, LoggerInterface $logger = null, ClientInterface $httpClient = null)
    {
        if (empty($options['access_key'])) {
            throw new SDKException('`access_key` param is missing.');
        }
        if (empty($options['secret_key'])) {
            throw new SDKException('`secret_key` param is missing.');
        }

        $this->options = $options;
        $this->logger = $logger;
        $this->httpClient = $httpClient;
    }

    /**
     * 获取云资源播放服务
     *
     * @return \QiQiuYun\SDK\Service\ResourceService
     */
    public function getResourceService()
    {
        return $this->getService('Resource', true);
    }

    /**
     * 获取短信服务
     *
     * @return \QiQiuYun\SDK\Service\SmsService
     */
    public function getSmsService()
    {
        return $this->getService('Sms');
    }

    /**
     * 获取云资源播放服务
     *
     * @return \QiQiuYun\SDK\Service\PlayService
     */
    public function getPlayService()
    {
        return $this->getService('Play');
    }

    /**
     * 获取XAPI服务
     *
     * @return \QiQiuYun\SDK\Service\XAPIService
     */
    public function getXAPIService()
    {
        return $this->getService('XAPI');
    }

    /**
     * 获取分销服务
     *
     * @return \QiQiuYun\SDK\Service\DrpService
     */
    public function getDrpService()
    {
        return $this->getService('Drp');
    }

    /**
     * @return \QiQiuYun\SDK\Service\MpService
     */
    public function getMpService()
    {
        return $this->getService('Mp');
    }

    /**
     * @return \QiQiuYun\SDK\Service\ESopService
     */
    public function getESopService()
    {
        return $this->getService('ESop');
    }

    /**
     * @return \QiQiuYun\SDK\Service\AiService
     */
    public function getAiService()
    {
        return $this->getService('Ai');
    }

    /**
     * @return \QiQiuYun\SDK\Service\PushService
     */
    public function getPushService()
    {
        return $this->getService('Push');
    }

    /**
     * @return \QiQiuYun\SDK\Service\NotificationService
     */
    public function getNotificationService()
    {
        return $this->getService('Notification');
    }

    /**
     * @return \QiQiuYun\SDK\Service\WeChatService
     */
    public function getWeChatService()
    {
        return $this->getService('WeChat');
    }

    /**
     * @return \QiQiuYun\SDK\Service\S2B2CService
     */
    public function getS2B2CService()
    {
        return $this->getService('S2B2C');
    }

    /**
     * 根据服务名获得服务实例
     *
     * @param string $name 服务名
     *
     * @return mixed 服务实例
     */
    protected function getService($name, $useJwt = false)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }

        $lowerName = strtolower($name);
        $options = empty($this->options['service'][$lowerName]) ? array() : $this->options['service'][$lowerName];

        $class = __NAMESPACE__.'\\Service\\'.$name.'Service';
        $auth = new Auth($this->options['access_key'], $this->options['secret_key'],  $useJwt);
        $this->services[$name] = new $class($auth, $options, $this->logger, $this->httpClient);

        return $this->services[$name];
    }
}
