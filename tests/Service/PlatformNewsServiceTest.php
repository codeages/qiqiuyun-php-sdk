<?php

namespace QiQiuYun\SDK\Tests\Service;

use QiQiuYun\SDK\Constants\PlatformNewsBlockTypes;
use QiQiuYun\SDK\Service\PlatformNewsService;
use QiQiuYun\SDK\Tests\BaseTestCase;
use QiQiuYun\SDK\Service\AiService;

class PlatformNewsServiceTest extends BaseTestCase
{
    private $advice = array(
        "blockId" => PlatformNewsBlockTypes::ADVICE_BLOCK,
        "blockName" => "经营建议",
        "returnUrl" => "http://test.com/sssss",
        "newsList" => array(
            array(
                "title" => "课程A",
                "image" => "https://qiniu.com/image1",
                "url" => "https://ad.com/ad",
                "subtitle" => "本课程为xxx课程",
                "position" => 1
            ),
            array(
                "title" => "课程B",
                "image" => "https://qiniu.com/image2",
                "url" => "https://ad.com/ad",
                "subtitle" => "本课程为ccc课程",
                "position" => 2
            ),
            array(
                "title" => "课程C",
                "image" => "https://qiniu.com/image3",
                "url" => "https://ad.com/ad",
                "subtitle" => "本课程为zzz课程",
                "position" => 3
            ),
            array(
                "title" => "课程D",
                "image" => "https://qiniu.com/image4",
                "url" => "https://ad.com/ad",
                "subtitle" => "本课程为vvv课程",
                "position" => 4
            )
        )
    );

    private $plugin = array(
        "blockId" => PlatformNewsBlockTypes::PLUGIN_BLOCK,
        "blockName" => "应用简介",
        "returnUrl" => "http://test.edusoho.com/sssss",
        "newsList" => array(
            array(
                "title" => "应用A",
                "image" => "https://qiniu.com/image1",
                "url" => "https://ad.com/ad",
                "subtitle" => "本应用为xxx应用",
                "position" => 1
            ),
            array(
                "title" => "应用B",
                "image" => "https://qiniu.com/image2",
                "url" => "https://ad.com/ad",
                "subtitle" => "本应用为ccc应用",
                "position" => 2
            ),
            array(
                "title" => "应用C",
                "image" => "https://qiniu.com/image3",
                "url" => "https://ad.com/ad",
                "subtitle" => "本应用为zzz应用",
                "position" => 3
            ),
            array(
                "title" => "应用D",
                "image" => "https://qiniu.com/image4",
                "url" => "https://ad.com/ad",
                "subtitle" => "本应用为vvv应用",
                "position" => 4
            )
        )
    );

    public function testGetNews()
    {
        $limit = 2;

        $expectedValue = $this->advice;
        $expectedValue['newsList'] = array_slice($this->advice['newsList'], 0, $limit);

        $client = $this->mockHttpClient($expectedValue);

        $result = $this->getPlatformNewsService($client)->getNews(PlatformNewsBlockTypes::ADVICE_BLOCK, $limit);

        $this->assertArrayHasKey('newsList', $result);
        $this->assertEquals($expectedValue['newsList'], $result['newsList']);

        $expectedValue = $this->plugin;
        $expectedValue['newsList'] = array_slice($this->plugin['newsList'], 0, $limit);

        $client = $this->mockHttpClient($expectedValue);

        $result = $this->getPlatformNewsService($client)->getNews(PlatformNewsBlockTypes::ADVICE_BLOCK);

        $this->assertArrayHasKey('newsList', $result);
        $this->assertEquals($expectedValue['newsList'], $result['newsList']);
    }


    private function getPlatformNewsService($client)
    {
        return new PlatformNewsService($this->auth, array(), null, $client);
    }
}
