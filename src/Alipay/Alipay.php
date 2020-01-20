<?php


namespace Xcrms\Alipay;


use Xcrms\Alipay\Enum\ResultCode;
use Xcrms\Alipay\Exception\AlipayException;
use Xcrms\Alipay\Exception\ParamException;

class Alipay
{
    protected $logger = NULL;

    public function __construct($logger)
    {
        $this->logger = $logger;
        Api::setLogger($this->logger);
    }

    /***
     * @todo 统一下单
     * @param $config
     * @param $biz
     * @return mixed
     * @throws AlipayException
     * @throws ParamException
     */
    public function creat($config,$biz){
        $config['method'] = 'alipay.trade.create';
        if(empty($biz['out_trade_no'])){
            throw new ParamException('订单编号为空');
        }

        if(empty($biz['total_amount'])){
            throw new ParamException('交易金额为空');
        }
        if(empty($biz['subject'])){
            throw new ParamException('订单标题为空');
        }
        try{
            $result =  Api::create($config,$biz);
        }catch (Exception $e){
            throw $e;
        }

        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }

        return $result;
    }
    /**
     * @todo 查询订单状态
     * @param $config
     * @param $biz
     * @return mixed
     * @throws Exception
     * @throws ParamException
     * @throws AlipayException
     *
     */
    public function query($config,$biz){
        $config['method'] = 'alipay.trade.query';
        if(empty($biz['out_trade_no'])){
            throw new ParamException('订单编号为空');
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
     * @todo 需求订单
     * @param $config
     * @param $biz
     * @return mixed
     * @throws AlipayException
     * @throws ParamException
     *
     */
    public function cancel($config,$biz){

        if(empty($biz['trade_no']) && empty($biz['out_trade_no'])){
            throw new ParamException('订单号为空');
        }
        $config['method'] = 'alipay.trade.cancel';

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
     * @todo  退款
     * @param $config
     * @param $biz
     * @return mixed
     * @throws AlipayException
     * @throws Exception
     * @throws ParamException
     */
    public function refund($config, $biz)
    {
        $no = $biz['out_trade_no'];

        if(!empty($biz['trade_no'])){
            $no = $biz['trade_no'];
        }
        if(empty($no)){
            throw new ParamException('订单号为空');
        }
        if(empty($biz['refund_amount'])){
            throw new ParamException('退款金额为空');
        }
        if(empty($biz['out_request_no'])){
            throw new ParamException('请求编号为空');
        }
        if(empty($biz['refund_currency'])){
            $biz['refund_currency'] = 'CNY';
        }
        if(empty($biz['refund_reason'])){
            $biz['refund_reason'] = '退款'.$biz['refund_amount'].'元';
        }
        $config['method'] = 'alipay.trade.refund';

        try{
            $result =  Api::refund($config,$biz);
        }catch (Exception $e){
            throw $e;
        }
        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }
        return $result;
    }

    /**
     * @todo 关闭订单
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
            throw new ParamException('应用ID为空');
        }
        if(empty($biz['out_trade_no'])||empty($biz['trade_no'])){
            throw new ParamException('订单号为空');
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

    /**
     * @todo 退款查询
     * @param $config
     * @param $biz
     * @return mixed
     * @throws AlipayException
     * @throws ParamException
     */
    public function refundQuery($config, $biz){
        $config['method'] = 'alipay.trade.fastpay.refund.query';
        if(empty($biz['out_trade_no'])&&empty($biz['trade_no'])){
            throw new ParamException('订单号为空');
        }
        if(empty($biz['out_request_no'])){
            throw new ParamException('请求编号为空');
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