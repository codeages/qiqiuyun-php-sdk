<?php

namespace QiQiuYun\SDK\Service;

use App\Biz\Service\ProductService;
use Psr\Log\LoggerInterface;
use QiQiuYun\SDK\Auth;
use QiQiuYun\SDK\Exception\ResponseException;
use QiQiuYun\SDK\Exception\SDKException;
use QiQiuYun\SDK\HttpClient\ClientInterface;

class S2B2CService extends BaseService
{
    //@todo 此处测试站，后改为正式站
    protected $defaultHost = 's2b2c-service.qiqiuyun.net';

    public function __construct(Auth $auth, array $options = array(), LoggerInterface $logger = null, ClientInterface $client = null)
    {
        parent::__construct($auth, $options, $logger, $client);
        if (empty($this->host)) {
            $this->host = $this->defaultHost;
        }
    }

    /**
     * 上报支付成功的订单
     * 
     * merchantOrderId => es本地订单id
     * merchantOrderRefundDays => es本地订单退款时间
     * merchantOrderUserNickname => es本地订单购买者
     * productDetailId => s2b2c端productDetailId
     * merchantReportId => es订单结算上报id
     *
     * @return
     */
    public function reportSuccessOrder($params)
    {
        return $this->sendRequest('/distribute/order/settlement/report', $params, 'POST');
    }

    /**
     * 上报退款成功的订单
     * 
     * productDetailId => s2b2c端productDetailId
     * merchantRefundReportId => es本地退款上报id
     * merchantOrderId => es本地订单id
     * merchantLastReportId => es订单结算时的上报id
     *
     * @return array
     */
    public function reportRefundOrder($params)
    {
        return $this->sendRequest('/order/report/refund', $params, 'POST');
    }

    /**
     * 获取渠道商自身信息
     *
     * @return array 用户信息
     */
    public function getMe()
    {
        return $this->sendRequest('/merchants/me', array());
    }

    /**
     * 获取渠道商的代理商信息
     *
     * @return array 用户信息
     */
    public function getOwnSupplier()
    {
        return $this->sendRequest('/merchants/own/supplier', array());
    }

    /**
     * 搜索B端余额明细列表
     *
     * @param $conditions array('created_time_GTE', 'created_time_LTE', 'type')
     * @param $sorts
     * @param $start
     * @param $limit
     *
     * @return array array('items' => array(), 'count' => 0)
     */
    public function searchMerchantFlow($conditions, $sorts, $start, $limit)
    {
        $params = array(
            'conditions' => $conditions,
            'sorts' => $sorts,
            'start' => (int) $start,
            'limit' => (int) $limit,
        );

        return $this->sendRequest('/merchants/flows', $params);
    }

    /**
     * 搜索B端结算订单列表
     *
     * @param $conditions array('pay_time_GT', 'pay_time_LT', 'title_like', 'start_time', 'end_time')
     * @param $sorts
     * @param $start
     * @param $limit
     *
     * @return array array('items' => array(), 'count' => 0)
     */
    public function searchMerchantOrder($conditions, $sorts, $start, $limit)
    {
        $params = array(
            'conditions' => $conditions,
            'sorts' => $sorts,
            'start' => (int) $start,
            'limit' => (int) $limit,
        );

        return $this->sendRequest('/merchants/orders', $params);
    }

    /**
     * 搜索B端的已选商品
     *
     * @param $conditions
     * @param $sorts
     * @param $start
     * @param $limit
     *
     * @return array array('items' => array(), 'count' => 0)
     */
    public function searchDistribute($conditions, $sorts, $start, $limit)
    {
        $params = array(
            'conditions' => $conditions,
            'sorts' => $sorts,
            'start' => (int) $start,
            'limit' => (int) $limit,
        );

        return $this->sendRequest('/distribute/products', $params);
    }

    /**
     * 获取余额明细详情
     *
     * @return array (order,flow)
     */
    public function getFlowDetail($flowId)
    {
        $sendData = array('flowId' => $flowId);

        return $this->sendRequest('/merchants/flow_detail', $sendData);
    }

    /**
     * 获取订单列表详情
     *
     * @return array (order,merchant,flows)
     */
    public function getOrderDetail($orderSn)
    {
        $sendData = array('orderSn' => $orderSn);

        return $this->sendRequest('/merchants/order_detail', $sendData);
    }

    /**
     * 批量获取分发课程状态接口路径
     *
     * @return array ()
     */
    public function findDistributeProducts($productIds)
    {
        $sendData = array(
            'productIds' => $productIds,
        );

        return $this->sendRequest('/merchants/distrabute_products', $sendData);
    }

