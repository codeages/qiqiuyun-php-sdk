<?php

namespace QiQiuYun\SDK\Tests\Service;

use QiQiuYun\SDK\Tests\BaseTestCase;
use QiQiuYun\SDK\Service\NotificationService;

class NotificationServiceTest extends BaseTestCase
{
    public function testOpenAccount()
    {
        $httpClient = $this->mockHttpClient(array(
            "id" => 3,
            "user_id" => 39,
            "access_key" => "T7YARlmDmknXijWTCaRfdBo3O82K63RD",
            "status" => 1,
            "created_time" => "2019-06-06T09:55:28+00:00",
            "updated_time" => "2019-06-09T07:44:12+00:00",
        ));

        $service = new NotificationService($this->auth, array(), null, $httpClient);

        $result = $service->openAccount(array());

        $this->assertEquals('T7YARlmDmknXijWTCaRfdBo3O82K63RD', $result['access_key']);
    }
}