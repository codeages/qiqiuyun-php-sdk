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

    /**
     * @param $merchantAccessKey string 渠道商的 access_key
     *
     * @param $productIds array 订单中，供货商商品的 id，非本地商品 id.
     * @example array(1,2,3);
     *
     * @param $extra array 上报的订单信息
     * @example array('order' => $order, 'orderItems' => $orderItems)
     *
     * @return array
     */
    public function reportSuccessOrder($merchantAccessKey, $productIds, $extra)
    {
        $params = array(
            'merchantAccessKey' => $merchantAccessKey,
            'productIds' => $productIds,
            'extra' => $extra,
        );

        return $this->request('POST', '/order/report/success', $params);
    }
}