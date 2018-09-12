<?php

namespace QiQiuYun\SDK\Service;

/**
 * AI服务
 */
class AiService extends BaseService
{
    protected $host = 'ai-service.qiqiuyun.net';

    /**
     * 创建人脸识别会话
     *
     * @see http://docs.qiqiuyun.com/v2/ai-face.html
     *
     * @param $userId int 用户id
     * @param $userName string 用户名
     * 
     * @return array 会话信息
     */
    public function createFaceSession($userId, $userName)
    {
        return $this->request('POST', '/face/session', array('user_id' => $userId, 'user_name' => $userName));
    }

    /**
     * 获取人脸识别会话信息
     *
     * @see http://docs.qiqiuyun.com/v2/ai-face.html
     *
     * @param string $sessionId  会话id
     * 
     * @return array 会话信息
     */
    public function getFaceSession($sessionId)
    {
        return $this->request('GET', '/face/session/' . $sessionId);
    }

    /**
     * 更新人脸识别会话信息
     *
     * @see http://docs.qiqiuyun.com/v2/ai-face.html
     *
     * @param string $sessionId 会话id
     * @param array  $data 更新数据
     * 
     * @return array 会话信息
     */
    public function updateFaceSession($sessionId, array $data = array())
    {
        return $this->request('POST', '/face/session/' . $sessionId, $data);
    }

    /**
     * 人脸注册
     *
     * @see http://docs.qiqiuyun.com/v2/ai-face.html
     *
     * @param string $sessionId 会话id
     * @param string $key 人脸资源编号
     * 
     * @return array 会话信息
     */
    public function faceRegister($sessionId, $key)
    {
        return $this->request('POST', '/face/register', array('session_id' => $sessionId, 'key' => $key));
    }

    /**
     * 人脸对比
     *
     * @see http://docs.qiqiuyun.com/v2/ai-face.html
     *
     * @param string $sessionId 会话id
     * @param string $key 人脸资源编号
     * 
     * @return array 会话信息
     */
    public function faceCompare($sessionId, $key)
    {
        return $this->request('POST', '/face/compare', array('session_id' => $sessionId, 'key' => $key));
    }

    /**
     * 获取七牛上传凭证
     *
     * @see http://docs.qiqiuyun.com/v2/ai-face.html
     *
     * @return array 上传所需信息
     */
    public function createUploadToken()
    {
        return $this->request('POST', '/face/upload_token');
    }
}
