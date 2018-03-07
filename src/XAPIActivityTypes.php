<?php

namespace QiQiuYun\SDK;

final class XAPIActivityTypes
{
    const APPLICATION = 'application';

    const AUDIO = 'audio';

    const CLASS_ONLINE = 'class-online';

    const COURSE = 'course';

    const ONLINE_DISCUSSION = 'online-discussion';

    const DOCUMENT = 'document';

    const EXERCISE = 'exercise';

    const HOMEWORK = 'homework';

    const INTERACTION = 'interaction';

    const LIVE = 'live';

    const MESSAGE = 'message';

    const QUESTION = 'question';

    const TEST_PAPER = 'testpaper';

    const VIDEO = 'video';

    public static function getFullName($shortName)
    {
        switch ($shortName) {
            case self::APPLICATION: //音频
                $fullName = 'http://activitystrea.ms/schema/1.0/application';
                break;
            case self::AUDIO: //音频
                $fullName = 'http://activitystrea.ms/schema/1.0/audio';
                break;
            case self::COURSE: //课程
                $fullName = 'http://adlnet.gov/expapi/activities/course';
                break;
            case self::ONLINE_DISCUSSION:
                $fullName = 'https://w3id.org/xapi/acrossx/activities/online-discussion';
                break;
            case self::DOCUMENT: //文档,一个主要内容为文本的独立文件,包含word,excel,ppt,text等格式
                $fullName = 'https://w3id.org/xapi/acrossx/activities/document';
                break;
            case self::EXERCISE: //练习,非xAPI标准
                $fullName = 'http://xapi.edusoho.com/activities/exercise';
                break;
            case self::HOMEWORK: //作业,非xAPI标准
                $fullName = 'http://xapi.edusoho.com/activities/homework';
                break;
            case self::INTERACTION: //互动
                $fullName = 'http://adlnet.gov/expapi/activities/interaction';
                break;
            case self::LIVE: //直播,非xAPI标准
                $fullName = 'http://xapi.edusoho.com/activities/live';
                break;
            case self::QUESTION: //问题
                $fullName = 'http://adlnet.gov/expapi/activities/question';
                break;
            case self::TEST_PAPER: //试卷,非xAPI标准
                $fullName = 'http://xapi.edusoho.com/activities/testpaper';
                break;
            case self::VIDEO: //视频
                $fullName = 'https://w3id.org/xapi/acrossx/activities/video';
                break;
            case self::MESSAGE: //资讯
                $fullName = 'https://w3id.org/xapi/acrossx/activities/message';
                break;
            case self::CLASS_ONLINE: //班级
                $fullName = 'https://w3id.org/xapi/acrossx/activities/class-online';
                break;
            default:
                throw new \InvalidArgumentException('UnSupport type');
        }

        return $fullName;
    }

}