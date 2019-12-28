<?php


namespace Xcrms\Alipay\Exception;


class InvalidSignException extends \Exception
{
    const CODE = 5;
    public function __construct($message = "")
    {
        parent::__construct($message, self::CODE);
    }
}