<?php


namespace Xcrms\Alipay\Exception;


class EncryptException extends \Exception
{
    const CODE = 3;

    public function __construct($message = "")
    {
        parent::__construct($message, self::CODE);
    }
}