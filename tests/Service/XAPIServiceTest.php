<?php

namespace QiQiuYun\SDK\Tests\Service;

use QiQiuYun\SDK\Tests\BaseTestCase;
use QiQiuYun\SDK\Service\XAPIService;

class ClientTest extends BaseTestCase
{
    protected $auth;

    public function setUp()
    {
        $this->auth = $this->createAuth();
    }

    public function testWatchVideo()
    {
        $service = new XAPIService($this->auth, array(
            'school' => array(
                'id' => $this->accessKey,
                'name' => '测试网校',
            )
        ));

        $actor = array(
            'id' => 1,
            'name' => '测试用户',
        );

        $object = array(
            'id' => 1,
            'name' => '测试任务',
            'course' => array(
                'id' => 1,
                'title' => '测试课程',
                'description' => '这是一个测试课程',
            ),
            'video' => array(
                'id' => '1111',
                'name' => '测试视频.mp4'
            )
        );

        $result = array(
            'duration' => 100,
        );

        $service->watchVideo($actor, $object, $result);


    }
}