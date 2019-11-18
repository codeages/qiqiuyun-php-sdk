<?php

namespace QiQiuYun\SDK\Service;

class ResourceService extends BaseService
{
    protected $host = 'resource-service.qiqiuyun.net';

    /**
     * 获取表单上传的参数
     *
     * @param $params 参数
     * @return array 上传表单参数
     */
    public function startFormUpload($params)
    {
        return $this->request('POST', '/upload/start', $params);
    }

    /**
     * 完成表单上传
     *
     * @param $no 云资源编号
     * @return array
     */
    public function finishFormUpload($no)
    {
        return $this->request('POST', '/upload/finish', array('no' => $no));
    }
}