    public function changeProductSellingPrice($productDetailId, $sellingPrice)
    {
        $sendData = array(
            'sellingPrice' => $sellingPrice,
        );
        $uri = str_replace('{productDetailId}', $productDetailId,
            '/distribute/product_detail/{productDetailId}/selling_price/change');

        return $this->sendRequest($uri, $sendData, 'POST');
    }

    public function getDistributeProduct($productId)
    {
        return $this->sendRequest("/distribute/product/{$productId}", array());
    }

    public function getDistributeProductVersions($productDetailId)
    {
        $uri = str_replace('{productDetailId}', $productDetailId,
            '/distribute/product/{productDetailId}/versions');

        return $this->sendRequest($uri, array());
    }

    public function getDistributeContent($productDetailId)
    {
        $uri = "/distribute/content/{$productDetailId}";

        return $this->sendRequest($uri, array());
    }

    public function getDistributeOldContent($distributeId)
    {
        return $this->sendRequest("/distribute/old/content/{$distributeId}", array());
    }

    /**
     * @return array ['status' => boolean,
     * array data =>  [
     *  array Product => [
     *      targetId => int,
     *      targetType => int
     *      ...array detail => [array ProductDetail ... ]
     *      ]
     *  ]
     * ]
     */
    public function adoptDirtributeProduct($productId)
    {
        $uri = str_replace('{id}', $productId, '/distribute/product/{id}/adopt');

        return $this->sendRequest($uri, array(), 'POST');
    }

    public function changePurchaseStatusToRemoved($productId)
    {
        $uri = str_replace('{productId}', $productId, '/purchase/{productId}/removed');

        return $this->sendRequest($uri, array(), 'POST');
    }

    public function upgrade($params)
    {
        return $this->sendRequest('/upgrade', $params, 'POST');
    }

    public function searchPurchaseProduct($conditions, $sorts, $start, $limit)
    {
        $body = array(
            'conditions' => $conditions,
            'sorts' => $sorts,
            'start' => $start,
            'limit' => $limit,
        );

        return $this->sendRequest('/contents/search_purchase_product', $body, 'GET');
    }

    /**
     * 获取商品资源播放列表m3u8
     *
     * @return array()
     */
    public function getProductHlsPlaylist($uri, $file, $params)
    {
        $sendData = $this->generateResourcesParams($uri, $file, $params);
        if (!empty($sendData['error'])) {
            return $sendData;
        }

        return $this->sendRequest('/merchant_resource/hls/playlist', $sendData);
    }

    /**
     * 获取商品资源播放列表m3u8-json
     *
     * @return array()
     */
    public function getProductHlsPlaylistJson($uri, $file, $params)
    {
        $sendData = $this->generateResourcesParams($uri, $file, $params);
        if (!empty($sendData['error'])) {
            return $sendData;
        }

        return $this->sendRequest('/merchant_resource/hls/playlist/json', $sendData);
    }

    /**
     * 获取商品资源播放流数据
     *
     * @return array()
     */
    public function getProductHlsStream($uri, $file, $params)
    {
        $sendData = $this->generateResourcesParams($uri, $file, $params);
        if (!empty($sendData['error'])) {
            return $sendData;
        }

        return $this->sendRequest('/merchant_resource/hls/stream', $sendData);
    }

    /**
     * 获取商品资源播放流数据
     *
     * @return array()
     */
    public function getProductHlsClefPlus($uri, $file, $params)
    {
        $sendData = $this->generateResourcesParams($uri, $file, $params);
        if (!empty($sendData['error'])) {
            return $sendData;
        }

        return $this->sendRequest('/merchant_resource/hls/clef_plus', $sendData);
    }

    /**
     * 获取商品资源的信息
     *
     * @return array()
     */
    public function getProductResource($uri, $file, $params)
    {
        $sendData = $this->generateResourcesParams($uri, $file, $params);
        if (!empty($sendData['error'])) {
            return $sendData;
        }
        $sendData['params']['resourceNo'] = $sendData['resourceNo'];

        return $this->sendRequest('/merchant_resource/detail', $sendData);
    }

    /**
     * 获取商品资源的播放信息
     *
     * @return array()
     */
    public function getProductResourcePlayer($uri, $file, $params)
    {
        $sendData = $this->generateResourcesParams($uri, $file, $params);
        if (!empty($sendData['error'])) {
            return $sendData;
        }
        $sendData['params']['resourceNo'] = $sendData['resourceNo'];

        return $this->sendRequest('/merchant_resource/player', $sendData);
    }

    /**
     * 获取商品资源的下载信息
     *
     * @return array()
     */
    public function getProductResDownload($uri, $file, $params)
    {
        $sendData = $this->generateResourcesParams($uri, $file, $params);
        if (!empty($sendData['error'])) {
            return $sendData;
        }
        $sendData['params']['resourceNo'] = $sendData['resourceNo'];

        return $this->sendRequest('/merchant_resource/download', $sendData);
    }

