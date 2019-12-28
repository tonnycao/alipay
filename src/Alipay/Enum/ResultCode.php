<?php


namespace Xcrms\Alipay\Enum;


class ResultCode extends EnumBase
{
    const SUCCESS = 10000;
    const FAIL = 40004;
    const WAIT_BUYER_PAY = 10003;
    const UNKNOWN = 20000;

    const MAP = [
        self::SUCCESS=>'支付成功',
        self::FAIL=>'支付失败',
        self::WAIT_BUYER_PAY=>'等待用户付款',
        self::UNKNOWN=>'未知异常'
    ];
}