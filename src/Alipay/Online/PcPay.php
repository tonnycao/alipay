<?php


namespace Xcrms\Alipay\Online;


use Exception;
use Xcrms\Alipay\Alipay;
use Xcrms\Alipay\Api;
use Xcrms\Alipay\Enum\ResultCode;
use Xcrms\Alipay\Exception\AlipayException;
use Xcrms\Alipay\Exception\ParamException;

/***
 * @todo PC在线支付
 * Class PcPay
 * @package Xcrms\Alipay\Online
 */
class PcPay extends Alipay
{

    public function pay($config, $biz)
    {
        $config['method'] = 'alipay.trade.page.pay';
        if(empty($biz['out_trade_no'])){
            throw new ParamException('订单号为空');
        }
        if(empty($biz['product_code'])){
            throw new ParamException('产品编码为空');
        }
        if(empty($biz['subject'])){
            throw new ParamException('订单说明为空');
        }
        if(empty($biz['total_amount'])){
            throw new ParamException('订单金额为空');
        }

        $biz['timeout_express'] = empty($config['timeout_express'])?'10m':$config['timeout_express'];
        try{
            $result = Api::pay($config,$biz);
        }catch (Exception $e){
            throw $e;
        }

        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }

        return $result;
    }
}