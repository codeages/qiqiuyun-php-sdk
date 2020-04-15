<?php

namespace QiQiuYun\SDK\Service;

class S2B2CService extends BaseService
{
    //@todo 此处测试站，后改为正式站
    protected $host = 's2b2c-service.local.cg-dev.cn';

    /**
     * @param $productIds array 订单中，供货商商品的 id，非本地商品 id.
     * @example array(1,2,3);
     *
     * @param $extra array 上报的订单信息
     * @example array('order' => $order, 'orderItems' => $orderItems)
     *
     * @return array
     */
    public function reportSuccessOrder($productIds, $extra)
    {
        $params = array(
            'status' => 'success',
            'productIds' => $productIds,
            'extra' => $extra,
        );

        return $this->request('POST', '/order/report', $params);
    }

    /**
     * @param $orderSn string 退款订单Sn
     *
     * @param array $productIds 退款商品在供应商的id，非本地商品id
     * @example array(1, 2, 3);
     *
     * @param $extra array('orderRefund' => $orderRefund, 'orderItemRefund' => $orderItemRefund);
     *
     * @return array
     */
    public function reportRefundOrder($orderSn, $productIds, $extra)
    {
        $params = array(
            'status' => 'refund',
            'merchantOrderSn' => $orderSn,
            'productIds' => $productIds,
            'extra' => $extra
        );

        return $this->request('POST', 'order/report', $params);
    }
}