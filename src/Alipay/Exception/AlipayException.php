<?php


namespace Xcrms\Alipay\Exception;


class AlipayException  extends \Exception
{
    const CODE =1;

    public function __construct($message = "")
    {
        parent::__construct($message, self::CODE);
    }

}