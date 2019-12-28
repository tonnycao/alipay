<?php


namespace Xcrms\Alipay\Enum;


class TradeStatus extends EnumBase
{
    const CLOSED = 'TRADE_CLOSED';
    const FINISHED = 'TRADE_FINISHED';
    const SUCCESS = 'TRADE_SUCCESS';
    const BUYER_PAY = 'WAIT_BUYER_PAY';

    const MAP = [
        self::BUYER_PAY=>'交易创建',
        self::CLOSED =>'交易关闭',
        self::SUCCESS=>'支付成功',
        self::FINISHED=>'交易完结'
    ];


}