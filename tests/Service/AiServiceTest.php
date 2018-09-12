<?php

namespace QiQiuYun\SDK\Tests\Service;

use QiQiuYun\SDK\Tests\BaseTestCase;
use QiQiuYun\SDK\Service\AiService;

class AiServiceTest extends BaseTestCase
{
    public function testCreateFaceSession()
    {
        $mockSession = $this->mockSession();
        $httpClient = $this->mockHttpClient($mockSession);

        $service = new AiService($this->auth, array(), null, $httpClient);

        $userId = $mockSession['user_id'];
        $userName = $mockSession['user_name'];

        $result = $service->createFaceSession($userId, $userName);

        $this->assertEquals($userId, $result['user_id']);
        $this->assertEquals($userName, $result['user_name']);
    }

    public function testGetFaceSession()
    {
        $mockSession = $this->mockSession();
        $httpClient = $this->mockHttpClient($mockSession);

        $service = new AiService($this->auth, array(), null, $httpClient);

        $sessionId = $mockSession['session_id'];

        $result = $service->getFaceSession($sessionId);

        $this->assertEquals($sessionId, $result['session_id']);
    }

    public function testUpdateFaceSession()
    {
        $mockSession = $this->mockSession();
        $httpClient = $this->mockHttpClient($mockSession);

        $service = new AiService($this->auth, array(), null, $httpClient);

        $sessionId = $mockSession['session_id'];

        $result = $service->updateFaceSession($sessionId, $mockSession);

        $this->assertEquals($sessionId, $result['session_id']);
    }

    public function testFaceRegister()
    {
        $mockSession = $this->mockSession();
        $httpClient = $this->mockHttpClient($mockSession);

        $service = new AiService($this->auth, array(), null, $httpClient);

        $sessionId = $mockSession['session_id'];

        $result = $service->faceRegister($sessionId, 'b7a2cf470a9e47');

        $this->assertEquals($sessionId, $result['session_id']);
    }

    public function testFaceCompare()
    {
        $mockSession = $this->mockSession();
        $httpClient = $this->mockHttpClient($mockSession);

        $service = new AiService($this->auth, array(), null, $httpClient);

        $sessionId = $mockSession['session_id'];

        $result = $service->faceCompare($sessionId, 'b7a2cf470a9e47');

        $this->assertEquals($sessionId, $result['session_id']);
    }

    public function testCreateUploadToken()
    {
        $httpClient = $this->mockHttpClient(array(
            "token" => "6uEqT5vwuQIM4p1vkf7bk6GHshgNofDb_SYHvabL:Lm_yXxELtuPd7o8djWXv-gX3y0Y=:eyJzY29wZSI6ImZhY2UtZGI6MWZmZGM0ZmNjNDU1NDA1OTg4MzBlZTUzZDA4NzVlZmMiLCJkZWFkbGluZSI6MTUzNjc0NzA3OSwidXBIb3N0cyI6WyJodHRwOlwvXC91cC5xaW5pdS5jb20iLCJodHRwOlwvXC91cGxvYWQucWluaXUuY29tIiwiLUggdXAucWluaXUuY29tIGh0dHA6XC9cLzE4My4xMzEuNy4xOCJdfQ==",
            "key" =>  "1ffdc4fcc45540598830ee53d0875efc",
            "upload_url" => "http://upload.qiniup.com/"
        ));

        $service = new AiService($this->auth, array(), null, $httpClient);

        $result = $service->createUploadToken();

        $this->assertEquals('6uEqT5vwuQIM4p1vkf7bk6GHshgNofDb_SYHvabL:Lm_yXxELtuPd7o8djWXv-gX3y0Y=:eyJzY29wZSI6ImZhY2UtZGI6MWZmZGM0ZmNjNDU1NDA1OTg4MzBlZTUzZDA4NzVlZmMiLCJkZWFkbGluZSI6MTUzNjc0NzA3OSwidXBIb3N0cyI6WyJodHRwOlwvXC91cC5xaW5pdS5jb20iLCJodHRwOlwvXC91cGxvYWQucWluaXUuY29tIiwiLUggdXAucWluaXUuY29tIGh0dHA6XC9cLzE4My4xMzEuNy4xOCJdfQ==', $result['token']);
        $this->assertEquals('1ffdc4fcc45540598830ee53d0875efc', $result['key']);
        $this->assertEquals('http://upload.qiniup.com/', $result['upload_url']);
    }

    private function mockSession()
    {
        return array(
            "id" => "cdfed62d29ec2b5c38c385b7a2cf470a9e4743177397e028bb3af15508a26658",
            "user_name" => "clf",
            "user_id" => 111,
            "access_key" => "vPb16d4L9YFm9mqlvTyoCo0Y5og1vZL",
            "face_token" => null,
            "status" => "created",
            "updated_at" => "2018-09-12T16:40:51+08:00",
            "created_at" => "2018-09-12T16:40:51+08:00",
            "expired_at" => "2018-09-12T16:50:51+08:00",
        );
    }

    private function getAiService()
    {
        return new AiService($this->auth);
    }
}
