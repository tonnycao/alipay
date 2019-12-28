<?php


namespace Xcrms\Alipay;

use Exception;
use Xcrms\Alipay\Enum\CurlError;
use Xcrms\Alipay\Exception\CurlException;
use Xcrms\Alipay\Exception\EncryptException;
use Xcrms\Alipay\Exception\InvalidSignException;
use Xcrms\Alipay\Exception\ParamException;

/***
 * @todo  支付接口类
 * Class Api
 * @package Xcrms\Alipay
 */
class Api
{
    const GATEWAY_URL = "https://openapi.alipay.com/gateway.do";
    const VERSION = 1.0;
    const SIGN_TYPE = "RSA2";
    const CHARSET = "UTF-8";
    const FORMAT = "JSON";

    protected static $logger = NULL;

    /***
     * @todo 下单
     * @param $config
     * @param $biz_content
     * @return mixed
     * @throws Exception
     */
    public static function pay($config,$biz_content)
    {
        if(empty($biz_content['out_trade_no'])){
            throw new ParamException('订单号为空');
        }
        if(empty($biz_content['scene'])){
            throw new ParamException('支付场景为空');
        }
        if(empty($biz_content['subject'])){
            throw new ParamException('订单说明为空');
        }
        if(empty($biz_content['total_amount'])){
            throw new ParamException('订单金额为空');
        }
        $biz_params = [
            'out_trade_no'=>$biz_content['out_trade_no'],
            'scene'=>$biz_content['scene'],
            'subject'=>$biz_content['subject'],
            'total_amount'=>$biz_content['total_amount'],
            'trans_currency'=>$biz_content['trans_currency']?$biz_content['trans_currency']:'CNY',
            'settle_currency'=>$biz_content['settle_currency']?$biz_content['settle_currency']:'CNY'
        ];
        if(!empty($biz_content['discountable_amount'])){
            $biz_params['discountable_amount'] = $biz_content['discountable_amount'];
        }
        if(!empty($biz_content['auth_code'])){
            $biz_params['auth_code'] = $biz_content['auth_code'];
        }
        if(!empty($biz_content['product_code'])){
            $biz_params['product_code'] = $biz_content['product_code'];
        }
        if(!empty($biz_content['buyer_id'])){
            $biz_params['buyer_id'] = $biz_content['buyer_id'];
        }
        if(!empty($biz_content['seller_id'])){
            $biz_params['seller_id'] = $biz_content['seller_id'];
        }
        if(!empty($biz_content['body'])){
            $biz_params['body'] = $biz_content['body'];
        }
        try{
            $params = self::prepareRequest($config,$biz_params);
        }catch (Exception $e){
            throw $e;
        }

        try{
            $return = self::request($config,$params);
        }catch (Exception $e){
            throw $e;
        }

        return $return;
    }


    /**
     * @todo 查询订单状态
     * @param $config
     * @param $biz_content
     * @return mixed
     * @throws ParamException
     */
    public static function query($config,$biz_content)
    {
        if(empty($config['method'])){
            throw new ParamException('接口名称为空');
        }
        if(empty($config['key_path'])){
            throw new ParamException('私钥为空');
        }
        $biz_params = [];
        if(!empty($biz_content['out_trade_no'])) {
            $biz_params['out_trade_no'] = $biz_content['out_trade_no'];
        }
        if(!empty($biz_content['trade_no'])){
            $biz_params['trade_no'] = $biz_content['trade_no'];
        }
        if(!empty($biz_content['org_pid'])){
            $biz_params['org_pid'] = $biz_content['org_pid'];
        }
        if(!empty($biz_content['query_options'])){
            $biz_params['query_options'] = $biz_content['query_options'];
        }

        try{
            $params = self::prepareRequest($config,$biz_params);
        }catch (Exception $e){
            throw $e;
        }

        try{
            $return =  self::request($config,$params);
        }catch (Exception $e){
            throw $e;
        }

        return $return;
    }

