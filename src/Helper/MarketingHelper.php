<?php

namespace QiQiuYun\SDK\Helper;

class MarketingHelper
{
    public static function transformStudent($items)
    {
        $students = array();
        foreach ($items as $item) {
            $student['user_source_id'] = $item['id'];
            $student['nickname'] = $item['nickname'];
            $student['mobile'] = isset($item['mobile']) ? $item['mobile'] : '';
            $student['registered_time'] = $item['createdTime'];
            $student['token'] = $item['token'];
            $students[] = $student;
        }

        return $students;
    }
}
