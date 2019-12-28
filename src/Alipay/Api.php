<?php


namespace Xcrms\Alipay;

use Xcrms\Alipay\Enum\CurleError;
use Xcrms\Alipay\Exception\CurleException;
use Xcrms\Alipay\Exception\EncryptException;
use Xcrms\Alipay\Exception\InvalidSignException;

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

    public static function pay($config,$biz_content)
    {
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
        $biz_params = json_encode($biz_params);

        $common_data = self::initCommon($config);
        if(!empty($config['need_encrypt']) && !empty($config['encrypt_key'])){
            $common_data['encrypt_type'] = 'AES';
            $biz_params = Util::encrypt($biz_params,$config['encrypt_key']);
            if(!$biz_params){
                throw new EncryptException('AES加密失败');
            }
        }
        $params = $common_data;
        $params['biz_content'] = $biz_params;
        $params_str = Util::toUrlParams($params);
        $sign = Util::makeSignRsa2($params_str, $config['key_path']);
        if($sign){
            throw new EncryptException('RSA2签名失败');
        }
        $params['sign'] =  $sign;

        try{
           $result =  self::postCurl($params);
        }catch (CurleException $e){
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

    public static function query($config,$biz_content)
    {
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
        $common_data = self::initCommon($config);

        $params = $common_data;
        $params['biz_content'] = $biz_params;
        $params_str = Util::toUrlParams($params);
        $sign = Util::makeSignRsa2($params_str, $config['key_path']);
        if(!$sign){
            throw new EncryptException('RSA2签名失败');
        }
        $params['sign'] =  $sign;
        try{
            $result =  self::postCurl($params);
        }catch (CurleException $e){
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

    public static function cancel($config,$biz_content){
        $biz_params = [];
        if(!empty($biz_content['out_trade_no'])) {
            $biz_params['out_trade_no'] = $biz_content['out_trade_no'];
        }
        if(!empty($biz_content['trade_no'])){
            $biz_params['trade_no'] = $biz_content['trade_no'];
        }

        $common_data = self::initCommon($config);

        $params = $common_data;
        $params['biz_content'] = $biz_params;
        $params_str = Util::toUrlParams($params);
        $sign = Util::makeSignRsa2($params_str, $config['key_path']);
        if(!$sign){
            throw new EncryptException('RSA2签名失败');
        }
        $params['sign'] =  $sign;
        try{
            $result =  self::postCurl($params);
        }catch (CurleException $e){
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

    public static function refund($config,$biz_content)
    {
        $biz_params = [];
        if(!empty($biz_content['out_trade_no'])) {
            $biz_params['out_trade_no'] = $biz_content['out_trade_no'];
        }
        if(!empty($biz_content['trade_no'])){
            $biz_params['trade_no'] = $biz_content['trade_no'];
        }

        $common_data = self::initCommon($config);

        $params = $common_data;
        $params['biz_content'] = $biz_params;
        $params_str = Util::toUrlParams($params);
        $sign = Util::makeSignRsa2($params_str, $config['key_path']);
        if(!$sign){
            throw new EncryptException('RSA2签名失败');
        }
        $params['sign'] =  $sign;
        try{
            $result =  self::postCurl($params);
        }catch (CurleException $e){
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

    public static function initCommon($config){
        $common_data = [
            'app_id'=>$config['app_id'],
            'notify_url'=>$config['notify_url'],
            'timestamp'=>date("Y-m-d H:i:s"),
            'method'=>$config['method'],
            'version'=>self::VERSION,
            'format'=>self::FORMAT,
            'charset'=>self::CHARSET,
            'sign_type'=>self::SIGN_TYPE
        ];
        if(!empty($config['app_auth_token'])){
            $common_data['app_auth_token'] = $config['app_auth_token'];
        }
        if(!empty($config['return_url'])){
            $common_data['return_url'] = $config['return_url'];
        }

        return $common_data;
    }

    public static function checkSign($config,$response){
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
     * @todo curl post请求
     * @param $data
     * @return bool|string
     */
    public static function postCurl($data)
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
                'errormsg'=>CurleError::getMsg($error)
            ];
            if(isset(self::$logger))
            {
                self::$logger->error(json_encode($msg));
            }
            throw new CurleException(CurleError::getMsg($error));
        }
    }
}