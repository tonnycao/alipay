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
     * @todo ��ǩ
     * @param $key_path
     * @return bool
     */
    public function validSign($key_path)
    {
       $flag = false;
       return $flag;
    }
    /**
     * @todo ����Logger
     * @return null
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /***
     * @todo ��ȡԭʼ����
     * @return null
     */
    public function getRawPost()
    {
        return $this->raw_post;
    }

    /***
     * @todo ��ȡ������
     * @return null
     */
    public function getResult()
    {
        return $this->result;
    }

    /***
     * @todo ��ӡ�ɹ�
     */
    public function success(){
        echo 'success';
    }

    /**
     * @todo ��ӡʧ��
     */
    public function fail(){
        echo 'fail';
    }
}