<?php


namespace Xcrms\Alipay\Enum;


class SubCode extends EnumBase
{

    const MAP = [
            'AQC.SYSTEM_ERROR'=>'系统错误',
            'ACQ.INVALID_PARAMETER'=>'参数无效',
            'ACQ.SELLER_BALANCE_NOT_ENOUGH'=>'商户的支付宝账户中无足够的资金进行撤销',
            'ACQ.REASON_TRADE_BEEN_FREEZEN'=>'当前交易被冻结，不允许进行撤销',
    ];

    public static  function getMsg($code){
            return isset(self::MAP[$code])?self::MAP[$code]:'未知';
    }
}