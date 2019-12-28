<?php


namespace Xcrms\Alipay;

/***
 * @todo 工具类
 * Class Util
 * @package Xcrms\Alipay
 */
class Util
{

    /**
     * 从证书中提取公钥
     * @param $certPath
     * @return mixed
     */
    public static function getPublicKey($certPath)
    {
        $cert = file_get_contents($certPath);
        $pkey = openssl_pkey_get_public($cert);
        $keyData = openssl_pkey_get_details($pkey);
        $public_key = str_replace('-----BEGIN PUBLIC KEY-----', '', $keyData['key']);
        $public_key = trim(str_replace('-----END PUBLIC KEY-----', '', $public_key));
        return $public_key;
    }


    public static function splitCN($cont, $n = 0, $subnum) {
        $arrr = array();
        for ($i = $n; $i < strlen($cont); $i += $subnum) {
            $res = self::subCNchar($cont, $i, $subnum);
            if (!empty ($res)) {
                $arrr[] = $res;
            }
        }
        return $arrr;
    }

    public static  function subCNchar($str, $start = 0, $length) {
        if (strlen($str) <= $length) {
            return $str;
        }
        $re = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        preg_match_all($re, $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
        return $slice;
    }

    /***
     * @todo 根据私钥生成签名
     * @param $data
     * @param $keyPath
     * @return bool|string
     */
    public static function makeSignRsa2($data,$keyPath)
    {
        if(!extension_loaded('openssl')){
            return false;
        }
        $priKey = file_get_contents($keyPath);
        if(empty($priKey)){
            return false;
        }
        $res = openssl_get_privatekey($priKey);
        if(!$res){
            return false;
        }
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 加密方法
     * @param string $str
     * @return string
     */
    public static function encrypt($str,$screct_key){
        //AES, 128 模式加密数据 CBC
        $screct_key = base64_decode($screct_key);
        $str = trim($str);
        $str = self::addPKCS7Padding($str);

        //设置全0的IV
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC);
        $iv = str_repeat("\0", $iv_size);

        $encrypt_str = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $screct_key, $str, MCRYPT_MODE_CBC, $iv);
        return base64_encode($encrypt_str);
    }

    /**
     * 解密方法
     * @param string $str
     * @return string
     */
    public static function decrypt($str,$screct_key){
        //AES, 128 模式加密数据 CBC
        $str = base64_decode($str);
        $screct_key = base64_decode($screct_key);

        //设置全0的IV
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC);
        $iv = str_repeat("\0", $iv_size);

        $decrypt_str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $screct_key, $str, MCRYPT_MODE_CBC, $iv);
        $decrypt_str = self::stripPKSC7Padding($decrypt_str);
        return $decrypt_str;
    }

    /**
     * 填充算法
     * @param string $source
     * @return string
     */
    public static function addPKCS7Padding($source){
        $source = trim($source);
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        $pad = $block - (strlen($source) % $block);
        if ($pad <= $block) {
            $char = chr($pad);
            $source .= str_repeat($char, $pad);
        }
        return $source;
    }
    /**
     * 移去填充算法
     * @param string $source
     * @return string
     */
    public static function stripPKSC7Padding($source){
        $char = substr($source, -1);
        $num = ord($char);
        if($num==62)return $source;
        $source = substr($source,0,-$num);
        return $source;
    }

    public static function toUrlParams($values)
    {
        ksort($values);
        $buff = "";
        foreach ($values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}