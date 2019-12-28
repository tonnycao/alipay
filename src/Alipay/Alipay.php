<?php


namespace Xcrms\Alipay;


use Xcrms\Alipay\Enum\ResultCode;
use Xcrms\Alipay\Exception\AlipayException;
use Xcrms\Alipay\Exception\CurlException;
use Xcrms\Alipay\Exception\EncryptException;
use Xcrms\Alipay\Exception\InvalidSignException;
use Xcrms\Alipay\Exception\ParamException;

class Alipay
{
    protected $logger = NULL;

    public function __construct($logger)
    {
        $this->logger = $logger;
        Api::setLogger($this->logger);
    }

    /**
     * @param $config
     * @param $biz
     * @return mixed
     * @throws CurlException
     * @throws EncryptException
     * @throws InvalidSignException
     * @throws ParamException
     * @throws AlipayException
     *@todo ��ѯ����״̬
     */
    public function query($config,$biz){
        $config['method'] = 'alipay.trade.query';
        if(empty($biz['out_trade_no'])){
            throw new ParamException('������Ϊ��');
        }

        try{
            $result =  Api::query($config,$biz);
        }catch (Exception $e){
            throw $e;
        }

        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }

        return $result;
    }

    /***
     * @param $config
     * @param $biz
     * @return mixed
     * @throws AlipayException
     * @throws CurlException
     * @throws EncryptException
     * @throws InvalidSignException
     * @throws ParamException
     *@todo ��������
     */
    public function cancel($config,$biz){

        if(empty($biz['trade_no']) && empty($biz['out_trade_no'])){
            throw new ParamException('������Ϊ��');
        }
        $config['method'] = 'alipay.trade.cancel';

        try{
            $result =  Api::query($config,$biz);
        }catch (CurlException $e){
            throw $e;
        }catch (EncryptException $e){
            throw $e;
        }catch (InvalidSignException $e){
            throw $e;
        }catch (Exception $e){
            throw $e;
        }
        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }
        return $result;
    }

    /***
     * @param $config
     * @param $biz
     * @return mixed
     * @throws AlipayException
     * @throws CurlException
     * @throws EncryptException
     * @throws InvalidSignException
     * @throws ParamException
     *@todo �˿�
     */
    public function refund($config, $biz)
    {
        $no = $biz['out_trade_no'];

        if(!empty($biz['trade_no'])){
            $no = $biz['trade_no'];
        }
        if(empty($no)){
            throw new ParamException('������Ϊ��');
        }
        if(empty($biz['refund_amount'])){
            throw new ParamException('�˿���Ϊ��');
        }
        if(empty($biz['out_request_no'])){
            throw new ParamException('�˿������Ϊ��');
        }
        if(empty($biz['refund_currency'])){
            $biz['refund_currency'] = 'CNY';
        }
        if(empty($biz['refund_reason'])){
            $biz['refund_reason'] = '�˿�'.$biz['refund_amount'].'Ԫ';
        }
        $config['method'] = 'alipay.trade.refund';

        try{
            $result =  Api::refund($config,$biz);
        }catch (CurlException $e){
            throw $e;
        }catch (EncryptException $e){
            throw $e;
        }catch (InvalidSignException $e){
            throw $e;
        }catch (Exception $e){
            throw $e;
        }
        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }
        return $result;
    }

    /**
     * @todo �رն���
     * @param $config
     * @param $biz
     * @return mixed
     * @throws AlipayException
     * @throws ParamException
     */
    public function close($config, $biz)
    {
        $config['method'] = 'alipay.trade.close';
        if(empty($config['app_id'])){
            throw new ParamException('Ӧ��IDΪ��');
        }
        if(empty($biz['out_trade_no'])||empty($biz['trade_no'])){
            throw new ParamException('�������Ϊ��');
        }

        try{
            $result = Api::close($config, $biz);
        }catch (Exception $e){
            throw $e;
        }

        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }
        return $result;

    }

    public function refundQuery($config, $biz){
        $config['method'] = 'alipay.trade.fastpay.refund.query';
        if(empty($biz['out_trade_no'])&&empty($biz['trade_no'])){
            throw new ParamException('������Ϊ��');
        }
        if(empty($biz['out_request_no'])){
            throw new ParamException('������Ϊ��');
        }
        try{
            $result = Api::refundQuery($config, $biz);
        }catch (Exception $e){
            throw $e;
        }

        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }
        return $result;
    }
}