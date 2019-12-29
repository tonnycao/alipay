<?php


namespace Xcrms\Alipay\Offline;

use Xcrms\Alipay\Alipay;
use Xcrms\Alipay\Api;
use Xcrms\Alipay\Enum\ResultCode;
use Xcrms\Alipay\Exception\AlipayException;
use Xcrms\Alipay\Exception\ParamException;

/***
 * @todo 扫码支付
 * Class QrCode
 * @package Xcrms\Alipay\Offline
 */
class QrCode extends Alipay
{

    const SCENE = 'qr_code';

    public function preCreate($config, $biz)
    {
        if(empty($biz['out_trade_no'])){
            throw new ParamException('订单号为空');
        }
        if(empty($biz['seller_id'])){
            throw new ParamException('卖家ID为空');
        }
        if(empty($biz['subject'])){
            throw new ParamException('订单说明为空');
        }
        if(empty($biz['total_amount'])){
            throw new ParamException('订单金额为空');
        }
        $config['method'] = 'alipay.trade.precreate';
        $biz['timeout_express'] = empty($config['timeout_express'])?'2m':$config['timeout_express'];
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