<?php


namespace Xcrms\Alipay\Enum;


class FundChannel extends EnumBase
{

    const COUPON='支付宝红包';
    const ALIPAYACCOUNT='支付宝余额';
    const POINT='积分卡';
    const DISCOUNT='集分宝';
    const PCARD='预付卡';
    const FINANCEACCOUNT='余额宝';
    const MCARD = '商家储值卡';
    const MDISCOUNT='商户优惠券';
    const MCOUPON='商户红包';
    const PCREDIT='蚂蚁花呗';

    const MAP = [
        'COUPON'=>self::COUPON,
        'ALIPAYACCOUNT'=>self::ALIPAYACCOUNT,
        'POINT'=>self::POINT,
        'DISCOUNT'=>self::DISCOUNT,
        'PCARD'=>self::PCARD,
        'FINANCEACCOUNT'=>self::FINANCEACCOUNT,
        'MCARD'=>self::MCARD,
        'MDISCOUNT'=>self::MDISCOUNT,
        'MCOUPON'=>self::MCOUPON,
        'PCREDIT'=>self::PCREDIT
    ];

}