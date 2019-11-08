<?php

namespace QiQiuYun\SDK\Service;

/**
 * Open站
 */
class PlatformNewsService extends BaseService
{
    protected $host = 'open.edusoho.com';

    /**
     * 根据区块id获取区块信息
     *
     * @param $blockId
     * @param int $limit
     * @return array
     *              blockId int  区块id
     *              blockName string  区块名
     *              returnUrl string  回调url
     *              newsList array    取回的信息
     */
    public function getNews($blockId, $limit = 4)
    {
        return $this->request('GET', "/api/v1/news/block/{$blockId}", array('limit' => $limit));
    }
}