    /**
     * 获取商品资源的播放JWT加密token
     *
     * @return string token
     */
    public function getProductResourceJWTPlayToken($no, $lifetime = 600, $payload = array())
    {
        if (empty($no)) {
            return '';
        }

        $sendData = array(
            'resourceNo' => $no,
            'lifetime' => $lifetime,
            'payload' => $payload,
        );
        $tokenData = $this->sendRequest('/merchant_resource/make_jwt_play_token', $sendData, 'POST');

        return $tokenData['JWTPlayToken'];
    }

    /*以下是live相关*/
    private $merchantLivePrefix = '/merchant_live';

    public function isLiveAvailableRecord($liveId)
    {
        $body = array(
            'liveId' => $liveId,
        );

        return $this->sendRequest($this->merchantLivePrefix.'/check_record_available', $body, 'GET');
    }

    public function getLiveRoomMaxOnline($liveId)
    {
        $body = array(
            'liveId' => $liveId,
        );

        return $this->sendRequest($this->merchantLivePrefix.'/get_max_online', $body, 'GET');
    }

    public function getLiveEntryTicket($liveId, $entryUser = array())
    {
        $body = array(
            'liveId' => $liveId,
            'entryUser' => $entryUser
        );

        return $this->sendRequest($this->merchantLivePrefix.'/create_entry_ticket', $body, 'POST');
    }

    public function consumeLiveEntryTicket($liveId, $ticketNo)
    {
        $body = array(
            'liveId' => $liveId,
            'ticketNo' => $ticketNo
        );

        return $this->sendRequest($this->merchantLivePrefix.'/consume_entry_ticket', $body, 'POST');
    }

    public function entryLiveReplay($roomParams)
    {
        return $this->sendRequest($this->merchantLivePrefix.'/entry_live_replay', $roomParams, 'POST');
    }

    public function createLiveReplayList($liveId)
    {
        $body = array(
            'liveId' => $liveId,
        );

        return $this->sendRequest($this->merchantLivePrefix.'/create_live_replays', $body, 'POST');
    }

    public function createAppLiveReplayList($liveId, $roomParams)
    {
        $roomParams['liveId'] = $liveId;

        return $this->sendRequest($this->merchantLivePrefix.'/create_app_live_replays', $roomParams, 'POST');
    }

    public function getLiveRoomCheckinList($liveId)
    {
        $body = array(
            'liveId' => $liveId,
        );

        return $this->sendRequest($this->merchantLivePrefix.'/get_room_checkin_list', $body, 'POST');
    }

    public function getLiveRoomHistory($liveId)
    {
        $body = array(
            'liveId' => $liveId,
        );

        return $this->sendRequest($this->merchantLivePrefix.'/get_room_history', $body, 'POST');
    }

    /**
     * =======================题库相关=========================
     */

    private $itemBnakRoutePrefix = '/item_bank';

    public function showAssessment($assessmentId)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix.'/assessment/' .$assessmentId. '/show', [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }
        
