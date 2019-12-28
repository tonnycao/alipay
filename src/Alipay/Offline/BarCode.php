<?php


namespace Xcrms\Alipay\Offline;

use Xcrms\Alipay\Alipay;
use Xcrms\Alipay\Api;
use Xcrms\Alipay\Enum\ResultCode;
use Xcrms\Alipay\Exception\AlipayException;
use Xcrms\Alipay\Exception\CurlException;
use Xcrms\Alipay\Exception\InvalidSignException;
use Xcrms\Alipay\Exception\ParamException;
use Xcrms\Alipay\Exception\EncryptException;
use Exception;

/***
 * @todo 条码支付
 * Class BarCode
 * @package Xcrms\Alipay\Offline
 */
class BarCode extends Alipay
{
    const SCENE = 'bar_code';

    /***
     * @param $config
     * @param $biz
     * @return mixed
     * @throws ParamException
     * @throws AlipayException
     *@todo 下单
     */
    public function pay($config,$biz){
        if(empty($biz['out_trade_no'])){
           throw new ParamException('订单号为空');
        }
        if(empty($biz['auth_code'])){
            throw new ParamException('支付码为空');
        }
        if(empty($biz['subject'])){
            throw new ParamException('订单说明为空');
        }
        if(empty($biz['total_amount'])){
            throw new ParamException('订单金额为空');
        }
        $biz['scene'] = self::SCENE;
        $config['method'] = 'alipay.trade.pay';
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