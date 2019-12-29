<?php


namespace Xcrms\Alipay\Enum;


class SubCode extends EnumBase
{

    const MAP = [
        'AQC.SYSTEM_ERROR'=>'系统错误',
        'ACQ.INVALID_PARAMETER'=>'参数无效',
        'ACQ.SELLER_BALANCE_NOT_ENOUGH'=>'商户的支付宝账户中无足够的资金进行撤销',
        'ACQ.REASON_TRADE_BEEN_FREEZEN'=>'当前交易被冻结，不允许进行撤销',
        'ILLEGAL_ARGUMENT'=>'授权失败，预授权冻结参数异常或参数缺失，请顾客刷新付款码后重新收款',
        'EXIST_FORBIDDEN_WORD'=>'授权失败，订单信息中包含违禁词',
        'ACCESS_FORBIDDEN'=>'授权失败，本商户没有权限使用该产品，建议顾客使用其他方式付款',
        'UNIQUE_VIOLATION'=>'授权失败，商户订单号重复，请收银员取消本笔订单并重新授权',
        'PAYER_USER_STATUS_LIMIT'=>'授权失败，顾客账户暂时无法支付，建议顾客使用其他方式付款',
        'PAYER_NOT_EXIST'=>'授权失败，获取顾客账户信息失败，请顾客刷新付款码后重新收款',
        'PAYMENT_AUTH_CODE_INVALID'=>'授权失败，获取顾客账户信息失败，请顾客刷新付款码后重新收款，如再次授权失败',
        'MONEY_NOT_ENOUGH'=>'授权失败，顾客余额不足，建议顾客充值完成后再进行付款',
        'ORDER_ALREADY_CLOSED'=>'授权失败，本笔授权订单已关闭',
        'FREEZE_ALREADY_SUCCESS'=>'授权失败，授权订单已经冻结成功，请勿重复授权',
        'ERROR_BALANCE_PAYMENT_DISABLE'=>'授权失败，顾客余额支付功能开关关闭，请用户打开余额支付功能开关',
        'PULL_MOBILE_CASHIER_FAIL'=>'授权失败，顾客手机唤起收银台失败，请顾客检查手机网络，刷新付款码后重新预授权，并让顾客在付款码页面等待确认',
        'USER_FACE_PAYMENT_SWITCH_OFF'=>'授权失败，顾客当面付付款开关关闭，请用户在手机上打开当面付付款开关',
        'SYSTEM_ERROR'=>'系统错误',
        'ORDER_ALREADY_FINISH'=>'授权失败，本笔授权订单已经完结，无法再进行资金操作',
        'PAYEE_NOT_EXIST'=>'授权失败，收款方账号不存在',
        'PAYEE_USER_STATUS_LIMIT'=>'授权失败，收款方账号异常',
        'PAYER_PAYEE_EQUAL'=>'授权失败，收付款方信息不能相同',
        'NO_PAYMENT_INSTRUMENTS_AVAILABLE'=>'授权失败，用户没用可用的支付工具',
        'CLIENT_VERSION_NOT_MATCH'=>'授权失败，顾客手机支付宝客户端版本过低，请更新到最新版本',
        'UNSUPPORT_ORDER_AMOUNT'=>'不支持的订单金额',
        'FORBIDDEN_MERCHANT_INDUSTRY'=>'订单所属行业MCC被拦截',
        'CURRENCY_VERIFICATION_FAIL'=>'币种校验失败',
        'RESTRICTED_MERCHANT_INDUSTRY'=>'商户所属行业MCC单笔订单金额限制',
        'FOREX_ID_VERIFICATION_FAIL'=>'用户身份校验失败',
        'PRODUCT_AMOUNT_LIMIT_ERROR'=>'购汇额度校验失败',
        'SECONDARY_MERCHANT_STATUS_ERROR'=>'商户状态异常',
        'USER_IDENTITY_INFO_VALIDATE_FAIL'=>'用户信息校验失败',
        'USER_ACCOUNT_VALIDATE_FAIL'=>'用户账号校验失败',
        'SUB_MERCHANT_ORG_ID_ERROR'=>'间联模式下，传入的二级商户的机构id为空或错误',
        'SUB_MERCHANT_LEVEL_ERROR'=>'间联商户等级校验错误',
        'SUB_MERCHANT_NO_PERMISSION'=>'间联商户无权使用该产品'
    ];

    public static  function getMsg($code){
            return isset(self::MAP[$code])?self::MAP[$code]:'未知';
    }
}