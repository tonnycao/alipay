<?php


namespace Xcrms\Alipay\Enum;


class ResultCode extends EnumBase
{
    const SUCCESS = 10000;
    const MISS = 40001;
    const INVALID = 40002;
    const FAIL = 40004;
    const PERMISSION=40006;
    const WAIT_BUYER_PAY = 10003;
    const UNKNOWN = 20000;
    const AUTH = 20001;
    const MAP = [
        self::SUCCESS=>'支付成功',
        self::FAIL=>'支付失败',
        self::WAIT_BUYER_PAY=>'等待用户付款',
        self::UNKNOWN=>'未知异常',
        self::PERMISSION=>'权限不足',
        self::INVALID=>'非法的参数',
        self::MISS=>'缺少参数',
        self::AUTH=>'授权权限不足'
    ];
}