<?php


namespace Xcrms\Alipay\Notify;


use Xcrms\Alipay\Exception\InvalidSignException;
use Xcrms\Alipay\Util;

class NotifyBase
{
    protected $raw_post = NULL;
    protected $result = NULL;

    protected $logger = NULL;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function  handler()
    {
        $post = file_get_contents('php://input');
        $this->raw_post = $post;
        $this->result = $post;
    }

    /**
     * @todo 验签
     * @param $key_path
     * @return bool
     * @throws InvalidSignException
     */
    public function validSign($key_path)
    {
       $flag = false;
       $sign = base64_decode($this->raw_post['sign']);
       $post = [];
       foreach ($this->raw_post as $key=>$value){
           if($key !='sign' && $key !='sign_type' && $value!='' && !is_array($value)){
               $post[$key] =  urlencode($value);
           }
       }
       $params = Util::toUrlParams($post);
       $make_sign = Util::makeSignRsa2($params,$key_path);
       if(!$make_sign){
           throw new InvalidSignException('验签失败');
       }
       if($sign == $make_sign){
           $flag = true;
       }
       return $flag;
    }
    /**
     * @todo 设置Logger
     * @return null
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /***
     * @todo 获取源数据
     * @return null
     */
    public function getRawPost()
    {
        return $this->raw_post;
    }

    /***
     * @todo 获取处理结果
     * @return null
     */
    public function getResult()
    {
        return $this->result;
    }

    /***
     * @todo 成功
     */
    public function success(){
        echo 'success';
    }

    /**
     * @todo 失败
     */
    public function fail(){
        echo 'fail';
    }
}