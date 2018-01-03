<?php

namespace QiQiuYun\SDK\Service;

use QiQiuYun\SDK\SignUtil;
use QiQiuYun\SDK\Helper\MarketingHelper;

class MarketingService extends BaseService
{
    private $loginPath = '/merchant/login';
    private $merchantStudents = '/merchant/students';
    private $studentOrders = '/merchant/orders';

    public function generateLoginForm($user, $site)
    {
        $jsonStr = SignUtil::serialize(['user' => $user, 'site' => $site]);

        $sign = SignUtil::sign($this->auth, $jsonStr);

        return $this->generateForm($user, $site, $sign);
    }

    /**
     * 给分销平台发送数据学员注册列表
     *
     * @param $data, 数组
     *  [
     *      {
     *         'id' => 123,//用户在ES的Id
     *          'nickname' => 'es', // 用户名
     *          'mobile' => 13675882213, //没有则没有此属性
     *          'createdTime' => unix_time, //注册时间，unix时间戳
     *          'token' => '123descds',  //二维码扫描时，营销平台返回的token
     *      },
     *      .....
     *  ]
     */
    public function postMerchantStudents($data)
    {
        $students = MarketingHelper::transformStudent($data);

        return $this->postData($this->merchantStudents, $students);
    }

    /**
     * 给分销平台发送订单数据
     *
     *
     * @param $data, 格式为 json数据数组
     *  [
     *      {
     *          'd' => 1,
     *          'c' => 2,
     *      },
     *      .....
     *  ]
     */
    public function postMerchantOrders($data)
    {
        $orders = MarketingHelper::transformOrders($data);

        return $this->postData($this->studentOrders, $orders);
    }

    private function generateForm($user, $site, $sign)
    {
        $url = $this->baseUri;

        return "
            <form class='form-horizontal' id='login-form' method='post' action='{$url}'>
                <fieldset style='display:none;'>
                    <input type='hidden' name='site[name]' class='form-control' value={$site['name']}>
                    <input type='hidden' name='site[logo]' class='form-control' value={$site['logo']}>
                    <input type='hidden' name='site[about]' class='form-control' value={$site['about']}>
                    <input type='hidden' name='site[wechat]' class='form-control' value={$site['wechat']}>
                    <input type='hidden' name='site[qq]' class='form-control' value={$site['qq']}>
                    <input type='hidden' name='site[telephone]' class='form-control' value={$site['telephone']}>
                    <input type='hidden' name='site[domain]' class='form-control' value={$site['domain']}>
                    <input type='hidden' name='site[access_key]' class='form-control' value='{$site['access_key']}'>
                    <input type='hidden' name='user[user_source_id]' class='form-control' value='{$user['user_source_id']}'>
                    <input type='hidden' name='user[nickname]' class='form-control' value='{$user['nickname']}'>
                    <input type='hidden' name='user[avatar]' class='form-control' value='{$user['avatar']}'>
                    <input type='hidden' name='sign' class='form-control' value='{$sign}'>
                </fieldset>
                <button type='submit' class='btn btn-primary'>提交</button>
            </form>";
    }

    private function postData($path, $data)
    {
        $jsonStr = SignUtil::serialize($data);
        $jsonStr = SignUtil::cut($jsonStr);
        $sign = SignUtil::sign($this->auth, $jsonStr);

        return $this->client->request(
            'POST',
            $this->baseUri.$path,
            array(
                'data' => $data,
                'sign' => $sign,
            )
        );
    }
}
