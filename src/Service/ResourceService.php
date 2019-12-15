<?php

namespace QiQiuYun\SDK\Service;

use QiQiuYun\SDK\Exception\ResponseException;
use QiQiuYun\SDK\Exception\SDKException;
use QiQiuYun\SDK\HttpClient\ClientException;

class ResourceService extends BaseService
{
    protected $host = 'resource-service.qiqiuyun.net';

    /**
     * 获取表单上传的参数
     *
     * @param $params array 参数
     * @return array 上传表单参数
     * @throws ResponseException
     * @throws SDKException
     * @throws ClientException
     */
    public function startUpload(array $params)
    {
        return $this->request('POST', '/upload/start', $params);
    }

    /**
     * 完成表单上传
     *
     * @param $no string 云资源编号
     * @return array
     * @throws ClientException
     * @throws ResponseException
     * @throws SDKException
     */
    public function finishUpload(string $no)
    {
        return $this->request('POST', '/upload/finish', array('no' => $no));
    }

    /**
     * @param string $no 云资源编号
     * @return array
     * @throws ClientException
     * @throws ResponseException
     * @throws SDKException
     */
    public function get(string $no)
    {
        return $this->request('GET', '/resources/' . $no);
    }

    /**
     * @param array $params
     * @return array
     * @throws ClientException
     * @throws ResponseException
     * @throws SDKException
     */
    public function search(array $params)
    {
        return $this->request('GET', '/resources', $params);
    }

    /**
     * @param string $no
     * @param array $params
     * @return string
     * @throws ClientException
     * @throws ResponseException
     * @throws SDKException
     */
    public function getDownloadUrl(string $no, array $params = array())
    {
        return $this->request('GET', '/resources/' . $no . '/downloadUrl', $params);
    }

    /**
     * @param string $no
     * @param array $params
     * @return array
     * @throws ClientException
     * @throws ResponseException
     * @throws SDKException
     */
    public function update(string $no, array $params)
    {
        return $this->request('PATCH', '/resources/' . $no, $params);
    }

    /**
     * @param string $no
     * @return array
     * @throws ClientException
     * @throws ResponseException
     * @throws SDKException
     */
    public function delete(string $no)
    {
        return $this->request('DELETE', '/resources/' . $no);
    }
}