    /***
     * @todo 取消订单
     * @param $config
     * @param $biz_content
     * @return mixed
     * @throws Exception
     */
    public static function cancel($config,$biz_content){
        $biz_params = [];
        if(!empty($biz_content['out_trade_no'])) {
            $biz_params['out_trade_no'] = $biz_content['out_trade_no'];
        }
        if(!empty($biz_content['trade_no'])){
            $biz_params['trade_no'] = $biz_content['trade_no'];
        }

        try{
            $params = self::prepareRequest($config,$biz_params);
        }catch (Exception $e){
            throw $e;
        }

        try{
            $return =  self::request($config,$params);
        }catch (Exception $e){
            throw $e;
        }

        return $return;
    }

    /***
     * @todo 申请退款
     * @param $config
     * @param $biz_content
     * @return mixed
     * @throws ParamException
     */
    public static function refund($config,$biz_content)
    {
        $biz_params = array();

        if(!empty($biz_content['out_trade_no'])) {
            $biz_params['out_trade_no'] = $biz_content['out_trade_no'];
        }
        if(!empty($biz_content['trade_no'])){
            $biz_params['trade_no'] = $biz_content['trade_no'];
        }

        if(empty($biz_params['out_trade_no']) && empty($biz_params['trade_no'])){
            throw new ParamException('订单号为空');
        }

        try{
            $params = self::prepareRequest($config,$biz_params);
        }catch (Exception $e){
            throw $e;
        }

        try{
            $return = self::request($config, $params);
        }catch (Exception $e){
            throw $e;
        }

        return $return;
    }

    /***
     * @todo 关闭交易
     * @param $config
     * @param $biz_content
     * @return mixed
     * @throws ParamException
     */
    public static function  close($config, $biz_content)
    {

        $biz_params = array();
        if(!empty($biz_content['operator_id'])){
            $biz_params['operator_id'] = $biz_content['operator_id'];
        }

        if(!empty($biz_content['out_trade_no'])){
            $biz_params['out_trade_no'] = $biz_content['out_trade_no'];
        }

        if(!empty($biz_content['trade_no'])){
            $biz_params['trade_no'] = $biz_content['trade_no'];
        }

        if(empty($biz_params['out_trade_no']) && empty($biz_params['trade_no'])){
            throw new ParamException('订单号为空');
        }

        try{
            $params = self::prepareRequest($config,$biz_params);
        }catch (Exception $e){
            throw $e;
        }

        try{
            $return = self::request($config, $params);
        }catch (Exception $e){
            throw $e;
        }

        return $return;
    }

    /***
     * @todo 退款查询
     * @param $config
     * @param $biz_content
     * @return mixed
     * @throws ParamException
     */
    public static function refundQuery($config,$biz_content)
    {
        $biz_params = [];
        if(!empty($biz_content['org_pid'])){
            $biz_params['org_pid'] = $biz_content['org_pid'];
        }
        if(!empty($biz_content['trade_no'])){
            $biz_params['trade_no'] = $biz_content['trade_no'];
        }
        if(!empty($biz_content['out_trade_no'])){
            $biz_params['out_trade_no'] = $biz_content['out_trade_no'];
        }
        if(empty($biz_params['out_trade_no'])&&empty($biz_params['trade_no'])){
            throw new ParamException('订单号为空');
        }
        if(empty($biz_content['out_request_no'])){
            throw new ParamException('请求编号为空');
        }

        try{
            $params = self::prepareRequest($config,$biz_params);
        }catch (Exception $e){
            throw $e;
        }

        try{
            $return = self::request($config, $params);
        }catch (Exception $e){
            throw $e;
        }

        return $return;
    }

    /***
     * @todo 网络监控
     * @param $config
     * @param $biz
     * @return mixed
     * @throws Exception
     */
    public static function heartbeatSyn($config, $biz)
    {
        $biz_params = $biz;
        try{
            $params = self::prepareRequest($config,$biz_params);
        }catch (Exception $e){
            throw $e;
        }

        try{
            $return = self::request($config, $params);
        }catch (Exception $e){
            throw $e;
        }
        return $return;
    }

    /***
     * @todo 设置日志引擎
     * @param $logger
     */
    public static function setLogger($logger)
    {
        if(!isset(self::$logger))
        {
            self::$logger = $logger;
        }
    }

