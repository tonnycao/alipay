<?php


namespace Xcrms\Alipay\Exception;


class CurlException extends \Exception
{
    const CODE =2;

    public function __construct($message = "")
    {
        parent::__construct($message, self::CODE);
    }

}