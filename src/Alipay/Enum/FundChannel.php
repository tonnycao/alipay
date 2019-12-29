<?php


namespace Xcrms\Alipay\Enum;


class FundChannel extends EnumBase
{

    const COUPON='֧�������';
    const ALIPAYACCOUNT='֧�������';
    const POINT='���ֱ�';
    const DISCOUNT='�ۿ�ȯ';
    const PCARD='Ԥ����';
    const FINANCEACCOUNT='��';
    const MCARD = '�̼Ҵ�ֵ��';
    const MDISCOUNT='�̻��Ż�ȯ';
    const MCOUPON='�̻����';
    const PCREDIT='���ϻ���';

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