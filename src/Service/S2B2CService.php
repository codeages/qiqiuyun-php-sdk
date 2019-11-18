<?php

namespace QiQiuYun\SDK\Service;

class S2B2CService extends BaseService
{
    //@todo 此处测试站，后改为正式站
    protected $host = 's2b2c-service.local.cg-dev.cn';

    public function supplierHasMerchant($supplierAccessKey, $merchantAccessKey)
    {
        $query = array(
            'supplierAccessKey' => $supplierAccessKey,
            'merchantAccessKey' => $merchantAccessKey,
        );
        return $this->request('GET', '/suppliers/actions/has_merchant', $query);
    }
}