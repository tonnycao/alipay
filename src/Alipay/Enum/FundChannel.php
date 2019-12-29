<?php


namespace Xcrms\Alipay\Enum;


class FundChannel extends EnumBase
{

    const COUPON='Ö§¸¶±¦ºì°ü';
    const ALIPAYACCOUNT='Ö§¸¶±¦Óà¶î';
    const POINT='¼¯·Ö±¦';
    const DISCOUNT='ÕÛ¿ÛÈ¯';
    const PCARD='Ô¤¸¶¿¨';
    const FINANCEACCOUNT='Óà¶î±¦';
    const MCARD = 'ÉÌ¼Ò´¢Öµ¿¨';
    const MDISCOUNT='ÉÌ»§ÓÅ»ÝÈ¯';
    const MCOUPON='ÉÌ»§ºì°ü';
    const PCREDIT='ÂìÒÏ»¨ßÂ';

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