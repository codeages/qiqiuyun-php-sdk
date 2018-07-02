<?php

namespace QiQiuYun\SDK\Service;

class MpService extends BaseService
{
    protected $host = 'mp-platform-dev.cn';

    public function sendMpRequest(array $params)
    {
        return $this->request('POST', '/mpRequests', $params);
    }

    public function getCurrentMpRequest()
    {
        return $this->request('GET', '/mpRequests/current', array());
    }

    public function getToken(array $params)
    {
        return $this->request('POST', '/tokens', $params);
    }
}
