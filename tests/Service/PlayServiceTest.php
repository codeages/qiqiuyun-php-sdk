<?php

namespace QiQiuYun\SDK\Tests\Service;

use QiQiuYun\SDK\Service\PlayService;
use QiQiuYun\SDK\Tests\BaseTestCase;

class PlayServiceTest extends BaseTestCase
{
    public function testMakePlayToken()
    {
        $playService = new PlayService($this->auth);

        $resNo = 'this_is_a_test_resource_no_1';
        $lifetime = 600;

        $token = $playService->makePlayToken($resNo, $lifetime);

        $this->assertNotEmpty($token);
    }
}