        throw new SDKException('request fail');
    }

    public function getAssessment($assessmentId)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix.'/assessment/' .$assessmentId, [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function drawAssessment($range, $sections)
    {
        $data = [
            'range' => $range,
            'sections' => $sections
        ];

        $result = $this->sendRequest($this->itemBnakRoutePrefix.'/assessment/draw_items', $data, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function createAssessment($assessment)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix.'/assessment/create', $assessment, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function openAssessment($assessmentId)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/assessment/{$assessmentId}/open", [], 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function getLatestAnswerRecord($answerSceneId, $userId)
    {

        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer/answer_scene_id/{$answerSceneId}/user/{$userId}", [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function getNextReviewingAnswer($answerSceneId)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/next_answer/answer_scene_id/{$answerSceneId}", [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function startAnswer($answerSceneId, $mediaId, $userId)
    {
        $data = [
            'answerSceneId' => $answerSceneId,
            'assessmentId' => $mediaId,
            'userId' => $userId
        ];
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer/start", $data, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function getAssessmentResponseByAnswerRecordId($answerRecordId)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/assessment/response/record/{$answerRecordId}", [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function getAnswerRecord($answerRecordId)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer_record/{$answerRecordId}", [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function continueAnswer($answerRecordId)
    {

        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer/{$answerRecordId}/continue", [], 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function submitAnswer($assessmentResponse)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer/submit", $assessmentResponse, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function saveAnswer($assessmentResponse)
    {

        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer/save", $assessmentResponse, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function reviewAnswer($reviewReport)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer/review", $reviewReport, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function getAnswerReport($answerReportId)
    {

        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer_report/{$answerReportId}/get", [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function getAnswerScene($answerSceneId)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer_scene/{$answerSceneId}", [], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function countAnswerRecord($conditions)
    {

        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer_record/count", $conditions, 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function searchAnswerRecord($conditions, $orderBy, $start, $limit)
    {
        $data = [
            'conditions' => $conditions,
            'orderBy' => $orderBy,
            'start' => $start,
            'limit' => $limit
        ];
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer_record/search", $data, 'GET');
        
        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function searchQuestionFavorite($conditions, $orderBy, $start, $limit)
    {
        $data = [
            'conditions' => $conditions,
            'orderBy' => $orderBy,
            'start' => $start,
            'limit' => $limit
        ];
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/question/favorites", $data, 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function createQuestionFavorite($questionFavorite)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/question/favorite/create", $questionFavorite, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function deleteByQuestionFavorite($questionFavorite)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/question/favorite/delete", $questionFavorite, 'POST');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function findAssessmentsByIds($ids)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/assessment/find", ['ids' => $ids], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    public function findAnswerReport($ids)
    {
        $result = $this->sendRequest($this->itemBnakRoutePrefix."/answer_report/find", ['ids' => $ids], 'GET');

        if (!empty($result['status']) && $result['status'] = 'success') {
            return $result['data'];
        }

        throw new SDKException('request fail');
    }

    /**
     * 生成调用商品资源类接口的基础参数
     *
     * @param string $uri    访问的路由
     * @param array  $file   资源文件内容
     * @param array  $params 额外参数数组
     *
     * @return array()
     */
    protected function generateResourcesParams($uri, $file, $params)
    {
        $this->logger->info('调用接口uri: '.$uri.' start');
        if (empty($uri) || empty($file) || !isset($file['sourceTargetId'])) {
            $this->logger->error('generateResourcesParams error: params missing', array('uri' => $uri, 'file' => $file, 'params' => $params));

            return $this->createErrorResult();
        }
        try {
            $sendData = array(
                'resourceNo' => $file['globalId'],
                'uri' => $uri,
                'productType' => 'course',
                'productId' => $file['sourceTargetId'],
                'params' => empty($params) ? array() : $params,
            );
        } catch (\Exception $e) {
            $this->logger->error('generateResourcesParams failed: '.$e->getMessage(), array('uri' => $uri, 'file' => $file, 'params' => $params));

            return $this->createErrorResult();
        }

        return $sendData;
    }

    protected function getRequestUri($uri, $protocol = 'https', $node = 'root')
    {
        if (!in_array($protocol, array('http', 'https', 'auto'))) {
            throw new SDKException("The protocol parameter must be in 'http', 'https', 'auto', your value is '{$protocol}'.");
        }

        if ('leaf' == $node) {
            $host = empty($this->leafHost) ? $this->host : $this->leafHost;
        }

        $host= $this->host;

        if (is_array($host)) {
            shuffle($host);
            reset($host);
            $host = current($host);
        }

        $host = (string) $host;

        if (!$host) {
            throw new SDKException('API host is not exist or invalid.');
        }

        $uri = ('/' !== substr($uri, 0, 1) ? '/' : '').$uri;

        return ('https://').$host.$uri;
    }

    private function sendRequest($uri, $data, $requestMethod = 'GET')
    {
        try {
            $this->logger->info('try visit '.$uri.': ', array('DATA' => $data));
            $result = $this->request($requestMethod, $uri, $data, $this->getDefaultHeaders());
            $this->logger->info('visit '.$uri.' SUCCEED', array($result));
        } catch (\Exception $e) {
            $this->logger->error('visit '.$uri.' error: '.$e->getMessage(), array('DATA' => $data));

            return $this->createErrorResult($e->getMessage());
        }

        return $result;
    }

    protected function createErrorResult($message = 'unexpected error')
    {
        return array('error' => $message);
    }

    /**
     * @return ProductService
     */
    protected function getProductService()
    {
        return $this->biz->service('ProductService');
    }

    private function getDefaultHeaders()
    {
        $isCTProject = class_exists('\CorporateTrainingBundle\System');
        if ($isCTProject) {
            return array(
                'BSystem' => 'ct',
                'BSystemVersion' => \CorporateTrainingBundle\System::CT_VERSION
            );
        }

        $isESProject = class_exists('\AppBundle\System');
        if ($isESProject) {
            return array(
                'BSystem' => 'es',
                'BSystemVersion' => \AppBundle\System::VERSION
            );
        }

        return array(
            'BSystem' => 'un',
            'BSystemVersion' => 0
        );
    }
}
