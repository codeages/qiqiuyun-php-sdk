<?php

namespace QiQiuYun\SDK\Service;

use QiQiuYun\SDK\SignUtil;
use QiQiuYun\SDK\Service\BaseService;
use QiQiuYun\SDK;


class MarketingService extends BaseService
{
   
    public function generateLoginForm($user,$site)
    {
        $sign = $this->sign($user,$site);
        return $this->generateForm($user,$site,$sign);
    }

    private function generateForm($user,$site,$sign)
    {
        return "
            <form class='form-horizontal' id='login-form' method='post' action='http://test.fx.edusoho.cn/merchant/login'>
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

    private function sign($user,$site)
    {
        $bodyJson = SignUtil::serialize(['user'=>$user,'site'=>$site]);
        $time = time();
        $once = SDK\random_str('16');
        $signText = implode('\n', array($time,$once, $bodyJson));
        $sign = $this->auth->sign($signText);
        $accessKey = $this->auth->getAccessKey();
        return "{$accessKey}:{$time}:{$once}:{$sign}";
    }
}