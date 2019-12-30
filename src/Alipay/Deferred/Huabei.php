<?php


namespace Xcrms\Alipay\Deferred;

use Xcrms\Alipay\Exception\ParamException;

/***
 * @todo 花呗分期
 * Class Huabei
 * @package Xcrms\Alipay\Deferred
 */
class Huabei
{
    //期数
    const NUM_MAP = [
        3,6,12
    ];

    //0用户承担 100商家承担
    const PERCENT_MAP = [0,100];
    public static function formatHbFeParam($num, $percent){
        if(empty($num) || !in_array($num,self::NUM_MAP,true)){
            throw new ParamException('期数为空');
        }

        if(strlen($percent)==0 || !in_array($percent,self::PERCENT_MAP,true)){
            throw new ParamException('卖家承担收费比例为空');
        }

        $data  =[
            'hb_fq_num'=>$num,
            'hb_fq_seller_percent'=>$percent
        ];
        return $data;
    }
}