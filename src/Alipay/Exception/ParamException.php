<?php


namespace Xcrms\Alipay\Exception;


class ParamException extends \Exception
{
    const CODE = 4;

    public function __construct($message = "")
    {
        parent::__construct($message, self::CODE);
    }
}