<?php


namespace Xcrms\Alipay\Notify;


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

    }

    /**
     * @todo 验签
     * @param $key_path
     * @return bool
     */
    public function validSign($key_path)
    {
       $flag = false;
       return $flag;
    }
    /**
     * @todo 返回Logger
     * @return null
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /***
     * @todo 获取原始数据
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
     * @todo 打印成功
     */
    public function success(){
        echo 'success';
    }

    /**
     * @todo 打印失败
     */
    public function fail(){
        echo 'fail';
    }
}