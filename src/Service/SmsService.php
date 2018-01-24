<?php

namespace QiQiuYun\SDK\Service;

use QiQiuYun\SDK\Exception\ResponseException;

class SmsService extends BaseService
{
    
    /**
     * 单个发送
     *
     * @param $params array 发送参数
     * http://qiqiuyun.pages.codeages.net/api-doc/v1/resource/sms-service.html
     */
    public function sendSingle($params)
    {
        $rawResponse = $this->client->request('POST', '/messages', array(
            'json' => $params,
            'headers' => array(
                'Authorization' => $this->auth->secretSign(),
            ),
        ));
        $response = json_decode($rawResponse->getBody(), true);

        if (isset($response['error'])) {
            throw new ResponseException($rawResponse);
        }
        
        return $response; 
    }

    /**
     * 群发
     *
     * @param $params array 发送参数
     * http://qiqiuyun.pages.codeages.net/api-doc/v1/resource/sms-service.html
     */
    public function sendBatch($params)
    {
        $rawResponse = $this->client->request('POST', '/messages/batch_messages', array(
            'json' => $params,
            'headers' => array(
                'Authorization' => $this->auth->secretSign(),
            ),
        ));
        $response = json_decode($rawResponse->getBody(), true);

        if (isset($response['error'])) {
            throw new ResponseException($rawResponse);
        }
        
        return $response; 
    }

}
