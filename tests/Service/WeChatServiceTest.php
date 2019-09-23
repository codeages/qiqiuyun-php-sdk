<?php

namespace QiQiuYun\SDK\test\Service;

use QiQiuYun\SDK\Service\WeChatService;
use QiQiuYun\SDK\Tests\BaseTestCase;

class WeChatServiceTest extends BaseTestCase
{
    public function testGetPreAuthUrl()
    {
        $httpClient = $this->mockHttpClient('ww.test.com');
        $service = new WeChatService($this->auth, array(), null, $httpClient);
        $result = $service->getPreAuthUrl(1, 'test.com');

        $this->assertEquals($result, 'ww.test.com');
    }

    public function testGetUserList()
    {
        $httpClient = $this->mockHttpClient(array('total' => 1, 'count' => 1, 'data' => array('test1', 'test2'), 'next_openid' => 'test2'));
        $service = new WeChatService($this->auth, array(), null, $httpClient);
        $result = $service->getUserList();

        $this->assertEquals($result['total'], 1);
    }

    public function testGetUserInfo()
    {
        $httpClient = $this->mockHttpClient(array('subscribe' => 1, 'openid' => 'test', 'nickname' => 'test', 'sex' => '1'));
        $service = new WeChatService($this->auth, array(), null, $httpClient);
        $result = $service->getUserInfo('test');

        $this->assertEquals($result['sex'], '1');
    }

    public function testBatchGetUserInfo()
    {
        $httpClient = $this->mockHttpClient(array('user_info_list' => array(array('subscribe' => 1, 'openid' => 'test1', 'nickname' => 'test', 'sex' => '1'), array('subscribe' => 1, 'openid' => 'test2', 'nickname' => 'test', 'sex' => '1'))));
        $service = new WeChatService($this->auth, array(), null, $httpClient);
        $result = $service->batchGetUserInfo(array('test1', 'test2'));

        $this->assertEquals($result[0]['subscribe'], 1);
    }

    public function testGetAuthorizationInfo()
    {
        $httpClient = $this->mockHttpClient(array(array('funcscope_category' => array('id' => 1)), array('funcscope_category' => array('id' => 2))));
        $service = new WeChatService($this->auth, array(), null, $httpClient);
        $result = $service->getAuthorizationInfo('official');

        $this->assertEquals($result[0]['funcscope_category'], array('id' => 1));
    }

    public function testCreateNotificationTemplate()
    {
        $httpClient = $this->mockHttpClient(array('template_id' => 'templateId'));
        $service = new WeChatService($this->auth, array(), null, $httpClient);
        $result = $service->createNotificationTemplate('templateCode');

        $this->assertEquals($result['template_id'], 'templateId');
    }

    public function testDeleteNotificationTemplate()
    {
        $httpClient = $this->mockHttpClient(array('success' => true));
        $service = new WeChatService($this->auth, array(), null, $httpClient);
        $result = $service->deleteNotificationTemplate('templateId');

        $this->assertEquals($result['success'], true);
    }
}