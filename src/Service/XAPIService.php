<?php
namespace QiQiuYun\SDK\Service;

class XAPIService extends BaseService
{
    protected $defaultLang = 'zh-CN';

    /**
     * 提交“观看视频”的学习记录
     *
     * @return void
     */
    public function watchVideo($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'https://w3id.org/xapi/acrossx/verbs/watched',
            'display' => array(
                'zh-CN' => '观看了',
                'en-US' => 'watched'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'https://w3id.org/xapi/acrossx/activities/video',
                'name' => array(
                    $this->defaultLang => $object['name'],
                ),
                'extensions' => array (
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => $object['resource']['id'],
                        'name' => $object['resource']['name'],
                    )
                )
            )
        );

        $statement['result'] = array(
            'duration' => $this->convertTime($result['duration']),
            'extensions' => array(
                'http://id.tincanapi.com/extension/starting-point' => $this->convertTime($result['starting_point']),
                'http://id.tincanapi.com/extension/ending-point' => $this->convertTime($result['ending_point']),
            ),
        );

        $this->pushStatement($statement);
    }

    /**
     * 提交“完成任务”的学习记录
     *
     * @return void
     */
    public function finishActivity($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了',
                'en-US' => 'completed'
            )
        );

        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'https://w3id.org/xapi/acrossx/activities/video',
                'name' => array(
                    $this->defaultLang => $object['name']
                ),
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description']

                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => $object['resource']['id'],
                        'name' => $object['resource']['name']
                    )
                )
            )
        );

        $statement['result'] = array(
            'success' => true
        );
    }

    /**
     * 提交“完成任务的弹题”的学习记录
     *
     * @return void
     */
    public function finishActivityQuestion($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/answered',
            'display' => array(
                'zh-CN' => '回答'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'http://adlnet.gov/expapi/activities/interaction',
                'interactionType' => $object['type'],
                'description' => array(
                    $this->defaultLang => $object['stem'],
                ),
                'correctResponsesPattern' => $object['answer'],
                'choices' => $object['choices'],
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description'],
                    ),
                    'http://xapi.edusoho.com/extensions/activity' => array(
                        'id' => $object['activity']['id'],
                        'title' => $object['activity']['title']
                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => $object['resource']['id'],
                        'name' => $object['resource']['name']
                    )
                )
            )
        );

        $statement['result'] = array(
            'score' => $result['score'],
            'success' => true,
            'response' => $result['response'],
            'duration' => $this->convertTime($result['duration'])
        );
    }
    
    /**
     * 提交“完成作业”的学习记录
     *
     * @return void
     */
    public function finishHomework($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'http://xapi.edusoho.com/activities/homework',
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description'],
                    ),
                )
            ),
        );
        $statement['result'] = array(
            'success' => true
        );
    }

    /**
     * 提交“完成练习”的学习记录
     *
     * @return void
     */
    public function finishExercise($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'http://xapi.edusoho.com/activities/testpaper',
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description'],
                    ),
                )
            ),
        );
        $statement['result'] = array(
            'success' => true
        );
    }

    /**
     * 提交“完成考试”的学习记录
     *
     * @return void
     */
    public function finishTestpaper($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => array(
                'zh-CN' => '完成了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'http://xapi.edusoho.com/activities/examination',
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description'],
                    ),
                )
            ),
        );
        $statement['result'] = array(
            'success' => true
        );
    }

    /**
     * 提交“记笔记”的学习记录
     *
     * @return void
     */
    public function writeNote($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'https://w3id.org/xapi/adb/verbs/noted',
            'display' => array(
                'zh-CN' => '记录'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'https://w3id.org/xapi/acrossx/activities/video',
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description']

                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => $object['resource']['id'],
                        'name' => $object['resource']['name']
                    )
                )
            ),
        );
        $statement['result'] = array(
            'response' => $result['title']
        );
    }

    /**
     * 提交“提问题”的学习记录
     *
     * @return void
     */
    public function askQuestion($actor, $object, $result)
    {
        $statement = array();
        $statement['actor'] = array('account' => $actor);
        $statement['verb'] = array(
            'id' => 'http://adlnet.gov/expapi/verbs/asked',
            'display' => array(
                'zh-CN' => '提问了'
            )
        );
        $statement['object'] = array(
            'id' => $object['id'],
            'defination' => array(
                'type' => 'https://w3id.org/xapi/acrossx/activities/video',
                'extensions' => array(
                    'http://xapi.edusoho.com/extensions/course' => array(
                        'id' => $object['course']['id'],
                        'title' => $object['course']['title'],
                        'description' => $object['course']['description']

                    ),
                    'http://xapi.edusoho.com/extensions/resource' => array(
                        'id' => $object['resource']['id'],
                        'name' => $object['resource']['name']
                    )
                )
            )
        );
        $statement['result'] = array(
            'response' => $result['title']
        );
    }

    /**
     * 提交学习记录
     *
     * @return void
     */
    public function pushStatement($statement)
    {
        $statement['context'] = array(
            'extensions' => array (
                'http://xapi.edusoho.com/extensions/school' => $this->context,
            )
        );

        $this->client->request('POST', 'statements', array(
            'json' => $statement,
        ));
    }
}