    /***
     * @todo 获取日志引擎
     * @return null
     */
    public static function getLogger()
    {
        return self::$logger;
    }

    /**
     * @param $config
     * @param $data
     * @return mixed
     * @throws CurlException
     * @throws InvalidSignException
     *@todo 发起请求
     */
    protected static function request($config, $data){
        try{
            $result =  self::postCurl($data);
        }catch (CurlException $e){
            throw $e;
        }
        try{
            $valid_sign = self::checkSign($config,$result);
        }catch (InvalidSignException $e){
            throw $e;
        }

        if(!$valid_sign){
            throw new InvalidSignException('RSA2验签失败');
        }
        $return = $result[$config['method'].'_response'];
        return $return;
    }

    /***
     * @todo 初始化公共参数
     * @param $config
     * @return array
     * @throws ParamException
     */
    protected static function initCommon($config){
        if(empty($config['app_id'])){
            throw new ParamException('APPID为空');
        }
        if(empty($config['method'])){
            throw new ParamException('接口名称为空');
        }

        $common_data = [
            'app_id'=>$config['app_id'],
            'timestamp'=>date("Y-m-d H:i:s"),
            'method'=>$config['method'],
            'version'=>self::VERSION,
            'format'=>self::FORMAT,
            'charset'=>self::CHARSET,
            'sign_type'=>self::SIGN_TYPE
        ];
        if(!empty($config['notify_url'])){
            $common_data['notify_url'] = $config['notify_url'];
        }
        if(!empty($config['app_auth_token'])){
            $common_data['app_auth_token'] = $config['app_auth_token'];
        }
        if(!empty($config['return_url'])){
            $common_data['return_url'] = $config['return_url'];
        }

        return $common_data;
    }

    /**
     * @todo 请求前预处理
     * @param $config
     * @param $biz_params
     * @return array
     * @throws EncryptException
     * @throws ParamException
     */
    protected static function prepareRequest($config,$biz_params)
    {
        $params = self::initCommon($config);

        if(!empty($config['need_encrypt'])){
            if(empty($config['encrypt_key'])){
                throw new ParamException('加密密钥为空');
            }
            $common_data['encrypt_type'] = 'AES';
            $biz_params = Util::encrypt($biz_params,$config['encrypt_key']);
            if(!$biz_params){
                throw new EncryptException('AES加密失败');
            }
        }
        $params['biz_content'] = json_encode($biz_params);
        $params_str = Util::toUrlParams($params);

        if(empty($config['key_path'])){
            throw new ParamException('私钥为空');
        }

        $sign = Util::makeSignRsa2($params_str, $config['key_path']);
        if(!$sign){
            throw new EncryptException('RSA2签名失败');
        }
        $params['sign'] =  $sign;
        return $params;
    }
    /***
     * @todo 验签
     * @param $config
     * @param $response
     * @return bool
     * @throws InvalidSignException
     */
    protected static function checkSign($config,$response){
        $method = $config['method'];
        $data = $response[$method.'_response'];
        $sign = $response['sign'];
        $params_str = Util::toUrlParams($data);
        $make_sign = Util::makeSignRsa2($params_str, $config['key_path']);
        if(!$make_sign){
            throw new InvalidSignException('RSA2验签失败');
        }
        if($sign==$make_sign){
            return true;
        }
        return false;
    }

    /***
     * @param $data
     * @return mixed
     * @throws CurlException
     *@todo post请求
     */
    protected static function postCurl($data)
    {

        $url = self::GATEWAY_URL;
        $ch = curl_init();
        $curlVersion = curl_version();
        $ua = "Alipay/".self::VERSION." (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version'];
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);//严格校验
        curl_setopt($ch,CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //运行curl
        $data = curl_exec($ch);
        if($data){
            if(isset(self::$logger))
            {
                self::$logger->debug($data);
            }
            curl_close($ch);
            return json_decode($data,true);
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            $msg = [
                'errorno'=>$error,
                'errormsg'=>CurlError::getMsg($error)
            ];
            if(isset(self::$logger))
            {
                self::$logger->error(json_encode($msg));
            }
            throw new CurlException(CurlError::getMsg($error));
        }
    }
}