<?php


namespace Xcrms\Alipay\Tool;


use Xcrms\Alipay\Api;
use Xcrms\Alipay\Enum\ResultCode;
use Xcrms\Alipay\Exception\AlipayException;

class Heartbeat
{

    public function syn($appid,$key_path,$biz){
        $config = [
            'appid'=>$appid,
            'key_path'=>$key_path,
            'method'=>'monitor.heartbeat.syn'
        ];

        try{
            $result = Api::heartbeatSyn($config, $biz);
        }catch (Exception $e){
            throw $e;
        }
        if($result['code']!=ResultCode::SUCCESS){
            throw new AlipayException($result['sub_msg']);
        }
        return $result;
    }
}