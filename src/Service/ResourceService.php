<?php

namespace QiQiuYun\SDK\Service;

use QiQiuYun\SDK\Exception\SDKException;
use QiQiuYun\SDK;

class ResourceService
{
    const BASE_API_URL = 'http://api.edusoho.net';

    const JS_SDK_HOST = 'service-cdn.qiqiuyun.net';

    protected $accessKey;

    protected $secretKey;

    public function __construct(array $config = array())
    {
        $config = array_merge(array(
            'access_key' => '',
            'secret_key' => '',
        ), $config);

        if (!$config['access_key']) {
            throw new SDKException('Required "access_key" key no supplied in config.');
        }

        if (!$config['secret_key']) {
            throw new SDKException('Required "secret_key" key no supplied in config.');
        }

        $this->accessKey = $config['access_key'];
        $this->secretKey = $config['secret_key'];
    }

    /**
     * 获得资源信息
     *
     * @param $resNo string 资源编号
     */
    public function get($resNo)
    {
        return $this->client->get("/resources/{$resNo}");
    }

    /**
     * 生成资源播放 Token
     *
     * @param string $resNo    资源编号
     * @param int    $lifetime Token 的有效时长
     * @param bool   $once     Token是否一次性
     *
     * @return string 资源播放Token
     */
    public function generatePlayToken($resNo, $lifetime = 600, $once = true)
    {
        if ($once) {
            $once = SDK\random_str('16');
        } else {
            $once = '!once';
        }

        $deadline = time() + $lifetime;

        $signingText = "{$resNo}\n{$once}\n{$deadline}";

        $sign = hash_hmac('sha1', $signingText, $this->secretKey, true);

        $encodedSign = SDK\base64_urlsafe_encode($sign);

        return "{$once}:{$deadline}:{$encodedSign}";
    }

    /**
     * 获取云资源的播放地址，该地址可以直接嵌入iframe播放
     *
     * @param string $resNo    资源编号
     * @param int    $lifetime 播放地址的有效时长
     * @param bool   $once     播放地址是否一次性
     *
     * @return string 播放地址
     */
    public function getPlaySrc($resNo, $lifetime = 600, $once = true)
    {
        $src = '//'.self::JS_SDK_HOST.'/js-sdk/player.html';
        $params = array(
            'resNo' => $resNo,
            'token' => $this->generatePlayToken($resNo, $lifetime, $once),
        );

        return $src.'?'.http_build_query($params);
    }
}
